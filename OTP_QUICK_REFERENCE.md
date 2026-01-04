# OTP System - Quick Reference Card

## 🎯 One-Minute Overview

```
User fills registration form
         ↓
Click "Create Account"
         ↓
OTP sent to email (2 min timer)
         ↓
User enters 6-digit OTP
         ↓
Registration complete ✓
```

---

## 🚀 Setup (Copy-Paste)

### Step 1: Create Database Table

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

### Step 2: Update sendOTP.php (Line 38-39)

```php
$mail->Username = 'your-email@gmail.com';
$mail->Password = 'your-app-password';  // Get from myaccount.google.com
```

**Done!** ✓

---

## 📝 Files Reference

| File | Type | Purpose | Lines |
|------|------|---------|-------|
| sendOTP.php | PHP | Generate & send OTP | 150 |
| verifyOTP.php | PHP | Verify OTP entry | 130 |
| registerEmployer.php | PHP | Register with OTP | 80 (modified) |
| registerJobseeker.php | PHP | Register with OTP | 80 (modified) |
| signinEmployerModals.php | HTML/PHP | OTP modal UI | 50 (added) |
| js/otpVerification.js | JavaScript | Timer & logic | 400 |
| database/otp_verification.sql | SQL | Database table | 20 |

---

## ⏱️ Timer Configuration

**Current Setting**: 2 minutes (120 seconds)

To change, edit `js/otpVerification.js` line ~93:
```javascript
let timeRemaining = 120;  // Change this number
// 120 = 2 minutes
// 300 = 5 minutes
// 60 = 1 minute
```

---

## 🔌 API Endpoints

### Send OTP
```
POST sendOTP.php
Parameters:
- email=user@email.com
- user_type=employer|seeker
Response: JSON {status, message, email}
```

### Verify OTP
```
POST verifyOTP.php
Parameters:
- email=user@email.com
- otp=123456
- user_type=employer|seeker
Response: JSON {status, message, expired}
```

### Check Expiration
```
GET verifyOTP.php
Parameters:
- email=user@email.com
- user_type=employer|seeker
Response: JSON {status, time_remaining}
```

---

## 🐛 Quick Fixes

| Problem | Fix |
|---------|-----|
| OTP not sent | Check Gmail creds in sendOTP.php |
| Timer frozen | Hard refresh (Ctrl+Shift+R) & check console |
| "Invalid OTP" | Check all 6 digits match email |
| "Already registered" | Use different email |
| Modal doesn't close | Check browser console for errors |

---

## 📊 Database Queries

### View all OTPs
```sql
SELECT * FROM otp_verification;
```

### Find OTP for email
```sql
SELECT * FROM otp_verification 
WHERE email = 'user@example.com'
ORDER BY created_at DESC LIMIT 1;
```

### Delete expired OTPs
```sql
DELETE FROM otp_verification 
WHERE expires_at < NOW();
```

### Count pending verifications
```sql
SELECT COUNT(*) FROM otp_verification 
WHERE is_verified = 0;
```

---

## 🧪 Quick Test

1. Go to registration → Click "Register Now"
2. Fill form with test email
3. Click "Create Account"
4. Check email inbox for OTP
5. Enter OTP in modal
6. Click "Verify OTP"
7. Should redirect to login ✓

---

## 🔒 Security Checklist

- ✅ Passwords hashed with bcrypt
- ✅ OTP expires in 2 minutes
- ✅ OTP deleted after registration
- ✅ Email verified before registration
- ✅ Only 6-digit numbers accepted
- ✅ Input validation on all forms

---

## 📧 Email Configuration

### Getting Gmail App Password

1. Visit https://myaccount.google.com/
2. Click "Security" (left sidebar)
3. Scroll to "How you sign in to Google"
4. Click "App passwords"
5. Select "Mail" and "Windows/Mac/Linux"
6. Copy 16-character password
7. Use in sendOTP.php

### Troubleshoot Email

- Check Gmail credentials correct
- Use App Password (not regular password)
- Check port 465 is accessible
- Check spam folder
- Verify SMTP settings

---

