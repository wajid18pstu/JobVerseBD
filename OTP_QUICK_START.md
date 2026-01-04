# OTP Email Verification - Quick Setup

## What Was Implemented

✅ **OTP Email Authentication System** for employer and job seeker registration with:
- 6-digit OTP sent to email
- 2-minute countdown timer
- Automatic OTP resend after expiration
- Secure registration flow

---

## Files Created

1. **sendOTP.php** - Generates & sends OTP via email
2. **verifyOTP.php** - Verifies OTP and handles expiration
3. **js/otpVerification.js** - Frontend timer & verification logic
4. **database/otp_verification.sql** - Database table
5. **OTP_VERIFICATION_GUIDE.md** - Full documentation

## Files Modified

1. **registerEmployer.php** - Now requires OTP verification
2. **registerJobseeker.php** - Now requires OTP verification  
3. **signinEmployerModals.php** - Added OTP modal UI

---

## Installation (2 Steps)

### Step 1: Create Database Table

Run this SQL in phpMyAdmin:

```sql
CREATE TABLE IF NOT EXISTS `otp_verification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `otp` varchar(6) NOT NULL,
  `user_type` enum('employer', 'seeker') NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `expires_at` timestamp NULL DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `attempts` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `expires_at` (`expires_at`),
  KEY `idx_email_type` (`email`, `user_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

Or import: `database/otp_verification.sql`

### Step 2: Verify Email Configuration

Update email credentials in `sendOTP.php` (around line 38):

```php
$mail->Username = 'your-email@gmail.com';      // Your Gmail
$mail->Password = 'your-app-password';          // App password, NOT regular password
```

**Get Gmail App Password**: Settings → Security → App passwords

---

## How It Works

```
User Registration Form
        ↓
Enter email → Click "Create Account"
        ↓
OTP sent to email
        ↓
2-minute timer countdown
        ↓
User enters OTP
        ↓
If valid: Account created ✓
If invalid: Show error, allow retry
If expired: Button changes to "Resend OTP" →
New OTP sent & timer resets
```

---

## User Registration Flow

### Employer Registration:
1. Open Sign In modal → Click "Register Now"
2. Click "Employer Register" tab
3. Fill: Username, Email, Password
4. Click "Create Account"
5. **OTP Modal Opens** → Enter 6-digit OTP
6. Click "Verify OTP"
7. Registration complete ✓

### Job Seeker Registration:
1. Open Sign In modal → Click "Register Now"
2. Click "Job Seeker Register" tab
3. Fill: Username, Email, Password, Qualification, DOB, Skills
4. Click "Create Account"
5. **OTP Modal Opens** → Enter 6-digit OTP
6. Click "Verify OTP"
7. Registration complete ✓

---

## Key Features

✅ **Email Verification** - Prevents fake/typo emails
✅ **2-Minute Timer** - Countdown displayed in MM:SS format
✅ **Auto-Resend** - New OTP automatically after 2 min expiry
✅ **Secure Passwords** - Bcrypt hashing (no plain text)
✅ **Better UX** - Clear error messages & instructions
✅ **Session Storage** - Temporary data storage for registration
✅ **Input Validation** - Only numbers accepted in OTP field
✅ **Security** - OTP records auto-deleted after registration

---

## Testing

1. **Test Employer Registration**:
   - Fill form → Get OTP email
   - Enter OTP → Should register

2. **Test Job Seeker Registration**:
   - Fill form → Get OTP email
   - Enter OTP → Should register

3. **Test OTP Expiration**:
   - Wait 2 minutes → Timer expires
   - Click "Resend OTP" → New OTP sent

4. **Test Invalid OTP**:
   - Enter wrong OTP → Error message
   - Try again with correct OTP

---

## Troubleshooting

| Issue | Solution |
|-------|----------|
| OTP email not received | Check Gmail credentials & app password in `sendOTP.php` |
| Timer not showing | Check browser console for JS errors |
| Can't verify valid OTP | Check server time synchronization |
| "Email already registered" | Email exists in employer/seeker table |
| Modal doesn't close | Ensure Bootstrap jQuery loaded |

---

## API Endpoints

**Send OTP:**
```
POST sendOTP.php
Data: email=user@email.com&user_type=employer
```

**Verify OTP:**
```
POST verifyOTP.php
Data: email=user@email.com&otp=123456&user_type=employer
```

---

## Security Notes

⚠️ **Important:**
- Use Gmail **App Password**, not regular password
- Passwords are hashed with bcrypt (not stored plain text)
- OTP expires after 2 minutes
- OTP records deleted after successful registration
- Email uniqueness checked before sending OTP

---

## Files Location Reference

```
JobVerseBD/
├── sendOTP.php                          ← NEW
├── verifyOTP.php                        ← NEW
├── registerEmployer.php                 ← MODIFIED
├── registerJobseeker.php                ← MODIFIED
├── signinEmployerModals.php             ← MODIFIED
├── js/
│   └── otpVerification.js               ← NEW
├── database/
│   └── otp_verification.sql             ← NEW
└── OTP_VERIFICATION_GUIDE.md            ← NEW (Full Documentation)
```

---

## Next Steps

1. ✅ Create database table (SQL provided)
2. ✅ Update Gmail credentials in `sendOTP.php`
3. ✅ Test employer registration
4. ✅ Test job seeker registration
5. ✅ Test OTP expiration & resend
6. ✅ Deploy to production

---

## Need Help?

Refer to: `OTP_VERIFICATION_GUIDE.md` for detailed documentation
