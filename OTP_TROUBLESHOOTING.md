# OTP System - Troubleshooting & Support Guide

## Quick Troubleshooting

### Issue 1: OTP Email Not Received

**Symptom**: User clicks "Create Account", but doesn't receive OTP email

**Diagnosis Steps**:
1. Check spam/junk folder in email inbox
2. Check browser console (F12 → Console tab) for errors
3. Check server error logs

**Solutions**:

**Solution 1a: Gmail Credentials Wrong**
```
Problem: sendOTP.php has incorrect credentials
```
- Open `sendOTP.php` (line 38-39)
- Verify Gmail address is correct
- Verify using **App Password** (not regular password)
- Get App Password from: https://myaccount.google.com/ → Security → App passwords
- Save and test again

**Solution 1b: "Less Secure Apps" Blocked**
```
Gmail might block PHP mail attempts
```
- Use Gmail App Password (recommended)
- Or enable "Less secure app access" (not recommended)
- Or use different email provider

**Solution 1c: Server Can't Access Internet**
```
Problem: Server blocked from sending emails
```
- Check firewall settings
- Verify SMTP port 465 is open
- Contact hosting provider
- Test with: `telnet smtp.gmail.com 465`

**Solution 1d: Email is being delivered but to wrong address**
```
Problem: OTP sent to different email
```
- Check that form shows correct email
- Verify database INSERT (check otp_verification table)
- Look for typos in email form input

---

### Issue 2: Timer Not Counting Down / Shows Stuck at 2:00

**Symptom**: OTP modal opens but timer doesn't decrease

**Diagnosis**:
```javascript
// Open browser console (F12)
// Check for errors
// Verify jQuery is loaded: console.log($); // Should work
// Verify JS file loaded: // Check Network tab for otpVerification.js
```

**Solutions**:

**Solution 2a: JavaScript File Not Loaded**
- Check: Is `js/otpVerification.js` in your `js/` folder?
- Check: Is it referenced in `signinEmployerModals.php`?
- Verify in page source: `<script src="js/otpVerification.js"></script>`
- Try hard refresh: Ctrl+Shift+R (Windows) or Cmd+Shift+R (Mac)

**Solution 2b: jQuery Not Loaded**
- Timer requires jQuery for `setInterval`
- Check if jQuery is loaded before `otpVerification.js`
- Add to signinEmployerModals.php if missing:
```html
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
```

**Solution 2c: Browser Console Errors**
- Open F12 → Console tab
- Look for red error messages
- Common errors:
  - "$ is not defined" → jQuery not loaded
  - "Cannot read property of null" → DOM element missing
  - "Uncaught SyntaxError" → JavaScript syntax error

**Solution 2d: Modal Not Opening**
- Check if OTP Modal exists in `sigsinEmployerModals.php`
- Check modal ID: `id="otpVerificationModal"`
- Verify Bootstrap modal initialized

---

### Issue 3: "Invalid OTP" When Entering Correct OTP

**Symptom**: User enters correct 6-digit OTP from email but gets "Invalid OTP" error

**Diagnosis**:
1. Check email has correct OTP
2. Check user typed all 6 digits
3. Check database has OTP stored correctly

**Solutions**:

**Solution 3a: User Copied Wrong OTP**
- Resend OTP
- Verify email shows new OTP
- Double-check 6 digits carefully

**Solution 3b: Database Issue**
- Open phpMyAdmin
- Go to `otp_verification` table
- Find latest record for user's email
- Verify `otp` field matches what user entered
- Check `is_verified` is still 0

**Solution 3c: OTP Actually Expired**
- Check `expires_at` timestamp
- Compare to current time
- If `expires_at < NOW()`, OTP is expired
- Solution: User must click "Resend OTP"

**Solution 3d: Case Sensitivity**
- OTP should be 6 digits only (0-9)
- No letters or special characters
- Verify form only accepts numbers:
```javascript
// In otpVerification.js
$('#otpInput').on('keypress', function(e) {
    if (!/[0-9]/.test(String.fromCharCode(e.which))) {
        e.preventDefault();
    }
});
```

---

### Issue 4: "OTP Expired" After 2 Minutes

**Symptom**: Timer shows 0:00, OTP expired message appears (EXPECTED BEHAVIOR)

**This is Normal!** ✓
- OTP intentionally expires after 2 minutes
- This is a security feature
- User should click "Resend OTP" to get a new one

**If user can't resend**:
- Check "Resend OTP" button is enabled
- Try clicking it
- Should receive new email
- Timer should reset

---

### Issue 5: "Email Already Registered" Error

**Symptom**: User tries to register but gets "Email already registered" error