## 🎨 UI Elements

### OTP Modal Components
```
┌─────────────────────────┐
│ Email Verification      │ ← Title
├─────────────────────────┤
│ Email: user@email.com   │ ← Display email
│                         │
│ Enter 6-digit OTP:      │
│ [  ][  ][  ][  ][  ]    │ ← Input field
│                         │
│ Time: 2:00              │ ← Timer
│                         │
│ [  Verify OTP  ]        │ ← Button
│ [  Resend OTP  ]        │ ← Resend button
└─────────────────────────┘
```

---

## 💾 Database Schema (Quick View)

```
otp_verification table:
├─ id (Primary Key)
├─ email (255 chars)
├─ otp (6 digits: 000000-999999)
├─ user_type (employer | seeker)
├─ created_at (Timestamp)
├─ expires_at (created_at + 2 min)
├─ is_verified (0 or 1)
└─ attempts (Counter)

Indexes:
├─ PRIMARY (id)
├─ email
├─ expires_at
└─ email + user_type
```

---

## 🔄 Registration Flow (Simple)

```
1. User submits form
   ↓
2. Validate fields
   ↓
3. Check email unique
   ↓
4. Generate OTP (123456)
   ↓
5. Save to DB: expires_at = NOW() + 2 min
   ↓
6. Send email with OTP
   ↓
7. Show OTP Modal with timer
   ↓
8. User enters OTP
   ↓
9. Verify: OTP match + not expired
   ↓
10. Mark as verified in DB
    ↓
11. Create user account (hash password)
    ↓
12. Delete OTP record
    ↓
13. Success! Redirect to login
```

---

## 📱 Mobile Responsive

✅ Works on all devices
✅ Touch-friendly buttons
✅ Large OTP input field
✅ Clear timer display
✅ Responsive modal size

---

## 🆘 Common Errors

```
ERROR: "Email already registered"
FIX: Use different email or login

ERROR: "Invalid OTP"
FIX: Check email, enter correct 6 digits

ERROR: "OTP expired"
FIX: Click "Resend OTP" button

ERROR: Failed to send OTP
FIX: Check Gmail config in sendOTP.php

ERROR: Timer not counting
FIX: Clear cache, hard refresh, check console
```

---

## 📞 Support Files

| File | Read For |
|------|----------|
| OTP_QUICK_START.md | Setup (2 pages) |
| OTP_VERIFICATION_GUIDE.md | Full reference (10 pages) |
| OTP_TESTING_CHECKLIST.md | Testing guide (15 pages) |
| OTP_ARCHITECTURE.md | System design (12 pages) |
| OTP_TROUBLESHOOTING.md | Support guide (15 pages) |

---

## ✅ Deployment Checklist

- [ ] DB table created
- [ ] Gmail configured
- [ ] Files uploaded to server
- [ ] Test employer registration
- [ ] Test seeker registration  
- [ ] Test OTP expiration
- [ ] Check browser console
- [ ] Verify DB records created
- [ ] Ready for production! 🚀

---

## 📈 Performance

- OTP Generate: <1 sec ⚡
- Email Send: 2-5 sec ✓
- Verification: <1 sec ⚡
- Registration: <1 sec ⚡
- **Total: 1-2 minutes** ✓

---

## 🎓 Learning Path

1. **Read**: OTP_QUICK_START.md (5 min)
2. **Setup**: Follow 2 steps above (3 min)
3. **Test**: OTP_TESTING_CHECKLIST.md (15 min)
4. **Understand**: OTP_ARCHITECTURE.md (20 min)
5. **Reference**: OTP_VERIFICATION_GUIDE.md (as needed)
6. **Support**: OTP_TROUBLESHOOTING.md (when needed)

---

## 🚀 You're Ready!

**Your OTP system is ready to deploy.**

Next steps:
1. Create database table
2. Update email config
3. Test thoroughly
4. Deploy to production

---

**Questions?** See the documentation files.
**Issues?** Check OTP_TROUBLESHOOTING.md
**Need Help?** Review OTP_VERIFICATION_GUIDE.md

---

**Happy registration!** 🎉
