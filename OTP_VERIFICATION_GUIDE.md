# OTP Email Verification System - Implementation Guide

## Overview
This guide explains the OTP (One-Time Password) email verification system implemented for employer and job seeker registration in JobVerseBD.

## Features
- **Email OTP Generation**: A 6-digit OTP is generated and sent to user's email
- **2-Minute Timer**: Users have 2 minutes to verify their OTP
- **Auto-Resend**: If the 2-minute timer expires, users can request a new OTP
- **Email Verification**: Registration only completes after successful OTP verification
- **Security**: Passwords are hashed using bcrypt for enhanced security

---

## Installation Steps

### Step 1: Create the OTP Database Table

Run the following SQL query in your phpMyAdmin or MySQL client:

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

Alternatively, you can import the file: `database/otp_verification.sql`

### Step 2: Verify Email Configuration

Make sure your `sendOTP.php` has the correct Gmail credentials:

```php
$mail->Username = 'your-email@gmail.com';      // Your Gmail address
$mail->Password = 'your-app-password';          // Your app password
```

**Important**: Use a Gmail App Password, not your regular password. [Learn how to generate one](https://support.google.com/accounts/answer/185833)

### Step 3: Files Created/Modified

The following files have been created or modified:

#### New Files:
1. **sendOTP.php** - Generates and sends OTP via email
2. **verifyOTP.php** - Verifies OTP and handles expiration
3. **js/otpVerification.js** - Frontend JavaScript for OTP flow
4. **database/otp_verification.sql** - Database table creation script

#### Modified Files:
1. **registerEmployer.php** - Updated to use OTP verification
2. **registerJobseeker.php** - Updated to use OTP verification
3. **signinEmployerModals.php** - Added OTP verification modal

---

## How It Works

### Registration Flow

```
User submits registration form
        ↓
System validates form data
        ↓
OTP is generated and sent to email (sendOTP.php)
        ↓
OTP Modal displayed with 2-min timer
        ↓
User enters OTP
        ↓
System verifies OTP (verifyOTP.php)
        ↓
If valid & not expired:
    - Mark OTP as verified
    - Complete registration
    - Delete OTP record
    ↓
If invalid:
    - Show error message
    - Allow retry
    ↓
If expired:
    - Offer to resend OTP
    - Generate new OTP & timer
```

### File Responsibilities

#### **sendOTP.php**
- **Purpose**: Generate and send OTP
- **Method**: POST
- **Input Parameters**:
  - `email` - User's email address
  - `user_type` - 'employer' or 'seeker'
- **Process**:
  1. Validates email format
  2. Checks if email already registered
  3. Generates random 6-digit OTP
  4. Saves OTP to database with 2-minute expiry
  5. Sends email via PHPMailer
- **Response**: JSON with status and message

#### **verifyOTP.php**
- **Purpose**: Verify user-entered OTP
- **Methods**: 
  - **POST** - Verify the OTP
  - **GET** - Check OTP expiration status
- **POST Parameters**:
  - `email` - User's email
  - `otp` - 6-digit OTP entered by user
  - `user_type` - 'employer' or 'seeker'
- **Process**:
  1. Checks if OTP matches database record
  2. Validates OTP hasn't expired
  3. Marks OTP as verified on success
  4. Increments attempts on failure
- **Response**: JSON with status and message

#### **registerEmployer.php & registerJobseeker.php**
- **Previous**: Direct registration without verification
- **Now**: 
  1. Validates OTP verification status
  2. Checks if OTP is marked as verified in database
  3. Only creates account if verified
  4. Uses bcrypt for password hashing
  5. Clears OTP record after successful registration
- **Security**: Returns JSON errors for better error handling

#### **js/otpVerification.js**
- **Purpose**: Frontend OTP verification logic
- **Key Functions**:
  - `handleRegistrationForm()` - Intercepts form submission
  - `sendOTPRequest()` - Sends OTP request
  - `startOTPTimer()` - Manages 2-minute countdown
  - `verifyOTP()` - Verifies entered OTP
  - `resendOTP()` - Requests new OTP
  - `completeRegistration()` - Final registration after OTP verification
- **Features**:
  - Only accepts numeric input in OTP field
  - Real-time countdown timer display
  - Disables inputs after expiration
  - Stores registration data in sessionStorage
  - Handles all edge cases

#### **signinEmployerModals.php**
- **Changes**: Added `otpVerificationModal` div
- **UI Components**:
  - Email display (masked partially)
  - 6-digit OTP input field
  - Countdown timer (MM:SS format)
  - Verify OTP button
  - Resend OTP button with message display

---

## User Experience Flow

### For Employer Registration:
1. Click "Register Now" in Sign In modal
2. Click on "Employer Register" tab
3. Fill in: Username, Email, Password
4. Click "Create Account"
5. **OTP Modal appears**:
   - User sees their email
   - 2-minute countdown starts
   - User enters 6-digit OTP
   - Click "Verify OTP"
6. On success: Account created, redirected to login

### For Job Seeker Registration:
1. Click "Register Now" in Sign In modal
2. Click on "Job Seeker Register" tab
3. Fill in: Username, Email, Password, Qualification, DOB, Skills
4. Click "Create Account"
5. **OTP Modal appears**: (Same as above)
6. On success: Account created, redirected to login

### On OTP Expiration:
- Timer reaches 0:00
- Input fields become disabled
- "Resend OTP" button becomes active
- Click "Resend OTP" to get a new 2-minute timer

---

## Email Template

The OTP email template is professionally formatted with:
- HTML-based design
- Company branding (JobVerseBD)
- Clear OTP display
- Security warnings
- Professional styling

---

## Security Features

1. **OTP Generation**: Random 6-digit number (000000-999999)
2. **Password Hashing**: bcrypt algorithm (not plain text)
3. **Time-based Expiry**: 2-minute expiration timer
4. **Email Verification**: Prevents fake email registration
5. **OTP Attempts Tracking**: Tracks number of verification attempts
6. **Database Cleanup**: OTP records deleted after successful registration
7. **SQL Prepared Statements**: (Recommended upgrade to prevent injection)

---

## API Endpoints

### Send OTP
```
POST /sendOTP.php
Content-Type: application/x-www-form-urlencoded

Parameters:
- email=user@example.com
- user_type=employer|seeker

Response:
{
  "status": "success|error",
  "message": "Description",
  "email": "user@example.com",
  "user_type": "employer"
}
```

### Verify OTP
```
POST /verifyOTP.php
Content-Type: application/x-www-form-urlencoded

Parameters:
- email=user@example.com
- otp=123456
- user_type=employer|seeker

Response:
{
  "status": "success|error",
  "message": "Description",
  "expired": true|false
}
```

### Check OTP Status
```
GET /verifyOTP.php?email=user@example.com&user_type=employer

Response:
{
  "status": "active|expired|error",
  "message": "Description",
  "time_remaining": 45,
  "expires_at": "2024-01-04 14:30:00"
}
```

---

## Troubleshooting

### Issue: OTP Email Not Received
- **Check**: Gmail credentials in `sendOTP.php`
- **Check**: App Password (not regular password)
- **Check**: Email isn't being filtered to Spam
- **Check**: Server has internet connection

### Issue: Timer Not Counting Down
- **Check**: Browser console for JavaScript errors
- **Check**: `otpVerification.js` is loaded
- **Check**: jQuery is loaded before `otpVerification.js`

### Issue: "Email Already Registered" Error
- **Fix**: The email is already in the employer/seeker table
- **Solution**: Use different email or contact admin to delete old account

### Issue: OTP Expired Message When Time Remains
- **Fix**: Server time might be out of sync
- **Solution**: Check server system time
- **Solution**: Adjust `expires_at` timestamp generation

### Issue: Registration Modal Doesn't Close After OTP Verification
- **Check**: No JavaScript errors in console
- **Check**: Bootstrap modal version compatibility
- **Fix**: Ensure correct modal IDs in JavaScript

---

## Database Schema

```sql
Table: otp_verification

Columns:
- id (INT, Primary Key, Auto Increment)
- email (VARCHAR 255) - User's email address
- otp (VARCHAR 6) - 6-digit OTP
- user_type (ENUM) - 'employer' or 'seeker'
- created_at (TIMESTAMP) - When OTP was created
- expires_at (TIMESTAMP) - When OTP expires (created_at + 2 minutes)
- is_verified (TINYINT) - 0=not verified, 1=verified
- attempts (INT) - Number of verification attempts

Indexes:
- PRIMARY KEY (id)
- KEY (email)
- KEY (expires_at)
- KEY (email, user_type)
```

---

## Optional Enhancements

1. **Rate Limiting**: Limit OTP requests per email (e.g., max 3 per hour)
2. **SMS OTP**: Add SMS option in addition to email
3. **OTP History**: Keep audit log of all OTP attempts
4. **Captcha**: Add captcha before sending OTP
5. **Prepared Statements**: Convert queries to prepared statements
6. **Email Templates**: Create separate template files
7. **Multi-language Support**: Translate OTP email content
8. **Two-Factor Auth**: Use OTP for login 2FA as well

---

## Testing Checklist

- [ ] Database table created successfully
- [ ] Gmail credentials configured correctly
- [ ] OTP emails received successfully
- [ ] 2-minute timer counts down correctly
- [ ] OTP verification works with valid OTP
- [ ] Invalid OTP shows error message
- [ ] Expired OTP shows expiration message
- [ ] Resend OTP works and resets timer
- [ ] Registration completes after OTP verification
- [ ] OTP record deleted after registration
- [ ] Employer and Seeker flows both work
- [ ] Form validation works before OTP request
- [ ] Modal transitions smooth and error-free

---

## Support

For issues or questions:
1. Check the Troubleshooting section above
2. Check browser console for JavaScript errors
3. Check server error logs
4. Verify all files are in correct locations
5. Test email sending with verification email

---

## Version History

- **v1.0** (Jan 4, 2024) - Initial implementation with 2-minute timer and auto-resend feature