**Why**: Email already exists in employer/seeker table

**Solutions**:

**Solution 5a: User Registered Before**
- Check if user has existing account
- Have user login instead
- Or use different email address

**Solution 5b: Need to Delete Old Account**
- Contact admin
- Admin should:
  1. Verify it's the same person
  2. Backup user data if needed
  3. Delete from employer/seeker table
  4. Delete from otp_verification table
  5. User can now register again

**Solution 5c: Email Typo in Old Registration**
- Have user register with different (correct) email
- Later admin can consolidate accounts if needed

---

### Issue 6: Registration Completes But Can't Login

**Symptom**: "Registration Successful" message, redirect to login, but login fails

**Diagnosis**:
1. Check database - is record actually created?
2. Check password - user might have mistyped during registration

**Solutions**:

**Solution 6a: User Forgot Password**
- Implement "Forgot Password" link
- Send reset email
- Allow user to set new password

**Solution 6b: Password Stored As Hash**
- Passwords are hashed with bcrypt
- Cannot see original password
- Only verify with `password_verify()`
- User must remember their password

**Solution 6c: Record Not Actually Created**
- Open phpMyAdmin
- Check employer/seeker table
- Search for user's email
- If not found: Registration failed silently
- Check server logs for errors

**Solution 6d: Wrong Table**
- Employer registered but checking seeker table
- Jobseeker registered but checking employer table
- Check correct table based on registration type

---

### Issue 7: Session/Storage Errors

**Symptom**: After OTP verification, "Registration data not found" error

**Cause**: Registration data stored in sessionStorage was cleared

**Solutions**:

**Solution 7a: Browser Cleared sessionStorage**
- User cleared browser data/cache
- sessionStorage auto-clears when browser closes
- Prevent: Keep data for longer or use localStorage
- Workaround: User must restart registration

**Solution 7b: Long Delay Between OTP Verification and Registration**
- If too much time passes, session might expire
- Solution: Reduce delay, or reload data
- Current: Registration should complete within 30 seconds

**Solution 7c: Multiple Tabs/Windows**
- Opening registration in multiple tabs causes issues
- Each tab has separate sessionStorage
- Solution: Close other tabs, use single tab

---

### Issue 8: Modal Not Closing After Registration

**Symptom**: Registration succeeds but OTP modal stays open

**Solutions**:

**Solution 8a: Modal jQuery Issue**
- Bootstrap Modal requires jQuery
- Verify jQuery loaded: `console.log($.modal);`
- Add if missing (see Issue 2b)

**Solution 8b: Modal ID Mismatch**
- Verify modal ID in HTML: `id="otpVerificationModal"`
- Verify in JavaScript: `$('#otpVerificationModal').modal('hide');`
- IDs must match exactly

**Solution 8c: Event Not Firing**
- Check browser console for errors
- Verify completeRegistration() is called
- Add debugging: `console.log("Closing modal");`

---

### Issue 9: Database Connection Error

**Symptom**: "Failed to send OTP" or blank error message

**Error**: Cannot connect to database or table doesn't exist

**Solutions**:

**Solution 9a: OTP Table Not Created**
- Open phpMyAdmin
- Select `jobportal` database
- Look for `otp_verification` table
- If missing: Run SQL to create it (see Quick Start)

**Solution 9b: Wrong Database Credentials**
- Check `connect.php` has correct credentials:
```php
$servername = "localhost";
$username = "root";
$password = ""; // Your password
$dbname = "jobportal";
```

**Solution 9c: Database Server Down**
- Verify MySQL/MariaDB is running
- Restart server if needed
- Check hosting provider status

**Solution 9d: Permission Issues**
- Check user has INSERT permission on otp_verification
- In phpMyAdmin: Check user privileges
- Add privileges if needed

---

### Issue 10: Email Format Errors

**Symptom**: Email HTML not rendering, shows plain text

**Solution**: PHPMailer might not be set to HTML mode
- Check `sendOTP.php` line ~72:
```php
$mail->isHTML(true);  // Should be true
```

---

## Advanced Troubleshooting

### Enable Debug Mode

**Add to sendOTP.php** (after line 40):
```php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log to file
ini_set('error_log', __DIR__ . '/logs/otp_errors.log');
```

**Add to verifyOTP.php**:
```php
error_reporting(E_ALL);
ini_set('error_log', __DIR__ . '/logs/otp_errors.log');
```

### Check Logs

1. PHP Error Log
```bash
# Linux/Mac
tail -f /var/log/php-errors.log

# Windows (Apache)
C:\xampp\apache\logs\error.log
```

