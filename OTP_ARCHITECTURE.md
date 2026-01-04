# OTP System Architecture & Flow Diagrams

## System Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                   JobVerseBD Registration System                 │
│                   With OTP Email Verification                    │
└─────────────────────────────────────────────────────────────────┘

User Interface Layer (Frontend)
┌─────────────────────────────────────────────────────────────────┐
│ signinEmployerModals.php                                        │
│ ├─ Registration Form Modal (Employer/Seeker)                    │
│ └─ OTP Verification Modal (NEW)                                │
│    ├─ OTP Input Field                                          │
│    ├─ 2-Minute Timer Display                                   │
│    ├─ Verify OTP Button                                        │
│    └─ Resend OTP Button                                        │
└──────────────────┬──────────────────────────────────────────────┘
                   │
                   ↓ JavaScript Events
┌─────────────────────────────────────────────────────────────────┐
│ js/otpVerification.js (NEW)                                     │
│ ├─ handleRegistrationForm()                                     │
│ ├─ sendOTPRequest()                                             │
│ ├─ startOTPTimer()                                              │
│ ├─ verifyOTP()                                                  │
│ ├─ resendOTP()                                                  │
│ └─ completeRegistration()                                       │
└──────────────────┬──────────────────────────────────────────────┘
                   │
      AJAX POST/GET │
    ┌──────────────┴──────────────┐
    │                             │
    ↓                             ↓
┌──────────────┐          ┌──────────────┐
│ sendOTP.php  │          │verifyOTP.php │
│   (NEW)      │          │   (NEW)      │
└──────┬───────┘          └──────┬───────┘
       │                         │
       │ Store OTP              │ Verify OTP
       │ Send Email             │ Check Expiry
       │                        │ Mark Verified
       └──────────────┬─────────┘
                      │
                      ↓
        ┌────────────────────────┐
        │  Database Operations   │
        └────────────────────────┘
               │        │        │
        ┌──────┴──┐  ┌──┴──┐  ┌─┴─────────┐
        │          │  │     │  │           │
        ↓          ↓  ↓     ↓  ↓           ↓
   ┌─────────────────────────────────────────┐
   │      Database (jobportal)                │
   ├─────────────────────────────────────────┤
   │ otp_verification (NEW)                  │
   │ ├─ id, email, otp, user_type           │
   │ ├─ created_at, expires_at              │
   │ ├─ is_verified, attempts               │
   │ └─ Stores OTP records with 2-min TTL   │
   │                                         │
   │ employer                                │
   │ ├─ id, name, email, password           │
   │ └─ Password stored as bcrypt hash      │
   │                                         │
   │ seeker                                  │
   │ ├─ id, name, email, password           │
   │ ├─ qualification, dob, skills          │
   │ └─ Password stored as bcrypt hash      │
   └─────────────────────────────────────────┘
```

---

## Registration Flow Diagram

```
START
  │
  ├─→ User fills registration form
  │   (name, email, password, [seeker fields])
  │
  ├─→ User clicks "Create Account"
  │
  ├─→ Frontend Validation
  │   ├─ Check required fields ✓
  │   ├─ Check email format ✓
  │   ├─ Check password length ✓
  │   └─ Store in sessionStorage
  │
  ├─→ AJAX POST to sendOTP.php
  │   │
  │   ├─ Check if email exists
  │   │  ├─ If yes → Error "Email already registered"
  │   │  └─ If no  → Continue
  │   │
  │   ├─ Generate 6-digit OTP
  │   │
  │   ├─ Save to otp_verification table
  │   │  └─ expires_at = NOW() + 2 minutes
  │   │
  │   ├─ Send Email via PHPMailer
  │   │  ├─ Server: smtp.gmail.com:465
  │   │  ├─ Uses Gmail credentials
  │   │  └─ Email template with OTP
  │   │
  │   └─ Return JSON {status: "success"}
  │
  ├─→ Close Registration Modal
  │
  ├─→ Open OTP Verification Modal
  │   ├─ Show user's email
  │   ├─ Start 2-minute countdown timer
  │   └─ Enable OTP input field
  │
  ├─→ Wait for User Input (OTP)
  │   │
  │   ├─→ User receives OTP email
  │   ├─→ User enters 6-digit OTP
  │   │
  │   └─→ User clicks "Verify OTP"
  │
  ├─→ AJAX POST to verifyOTP.php
  │   │
  │   ├─ Query otp_verification table
  │   │
  │   ├─ Check if OTP matches
  │   │  ├─ If no  → Error "Invalid OTP" + retry
  │   │  └─ If yes → Continue
  │   │
  │   ├─ Check if OTP expired
  │   │  ├─ If yes → Error "OTP expired" + resend button
  │   │  └─ If no  → Continue
  │   │
  │   ├─ Mark OTP as verified
  │   │  └─ UPDATE otp_verification SET is_verified = 1
  │   │
  │   └─ Return JSON {status: "success"}
  │
  ├─→ Show "OTP verified successfully" message
  │
  ├─→ AJAX POST to registerEmployer/Seeker.php
  │   │
  │   ├─ Verify OTP is marked as verified
  │   │  └─ SELECT FROM otp_verification WHERE is_verified = 1
  │   │
  │   ├─ Insert into employer/seeker table
  │   │  ├─ name, email, bcrypt(password)
  │   │  ├─ [seeker: qualification, dob, skills]
  │   │  └─ Hash password using PASSWORD_BCRYPT
  │   │
  │   ├─ DELETE OTP record
  │   │  └─ Clean up after successful registration
  │   │
  │   └─ Return JSON {status: "success", redirect: "login"}
  │
  ├─→ Close OTP Modal
  │
  ├─→ Show Success Message
  │
  ├─→ Redirect to Login Page
  │
  └─→ END ✓ (Registration Complete)

