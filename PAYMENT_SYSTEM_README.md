# Job Posting Payment System Implementation

## Overview
This document describes the SSLCommerz payment integration for job posting fees on JobVerse BD.

## Features Implemented

### 1. **Payment Fees**
- **White Collar Jobs**: 500 Taka
- **Blue Collar Jobs**: 200 Taka

### 2. **Payment Flow**
1. Employer fills out job posting form
2. Clicks "Post Job" button
3. Payment modal appears with fee details
4. Employer proceeds to SSLCommerz payment gateway
5. After successful payment:
   - Job posting is created with "pending" status
   - Payment is recorded as "confirmed"
   - Job is awaiting admin confirmation
6. Admin reviews payment in dashboard
7. Admin accepts or rejects payment
8. If accepted: Job status changes to "open" and becomes visible
9. If rejected: Job status changes to "rejected"

### 3. **Database Schema**

#### New Tables:

**payments** table:
- Stores all payment transactions
- Tracks payment status (pending, confirmed, validated, failed, cancelled)
- Links to employer

**job_payments** table:
- Links jobs with payments
- Tracks job type (white_collar/blue_collar)
- Admin approval status (pending, approved, rejected)

**Modifications to post table:**
- Added `payment_id` column
- Added `payment_status` column

### 4. **Configuration**

**File**: `sslcommerz_config.php`

Contains:
- SSLCommerz credentials
- API endpoints
- Callback URLs
- Helper functions

**Credentials**:
```
Store ID: jobve692dab0c4dd17
Store Password: jobve692dab0c4dd17@ssl
Environment: Sandbox (https://sandbox.sslcommerz.com/)
```

### 5. **Files Created/Modified**

#### New Files:

1. **sslcommerz_config.php**
   - Configuration and credentials
   - Helper functions for fee calculation

2. **initiate_payment.php**
   - Handles payment session initiation with SSLCommerz
   - Creates payment record in database
   - Returns gateway URL for redirect

3. **payment_success.php**
   - Handles SSLCommerz callback on successful payment
   - Inserts job posting with "pending" status
   - Stores payment details

4. **payment_failure.php**
   - Handles failed payment attempts
   - Updates payment status to "failed"

5. **payment_cancel.php**
   - Handles user cancellation of payment
   - Updates payment status to "cancelled"

6. **payment_ipn.php**
   - Instant Payment Notification handler
   - Asynchronous payment validation
   - Logs payment events

7. **admin_confirm_payment.php**
   - Admin action script for approving/rejecting payments
   - Updates job and payment statuses
   - Sends confirmation emails

8. **process_payment_completion.php**
   - Helper script for payment verification
   - Not currently used but available for additional validation

9. **database/payment_tables.sql**
   - SQL script to create payment tables
   - Add columns to post table

#### Modified Files:

1. **postjob.php**
   - Integrated payment flow
   - Added payment modal
   - Form submission now triggers payment instead of direct posting
   - JavaScript for payment handling

2. **adminAccount.php**
   - Added "Pending Payment Confirmations" section
   - Displays pending payments with Accept/Reject buttons
   - Shows all posted jobs with payment status

## API Endpoints

### SSLCommerz Sandbox URLs
- **Session API**: https://sandbox.sslcommerz.com/gwprocess/v3/api.php
- **Gateway**: https://sandbox.sslcommerz.com/gwprocess/v3/gw.php
- **Validation API**: https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php
- **Merchant Panel**: https://sandbox.sslcommerz.com/manage/

### Application Callback URLs
- **Success**: https://jobversebd.cse.pstu.ac.bd/payment_success.php
- **Failure**: https://jobversebd.cse.pstu.ac.bd/payment_failure.php
- **Cancel**: https://jobversebd.cse.pstu.ac.bd/payment_cancel.php
- **IPN**: https://jobversebd.cse.pstu.ac.bd/payment_ipn.php

## Job Posting Status Flow