2. Application Log
```bash
# Check if exists
ls -la logs/otp_errors.log

# View
tail -f logs/otp_errors.log
```

3. MySQL Error Log
```bash
# Check for database errors
# Location depends on system
```

### Database Debugging

```sql
-- Check if table exists
SHOW TABLES LIKE 'otp_verification';

-- View table structure
DESCRIBE otp_verification;

-- Check all OTP records
SELECT * FROM otp_verification;

-- Check latest OTP for an email
SELECT * FROM otp_verification 
WHERE email = 'test@example.com'
ORDER BY created_at DESC LIMIT 1;

-- Check expired OTPs
SELECT * FROM otp_verification 
WHERE expires_at < NOW();

-- Count unverified OTPs
SELECT COUNT(*) FROM otp_verification 
WHERE is_verified = 0;
```

### Network Debugging

**Test Email Sending:**
```bash
# Test SMTP connection
telnet smtp.gmail.com 465

# If connected: Connected to smtp.gmail.com
# If failed: Connection refused
```

**Check Server Ports:**
```bash
# Verify ports are open
netstat -an | grep 465  # SMTP port
netstat -an | grep 3306 # MySQL port
```

---

## Performance Issues

### Slow OTP Sending

**Cause**: Email server slow or network latency

**Solutions**:
1. Move email to background job (async)
2. Increase timeout in PHP:
```php
$mail->Timeout = 30; // seconds
```
3. Use different email service (SendGrid, Mailgun, etc.)

### Slow OTP Verification

**Cause**: Database query slow

**Solutions**:
1. Check indexes exist on email and expires_at
2. Archive old OTP records
3. Optimize query

---

## Security Debugging

### Check Password Hashing

```php
// Test password hashing
$password = "Test@123";
$hash = password_hash($password, PASSWORD_BCRYPT);
echo $hash; // Should show $2y$10$...

// Verify password
$result = password_verify("Test@123", $hash);
echo $result; // Should be true (1)
```

### Check OTP Randomness

```php
// Generate 10 OTPs and check they're different
for ($i = 0; $i < 10; $i++) {
    echo str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT) . "\n";
}
// All should be different
```

---

## Common Error Messages & Fixes

| Error Message | Cause | Fix |
|---------------|-------|-----|
| "Email already registered" | Email exists | Use different email or login |
| "Invalid OTP" | Wrong OTP | Check email, enter correct OTP |
| "OTP expired" | 2 min passed | Click "Resend OTP" |
| "Invalid email format" | Bad format | Enter valid email like user@example.com |
| "All fields required" | Empty field | Fill all form fields |
| "Failed to send OTP" | Email error | Check Gmail credentials |
| "Invalid verification" | OTP not verified | Complete OTP verification first |
| "Database error" | SQL issue | Check database, table exists |

---

## When to Contact Support

If you've tried all solutions and still having issues:

**Provide**:
1. Error message (exact text)
2. Browser/OS
3. Steps to reproduce
4. Server logs (if available)
5. Screenshots

**Example**:
```
Issue: OTP email not received
Error: No error shown, just doesn't arrive
Browser: Chrome on Windows 10
Server: XAMPP local
Steps:
  1. Fill registration form
  2. Click "Create Account"
  3. Wait 2 minutes - no email received
Logs: (check inbox, try resend, still nothing)
```

---

## Prevention Strategies

### Prevent Common Issues

1. **Validate All Inputs**
   - Check email format before sending OTP
   - Check password strength
   - Validate all seeker fields

2. **Monitor Database**
   - Check for old OTP records
   - Clean up daily
   - Monitor storage usage

3. **Test Regularly**
   - Test OTP sending monthly
   - Test with different email providers
   - Test timer countdown
   - Test expiration

4. **Keep Logs**
   - Enable error logging
   - Review logs weekly
   - Look for patterns

5. **User Communication**
   - Document the process
   - Show clear error messages
   - Provide support contact

---

## Maintenance Checklist

- [ ] Weekly: Check error logs
- [ ] Weekly: Test OTP email delivery
- [ ] Monthly: Clean old OTP records
- [ ] Monthly: Review failed registrations
- [ ] Quarterly: Test full registration flow
- [ ] Quarterly: Check Gmail app password (not expired)
- [ ] Yearly: Update PHP/MySQL versions
- [ ] Yearly: Security audit

---

**Still stuck?** Check the full documentation:
- `OTP_VERIFICATION_GUIDE.md` - Complete guide
- `OTP_QUICK_START.md` - Setup instructions
- `OTP_TESTING_CHECKLIST.md` - Testing guide
- `OTP_ARCHITECTURE.md` - System design