ALTERNATIVE PATHS:

Path A: OTP Expires Before Entry
  │
  ├─ Timer reaches 0:00
  ├─ Input field becomes disabled
  ├─ "Resend OTP" button activates
  │
  ├─ User clicks "Resend OTP"
  │
  ├─ AJAX POST to sendOTP.php (again)
  │  └─ Creates NEW OTP record with fresh 2-min expiry
  │
  ├─ New OTP sent to email
  ├─ Timer resets to 2:00
  └─ User can enter new OTP

Path B: User Enters Wrong OTP
  │
  ├─ AJAX POST to verifyOTP.php
  ├─ Database rejects OTP match
  ├─ Show error "Invalid OTP"
  ├─ Increment attempts counter
  ├─ Keep modal open
  ├─ Timer still running
  └─ User can retry

Path C: Email Already Registered
  │
  ├─ sendOTP.php checks employer/seeker tables
  ├─ Finds matching email
  ├─ Returns error "Email already registered"
  ├─ OTP NOT sent
  └─ User cannot proceed
```

---

## Timer Countdown System

```
START (2 minutes = 120 seconds)
│
├─ 2:00 ─→ setInterval fires every 1 second
│  │      timeRemaining--
│  │      updateTimerDisplay()
│  │
│  ├─ 1:59
│  ├─ 1:58
│  ├─ 1:57
│  │ ... (continues)
│  │
│  ├─ 0:02
│  ├─ 0:01
│  │
│  └─ 0:00 ─→ clearInterval()
│            │
│            ├─ handleOTPExpiration()
│            ├─ Disable OTP input
│            ├─ Disable Verify button
│            ├─ Enable Resend button
│            └─ Show "OTP expired" message
│
└─ User can now:
   ├─ Click "Resend OTP" → New 2:00 timer
   └─ Close modal → Restart registration
```

---

## Database Record Lifecycle

```
Step 1: OTP Generation (sendOTP.php)
┌──────────────────────────────────────┐
│ INSERT INTO otp_verification VALUES  │
├──────────────────────────────────────┤
│ id: AUTO_INCREMENT                   │
│ email: user@example.com              │
│ otp: 473829                          │
│ user_type: 'employer'                │
│ created_at: 2024-01-04 12:00:00     │
│ expires_at: 2024-01-04 12:02:00     │
│ is_verified: 0                       │
│ attempts: 0                          │
└──────────────────────────────────────┘
         │
         ↓ (User enters OTP within 2 min)
         │
Step 2: OTP Verification (verifyOTP.php)
┌──────────────────────────────────────┐
│ UPDATE otp_verification SET          │
│ is_verified = 1                      │
│ WHERE email = 'user@example.com'     │
│ AND otp = '473829'                   │
│ AND user_type = 'employer'           │
└──────────────────────────────────────┘
         │
         ↓ (Registration completes)
         │
Step 3: Record Cleanup (registerEmployer.php)
┌──────────────────────────────────────┐
│ DELETE FROM otp_verification         │
│ WHERE email = 'user@example.com'     │
│ AND user_type = 'employer'           │
└──────────────────────────────────────┘
         │
         ↓
    RECORD DELETED
    (Total lifetime: ~30 seconds)