```
Initial Form Submission
         ↓
Payment Modal Appears
         ↓
Employer Completes Payment (SSLCommerz)
         ↓
Payment Success Page
         ↓
Job Created with Status: "pending"
Payment Status: "confirmed"
         ↓
Admin Dashboard Shows Pending Payments
         ↓
Admin Accepts/Rejects
         ↓
If Accepted: Job Status → "open" (Visible to job seekers)
If Rejected: Job Status → "rejected"
```

## Installation & Setup

### 1. **Run SQL Migration**
```bash
mysql -u root -p jobportal < database/payment_tables.sql
```

### 2. **Create Temp Directory**
```bash
mkdir temp
chmod 755 temp
```

### 3. **Create Logs Directory**
```bash
mkdir logs
chmod 755 logs
```

### 4. **Update Callback URLs**
If using different domain, update `sslcommerz_config.php`:
```php
define('SSLCOMMERZ_REGISTERED_URL', 'https://yourdomain.com/');
```

## Testing

### Test Payment Cards (Sandbox)

**Successful Payment:**
- Card Number: 4111111111111111
- Expiry: 12/25
- CVV: 123

**Failed Payment:**
- Card Number: 4222222222222222

### Test Workflow

1. Log in as employer
2. Go to "Post a Job"
3. Fill job details
4. Click "Post Job" button
5. Payment modal appears
6. Click "Proceed to Payment"
7. Enter test card details
8. Complete payment
9. Check employer dashboard for job status
10. Log in as admin
11. Check "Pending Payment Confirmations" section
12. Click Accept/Reject

## Email Notifications

Admin payment approval/rejection emails are prepared but require email configuration in `sendEmail.php`.

To enable:
1. Configure SMTP settings in `sendEmail.php`
2. Uncomment email sending lines in `admin_confirm_payment.php`

## Security Considerations

1. **SQL Injection Protection**: Use real_escape_string for user inputs
2. **Session Validation**: All payment pages validate employer/admin session
3. **Payment Verification**: Cross-verify with SSLCommerz before confirming
4. **Amount Verification**: Validate that paid amount matches expected fee
5. **Status Checks**: Prevent duplicate approval/rejection
6. **Transaction IDs**: Unique transaction IDs prevent replay attacks

## Troubleshooting

### Payment gateway returns error
- Verify SSL certificate on server
- Check curl is enabled in PHP
- Verify credentials in `sslcommerz_config.php`

### Job not created after payment
- Check `temp` directory permissions
- Verify temporary storage file is created
- Check database connection in `payment_success.php`

### Admin doesn't see pending payments
- Verify job_payments table has records with admin_status = 'pending'
- Check payment_status = 'confirmed'
- Verify payment table status is 'confirmed'

### Callback URLs not working
- Ensure URLs in `sslcommerz_config.php` match your domain
- Check server can access SSLCommerz servers
- Verify firewall allows incoming connections from SSLCommerz

## Future Enhancements

1. Implement payment validation with SSLCommerz API
2. Add email notifications (already prepared)
3. Add refund functionality
4. Payment history dashboard for employers
5. Multiple payment methods support
6. Package discounts for bulk job postings
7. Payment tracking analytics for admin
8. Automated status updates via webhooks
9. Payment receipt generation and download
10. Support for seasonal promotions/coupons

## Support

For issues or questions about the payment system:
1. Check the logs in `logs/payment_ipn.log`
2. Verify SSLCommerz merchant account status
3. Contact SSLCommerz support at sandbox environment

## Database Queries Reference

### View All Payments
```sql
SELECT * FROM payments ORDER BY payment_date DESC;
```

### View Pending Admin Confirmations
```sql
SELECT jp.*, e.name, post.name FROM job_payments jp 
JOIN employer e ON jp.eid = e.id 
JOIN post ON jp.pid = post.id 
WHERE jp.admin_status = 'pending' 
ORDER BY jp.created_date DESC;
```

### View Job with Payment Status
```sql
SELECT p.*, e.name as employer, pay.status as payment_status
FROM post p
LEFT JOIN employer e ON p.eid = e.id
LEFT JOIN payments pay ON p.payment_id = pay.id
ORDER BY p.id DESC;
```

---

**Last Updated**: December 2025
**Payment Gateway**: SSLCommerz Sandbox
**Currency**: BDT (Bangladeshi Taka)
