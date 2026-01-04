# OTP Implementation Checklist & Testing Guide

## Pre-Implementation Checklist

- [ ] Backup your current database
- [ ] Backup `registerEmployer.php`
- [ ] Backup `registerJobseeker.php`
- [ ] Backup `signinEmployerModals.php`
- [ ] Backup `js/` folder

---

## Implementation Steps

### Step 1: Database Setup (5 minutes)

- [ ] Open phpMyAdmin
- [ ] Select your `jobportal` database
- [ ] Go to "SQL" tab
- [ ] Copy and run the SQL from `database/otp_verification.sql`
- [ ] Verify table created: Check "Tables" list for `otp_verification`

**SQL to run:**
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

### Step 2: Email Configuration (3 minutes)

- [ ] Open `sendOTP.php`
- [ ] Find line ~38: `$mail->Username = ...`
- [ ] Replace with your Gmail address: `$mail->Username = 'your-email@gmail.com';`
- [ ] Find line ~39: `$mail->Password = ...`
- [ ] Replace with your App Password: `$mail->Password = 'your-app-password';`
- [ ] Save file

**How to get Gmail App Password:**
1. Go to https://myaccount.google.com/
2. Click "Security" (left sidebar)
3. Scroll to "How you sign in to Google"
4. Click "App passwords"
5. Select "Mail" and "Windows/Mac/Linux"
6. Copy the 16-character password
7. Use it in step 2 above

### Step 3: Verify File Placement (2 minutes)

Confirm all files are in correct locations:

- [ ] `sendOTP.php` - Root directory (JobVerseBD/)
- [ ] `verifyOTP.php` - Root directory (JobVerseBD/)
- [ ] `js/otpVerification.js` - In js/ folder
- [ ] `registerEmployer.php` - Root directory (already modified)
- [ ] `registerJobseeker.php` - Root directory (already modified)
- [ ] `signinEmployerModals.php` - Root directory (already modified)
- [ ] `database/otp_verification.sql` - In database/ folder
- [ ] Documentation files created

---

## Testing Phase

### Test 1: Database Connection

**Objective**: Verify database table exists and is accessible

- [ ] Go to phpMyAdmin
- [ ] Select `jobportal` database
- [ ] Find `otp_verification` table in list
- [ ] Click it → Verify all columns are present:
  - [ ] id
  - [ ] email
  - [ ] otp
  - [ ] user_type
  - [ ] created_at
  - [ ] expires_at
  - [ ] is_verified
  - [ ] attempts

### Test 2: Email Configuration

**Objective**: Test email sending capability

- [ ] Open browser to your site
- [ ] Use browser DevTools → Network tab
- [ ] Try employer registration with test email
- [ ] Watch for POST to `sendOTP.php`
- [ ] Check inbox for OTP email
  - [ ] Email received
  - [ ] Email shows 6-digit OTP
  - [ ] Email is from JobVerseBD

### Test 3: Employer Registration - Valid Flow

**Objective**: Complete registration with valid OTP

**Setup:**
- Have test email ready (e.g., testemployer@gmail.com)
- Have browser DevTools open (F12)

**Steps:**
- [ ] Click Sign In → Register Now
- [ ] Click "Employer Register" tab
- [ ] Fill form:
  - [ ] Username: `TestCo`
  - [ ] Email: `testemployer@gmail.com`
  - [ ] Password: `Test@123`
- [ ] Click "Create Account"
- [ ] Verify OTP Modal appears:
  - [ ] Shows email address
  - [ ] Shows "2:00" timer
  - [ ] OTP input field visible
- [ ] Check email inbox → Copy OTP
- [ ] Paste OTP into input field (only numbers)
- [ ] Click "Verify OTP"
- [ ] Verify success:
  - [ ] "OTP verified successfully" message
  - [ ] Redirect to login page
  - [ ] Can login with new credentials

**Database Check:**
- [ ] Open phpMyAdmin
- [ ] Check `employer` table → New record with testemployer@gmail.com
- [ ] Check `otp_verification` table → Record should be deleted

### Test 4: Job Seeker Registration - Valid Flow

**Objective**: Complete job seeker registration with valid OTP

**Setup:**
- Have test email ready (e.g., testseeker@gmail.com)
- Have current date ready for DOB field

**Steps:**
- [ ] Click Sign In → Register Now
- [ ] Click "Job Seeker Register" tab
- [ ] Fill form:
  - [ ] Username: `TestSeeker`
  - [ ] Email: `testseeker@gmail.com`
  - [ ] Password: `Test@123`
  - [ ] Qualification: `Bachelor's Degree`
  - [ ] Date of Birth: Select a date
  - [ ] Skills: `JavaScript, PHP, MySQL`
- [ ] Click "Create Account"
- [ ] Verify OTP Modal appears
- [ ] Check email → Copy OTP
- [ ] Paste OTP into input
- [ ] Click "Verify OTP"
- [ ] Verify success:
  - [ ] "OTP verified successfully" message
  - [ ] Redirect to login page
  - [ ] Can login with new credentials

**Database Check:**
- [ ] Check `seeker` table → New record with testseeker@gmail.com
- [ ] Check `otp_verification` table → Record should be deleted

### Test 5: Invalid OTP Entry

**Objective**: Verify error handling for wrong OTP

**Steps:**
- [ ] Start employer registration
- [ ] Fill form and click "Create Account"
- [ ] OTP Modal appears, receive OTP email
- [ ] **Intentionally enter wrong OTP** (e.g., 000000)
- [ ] Click "Verify OTP"
- [ ] Verify error:
  - [ ] Shows "Invalid OTP" message in red
  - [ ] Modal stays open
  - [ ] Timer still running
  - [ ] Can try again

### Test 6: OTP Expiration & Resend