Alternative Path: OTP Expires
┌──────────────────────────────────────┐
│ SELECT FROM otp_verification         │
│ WHERE expires_at < NOW()             │
└──────────────────────────────────────┘
         │
         ↓ (Optional cleanup)
         │
    Can DELETE expired records
    Or keep for audit trail
```

---

## Email Sending Process

```
User submits registration form
         │
         ↓
sendOTP.php called
         │
         ├─ Instantiate PHPMailer
         │
         ├─ Configure SMTP
         │  ├─ Host: smtp.gmail.com
         │  ├─ Port: 465 (SSL/TLS)
         │  ├─ SMTPAuth: true
         │  ├─ Username: your-email@gmail.com
         │  └─ Password: app-password
         │
         ├─ Set From: your-email@gmail.com
         │
         ├─ Set To: user@example.com
         │
         ├─ Compose HTML Email
         │  ├─ Subject: Your JobVerseBD OTP for Registration
         │  ├─ Body with HTML formatting
         │  ├─ Display 6-digit OTP prominently
         │  └─ Include branding and security notice
         │
         ├─ $mail->send()
         │  │
         │  ├─ Success → Return JSON {status: "success"}
         │  │              │
         │  │              └─ Show OTP modal with timer
         │  │
         │  └─ Error → Return JSON {status: "error"}
         │             └─ Show error message to user
         │
         └─ Email delivered to inbox
```

---

## Security Flow

```
User Input (Plain Password)
         │
         ├─ Frontend Validation
         │  ├─ Check format ✓
         │  ├─ Check length ✓
         │  └─ Store in sessionStorage (temporary)
         │
         ├─ Send to PHP via HTTPS (recommended)
         │
         ├─ Backend Processing
         │  ├─ Validate email format ✓
         │  ├─ Check if email exists ✓
         │  ├─ Hash password with bcrypt
         │  │  └─ password_hash($pwd, PASSWORD_BCRYPT)
         │  │     Result: $2y$10$...hash...
         │  │
         │  ├─ Generate 6-digit random OTP
         │  │  └─ random_int(0, 999999)
         │  │
         │  └─ Store in database
         │     ├─ Password: Hashed (never plain text)
         │     ├─ OTP: Plain (valid for 2 min only)
         │     └─ Deleted after verification
         │
         ├─ Email Transmission (SMTP/SSL)
         │  └─ OTP sent securely
         │
         ├─ Database Storage
         │  ├─ Password: Bcrypt hash (cryptographically secure)
         │  └─ Cannot be reversed to plain text
         │
         └─ Login (Later)
            ├─ User enters: plain password
            ├─ System calls: password_verify($plain, $hash)
            ├─ Returns: true/false
            └─ Secure comparison ✓
```

---

## Component Interaction Map

```
                    ┌─────────────────┐
                    │  User Browser   │
                    │   (JavaScript)  │
                    └────────┬────────┘
                             │
          ┌──────────────────┼──────────────────┐
          │                  │                  │
          ↓                  ↓                  ↓
    ┌────────────┐   ┌───────────────┐  ┌──────────────┐
    │Registration│   │ OTP Modal UI  │  │   Timer      │
    │  Form      │   │  (Listener)   │  │  (Counter)   │
    │            │   │               │  │              │
    │ - name     │   │ - Input field │  │ - 2:00 →     │
    │ - email    │   │ - Verify btn  │  │   0:00       │
    │ - password │   │ - Resend btn  │  │              │
    │ - (seeker) │   │ - Errors      │  │ Events:      │
    └──────┬─────┘   └───────┬───────┘  │ - Every 1s   │
           │                 │          │ - Expiry     │
           │                 │          └──┬───────────┘
           │                 │             │
           └────────┬────────┴─────────────┘
                    │
         js/otpVerification.js
         (Main Controller)
         │
         ├─ handleRegistrationForm()
         ├─ sendOTPRequest() ────→ sendOTP.php
         ├─ startOTPTimer()
         ├─ verifyOTP() ─────────→ verifyOTP.php
         ├─ resendOTP() ─────────→ sendOTP.php
         └─ completeRegistration() → registerEmployer/Seeker.php
                    │
         ┌──────────┼──────────┐
         │          │          │
         ↓          ↓          ↓
    ┌─────────┐ ┌─────────┐ ┌──────────────┐
    │ sendOTP │ │verifyOTP│ │ registerXXXX │
    │ .php    │ │ .php    │ │ .php         │
    │ (NEW)   │ │ (NEW)   │ │ (MODIFIED)   │
    │         │ │         │ │              │
    │ - OTP   │ │- OTP    │ │ - Verify OTP │
    │   gen   │ │  check  │ │   status     │
    │ - Email │ │ - Timer │ │ - Insert     │
    │   send  │ │  check  │ │   user       │
    │ - Save  │ │ - Mark  │ │ - Hash pwd   │
    │   to DB │ │  valid  │ │ - Clean OTP  │
    └────┬────┘ └────┬────┘ └──────┬───────┘
         │           │             │
         └───────────┼─────────────┘
                     │
                ┌────┴─────┐
                │           │
                ↓           ↓
         ┌────────────────────────┐
         │   Database            │
         │  (jobportal)          │
         ├────────────────────────┤
         │ otp_verification (NEW) │
         │ employer (MODIFIED)    │
         │ seeker (MODIFIED)      │
         └────────────────────────┘