**Objective**: Test 2-minute timer and auto-resend

**Steps:**
- [ ] Start registration
- [ ] Get OTP Modal (don't enter OTP)
- [ ] Watch timer count down from 2:00
- [ ] Verify timer shows MM:SS format
- [ ] At 0:00:
  - [ ] Timer stops
  - [ ] OTP input becomes disabled
  - [ ] "Verify OTP" button becomes disabled
  - [ ] "Resend OTP" button becomes active
- [ ] Click "Resend OTP"
- [ ] Check email for new OTP
  - [ ] New email received
  - [ ] Different OTP code
  - [ ] Timer resets to 2:00
- [ ] Enter new OTP
- [ ] Click "Verify OTP"
- [ ] Verify success and registration completes

### Test 7: Form Validation

**Objective**: Verify form field validation

**Test 7a: Missing fields**
- [ ] Try to register without username → Should show error
- [ ] Try to register without email → Should show error
- [ ] Try to register without password → Should show error
- [ ] For seeker: Missing qual/dob/skills → Should show error

**Test 7b: Invalid email**
- [ ] Enter `notanemail` → Should show "Invalid email" error
- [ ] Enter `test@` → Should show error
- [ ] Enter nothing → Required error

**Test 7c: Email already exists**
- [ ] Try registering with an email you already registered
- [ ] Should receive: "Email already registered" error
- [ ] OTP not sent

**Test 7d: OTP field validation**
- [ ] OTP input should only accept numbers
- [ ] Try typing letters → Should not appear
- [ ] Max length 6 digits

### Test 8: Session Storage

**Objective**: Verify registration data is stored properly

**Steps:**
- [ ] Open DevTools → Storage → Session Storage
- [ ] Start registration (fill form, click Create Account)
- [ ] Go to Session Storage → Find `registrationData` key
- [ ] Verify it contains:
  - [ ] name
  - [ ] email
  - [ ] password
  - [ ] userType
  - [ ] (qlf, dob, skills for seeker)
- [ ] After OTP verification and redirect, storage should be cleared

### Test 9: Database Cleanup

**Objective**: Verify OTP records are cleaned up

**Steps:**
- [ ] Before: Check `otp_verification` table (note row count)
- [ ] Complete registration with OTP
- [ ] After: Check table again
- [ ] Verify: Old OTP record should be deleted
- [ ] Only non-verified OTPs should remain

### Test 10: Cross-Browser Testing

Test in multiple browsers:
- [ ] Chrome
- [ ] Firefox
- [ ] Edge
- [ ] Safari (if available)

For each browser, verify:
- [ ] OTP Modal displays correctly
- [ ] Timer counts down properly
- [ ] All buttons functional
- [ ] No console errors

---

## Functionality Verification Matrix

| Feature | Employer | Seeker | Status |
|---------|----------|--------|--------|
| OTP Generated | [ ] | [ ] | ✓ |
| OTP Email Sent | [ ] | [ ] | ✓ |
| 2-Min Timer | [ ] | [ ] | ✓ |
| OTP Verification | [ ] | [ ] | ✓ |
| Resend OTP | [ ] | [ ] | ✓ |
| Auto Expiry | [ ] | [ ] | ✓ |
| Registration Complete | [ ] | [ ] | ✓ |
| OTP Deleted | [ ] | [ ] | ✓ |
| Error Handling | [ ] | [ ] | ✓ |
| Form Validation | [ ] | [ ] | ✓ |

---

## Performance Checklist

- [ ] Page loads without hanging
- [ ] OTP sent within 5 seconds
- [ ] Registration completes within 10 seconds
- [ ] No memory leaks (check DevTools)
- [ ] Timer doesn't drift/lag
- [ ] No console errors or warnings

---

## Security Verification

- [ ] Passwords stored as bcrypt hash (not plain text)
  - [ ] Check database: password field shows `$2y$...` format
- [ ] OTP is 6 random digits
- [ ] OTP expires after 2 minutes
- [ ] OTP records deleted after use
- [ ] Email validation prevents typos
- [ ] Session storage used (not localStorage)
- [ ] HTTPS recommended for production

---

## Common Issues & Fixes

| Issue | Cause | Fix |
|-------|-------|-----|
| OTP not received | Wrong email config | Update `sendOTP.php` with correct Gmail/password |
| Timer not counting | JS not loaded | Check `otpVerification.js` loaded in page |
| Modal doesn't open | Bootstrap issue | Verify Bootstrap jQuery loaded |
| "Email already registered" | Email exists | Check employer/seeker tables |
| Server 500 error | DB connection issue | Check `connect.php` credentials |

---

## After Implementation

- [ ] Document in your project wiki
- [ ] Inform users about new OTP requirement
- [ ] Monitor error logs for issues
- [ ] Get user feedback
- [ ] Consider rate limiting OTP requests (optional)
- [ ] Plan SMS OTP addition (optional)

---

## Production Deployment Checklist

Before going live:
- [ ] All tests passed
- [ ] Email credentials updated with production email
- [ ] HTTPS enabled
- [ ] Database backed up
- [ ] Error logging enabled
- [ ] User documentation prepared
- [ ] Support team trained
- [ ] Rollback plan documented

---

## Support Resources

- **Full Documentation**: `OTP_VERIFICATION_GUIDE.md`
- **Quick Start**: `OTP_QUICK_START.md`
- **Database Schema**: Check `database/otp_verification.sql`
- **JavaScript**: See `js/otpVerification.js` for function details
- **PHP**: See `sendOTP.php` and `verifyOTP.php` for API logic

---

## Sign-Off

- [ ] All tests completed successfully
- [ ] Ready for production deployment
- [ ] Date: _______________
- [ ] Tester: _______________

---

**Congratulations!** Your OTP Email Verification System is ready! 🎉