```

---

## Error Handling Flow

```
Registration Request
         │
    ┌────┴─────────────────────┐
    │                           │
    ↓                           ↓
Check Email       Check Form Fields
    │                     │
    ├─ Valid ✓           ├─ All filled ✓
    │ ↓                  │ ↓
    │ Check if exists    Check formats ✓
    │ │                  │ ↓
    │ ├─ No ✓ ────────→  Send OTP
    │ │
    │ └─ Yes ✗
    │   └─→ Error: "Email already registered"
    │       └─→ Don't send OTP
    │           └─→ User must login instead
    │
    └─ Invalid ✗
      └─→ Error: "Invalid email format"
          └─→ User must correct and retry

OTP Verification Error Handling
         │
    ┌────┴──────────────────────┐
    │                            │
    ↓                            ↓
OTP Matches?            OTP Expired?
    │                       │
    ├─ Yes ✓               ├─ No ✓ 
    │ └─→ Mark verified    │ └─→ Mark verified
    │                      │
    └─ No ✗                └─ Yes ✗
      └─→ Error: "Invalid OTP"   └─→ Error: "OTP expired"
          └─→ Increment attempts      └─→ Show Resend button
              └─→ Allow retry          └─→ Request new OTP

Registration Error Handling
         │
    ┌────┴──────────────────────┐
    │                            │
    ↓                            ↓
OTP Verified?            Insert Success?
    │                       │
    ├─ Yes ✓               ├─ Yes ✓
    │ └─→ Insert           │ └─→ Delete OTP record
    │     record           │ └─→ Success message
    │                      │ └─→ Redirect to login
    │                      │
    └─ No ✗                └─ No ✗
      └─→ Error:            └─→ Error: "Database error"
          "Invalid verification"  └─→ Allow retry
          └─→ Request OTP again       └─→ Contact support
```

---

## Key Metrics & Performance

```
Operation Timing:
┌────────────────────────────────┐
│ Operation        │ Expected    │
├────────────────────────────────┤
│ Form submission  │ < 1 sec     │
│ OTP generation   │ < 1 sec     │
│ Email send       │ 2-5 secs    │
│ User receives    │ 5-30 secs   │
│ OTP entry        │ 30+ secs    │
│ OTP verification │ < 1 sec     │
│ Registration     │ < 1 sec     │
│ Redirect/render  │ < 2 secs    │
├────────────────────────────────┤
│ Total flow       │ ~1-2 min    │
└────────────────────────────────┘

Database Operations:
├─ INSERT (OTP)     ~ 10ms
├─ SELECT (OTP)     ~ 10ms
├─ UPDATE (verified)~ 10ms
├─ INSERT (user)    ~ 20ms
└─ DELETE (OTP)     ~ 10ms

Timer Accuracy:
├─ JavaScript timer: ±50ms drift per minute
├─ Server time-based: ±0ms (reliable)
└─ Combined approach: Most accurate

Scalability:
├─ 100 users/min: No issues
├─ 1000 users/min: Monitor DB
└─ 10000 users/min: Add read replica, cache OTPs
```

---

This architecture ensures:
✅ **Security** - OTP expires, passwords hashed, email verified
✅ **Reliability** - Multiple error paths handled
✅ **Performance** - Most operations < 1 second
✅ **UX** - Clear feedback, timer visible, easy resend
