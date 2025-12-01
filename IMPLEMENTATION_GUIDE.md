# JobVerse BD - Payment System Implementation Guide

## Quick Start

### Step 1: Database Setup
Run the SQL migration to create payment tables:

```bash
mysql -u root -p jobportal < database/payment_tables.sql
```

Or execute manually in phpMyAdmin:
- Open `database/payment_tables.sql`
- Execute all queries

### Step 2: Create Required Directories
```bash
mkdir temp
mkdir logs
chmod 755 temp logs
```

### Step 3: Verify Configuration
Open `sslcommerz_config.php` and verify:
- Store ID: jobve692dab0c4dd17 ✓
- Store Password: jobve692dab0c4dd17@ssl ✓
- Callback URLs match your domain

## System Architecture

### Payment Flow Diagram
```
┌─────────────────────────────────────────────────────────────┐
│                    EMPLOYER SIDE                            │
├─────────────────────────────────────────────────────────────┤
│  1. Fill Job Form → Click "Post Job"                        │
│  2. Payment Modal Shows (Fee based on job type)             │
│  3. Click "Proceed to Payment"                              │
│  4. Redirected to SSLCommerz Gateway                        │
│  5. Enter Card Details                                      │
│  6. Payment Processing                                      │
└─────────────────────────────────────────────────────────────┘
                            ↓
                     SSLCommerz Server
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                    JOBVERSE BACKEND                         │
├─────────────────────────────────────────────────────────────┤
│  Success Path:                                              │
│  1. payment_success.php receives callback                   │
│  2. Job inserted with status = "pending"                    │
│  3. Payment status = "confirmed"                            │
│  4. Temporary job data file created                         │
│                                                              │
│  Failure Path:                                              │
│  1. payment_failure.php receives callback                   │
│  2. Payment status = "failed"                               │
│  3. Employer can retry                                      │
│                                                              │
│  Cancel Path:                                               │
│  1. payment_cancel.php receives callback                    │
│  2. Payment status = "cancelled"                            │
│  3. Employer redirected to dashboard                        │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                    ADMIN SIDE                               │
├─────────────────────────────────────────────────────────────┤
│  1. View "Pending Payment Confirmations" in Admin Dashboard │
│  2. Review Payment Details                                  │
│  3. Click Accept or Reject                                  │
│                                                              │
│  If Accept:                                                 │
│  - Job status → "open"                                      │
│  - Visible to job seekers                                   │
│  - Admin status → "approved"                                │
│  - Send confirmation email                                  │
│                                                              │
│  If Reject:                                                 │
│  - Job status → "rejected"                                  │
│  - Hidden from job seekers                                  │
│  - Admin status → "rejected"                                │
│  - Send rejection email                                     │
└─────────────────────────────────────────────────────────────┘
```

## File Structure

### New Files Created
```
JobVerseBD/
├── sslcommerz_config.php          # Configuration & credentials
├── initiate_payment.php            # Payment session init
├── payment_success.php             # Success handler
├── payment_failure.php             # Failure handler
├── payment_cancel.php              # Cancellation handler
├── payment_ipn.php                 # IPN handler
├── admin_confirm_payment.php       # Admin actions
├── process_payment_completion.php  # Payment verification
├── PAYMENT_SYSTEM_README.md        # Technical documentation
├── IMPLEMENTATION_GUIDE.md         # This file
├── temp/                           # Temporary storage
├── logs/                           # Payment logs
└── database/
    └── payment_tables.sql          # Database migration
```

### Modified Files
```
JobVerseBD/
├── postjob.php                     # Added payment modal & flow
└── adminAccount.php                # Added payment review section
```

## Payment Fees

| Job Type | Fee |
|----------|-----|
| White Collar | 500 Taka |
| Blue Collar | 200 Taka |

## Features

### ✓ Employer Features
- [x] Choose job type (White/Blue collar)
- [x] Payment modal with fee display
- [x] SSLCommerz payment gateway integration
- [x] Job posting auto-created after payment
- [x] Track job status (pending → open → visible)
- [x] Email notifications on admin actions
- [x] Dashboard view of posted jobs with payment status

### ✓ Admin Features
- [x] View all pending payments awaiting confirmation
- [x] Accept payment → Approve job → Make visible
- [x] Reject payment → Reject job → Send notification
- [x] View all jobs with payment status
- [x] Transaction details and employer information
- [x] One-click approve/reject actions
- [x] Email confirmations to employers

### ✓ System Features
- [x] Secure payment processing
- [x] Payment validation
- [x] IPN (Instant Payment Notification) support
- [x] Transaction logging
- [x] Error handling and recovery
- [x] Job status workflow management
- [x] Database integrity

## Database Schema

### payments Table
```sql
- id (PRIMARY)
- transaction_id (UNIQUE)
- eid (FOREIGN KEY - employer)
- amount
- currency (BDT)
- status (pending|confirmed|validated|failed|cancelled)
- payment_date
- validated_date (NULL by default)
- validation_response (JSON)
```

### job_payments Table
```sql
- id (PRIMARY)
- pid (FOREIGN KEY - post)
- payment_id (FOREIGN KEY - payments)
- eid (FOREIGN KEY - employer)
- job_type (white_collar|blue_collar)
- amount
- payment_status (pending|confirmed|failed|cancelled)
- admin_status (pending|approved|rejected)
- created_date
- admin_confirmed_date
- admin_notes
```

### post Table Modifications
```sql
- payment_id (NEW - links to payments table)
- payment_status (NEW - unpaid|confirmed)
```

## Testing Checklist

### Test 1: White Collar Job Posting with Payment
- [ ] Login as employer
- [ ] Navigate to "Post a Job"
- [ ] Select "White Collar Jobs" category
- [ ] Fill all job details
- [ ] Click "Post Job"
- [ ] Payment modal appears showing 500 Taka
- [ ] Click "Proceed to Payment"
- [ ] Complete test payment (Card: 4111111111111111)
- [ ] Verify job created with status "pending"
- [ ] Check payment appears in admin dashboard

### Test 2: Blue Collar Job Posting with Payment
- [ ] Login as employer
- [ ] Navigate to "Post a Job"
- [ ] Select "Blue Collar Jobs" category
- [ ] Fill all job details
- [ ] Click "Post Job"
- [ ] Payment modal appears showing 200 Taka
- [ ] Complete test payment
- [ ] Verify job created with status "pending"

### Test 3: Admin Payment Acceptance
- [ ] Login as admin
- [ ] Go to "Admin Account"
- [ ] View "Pending Payment Confirmations" section
- [ ] Click "Accept" button on a pending payment
- [ ] Verify job status changes to "open"
- [ ] Verify payment disappears from pending list
- [ ] Check job is now visible in job listings

### Test 4: Admin Payment Rejection
- [ ] Follow Test 3 setup but click "Reject"
- [ ] Verify job status changes to "rejected"
- [ ] Verify job is hidden from job listings
- [ ] Admin status shows as "rejected"

### Test 5: Payment Failure
- [ ] Attempt payment with failed card (4222222222222222)
- [ ] Verify failure page displays
- [ ] Verify payment status is "failed"
- [ ] Verify employer can retry

### Test 6: Payment Cancellation
- [ ] Start payment process
- [ ] Click Cancel at payment gateway
- [ ] Verify cancel page displays
- [ ] Verify payment status is "cancelled"

## Configuration Details

### sslcommerz_config.php

**Credentials (Provided)**
```php
STORE_ID: jobve692dab0c4dd17
STORE_PASSWORD: jobve692dab0c4dd17@ssl
STORE_NAME: testjobve3813
```

**Fees**
```php
WHITE_COLLAR_FEE = 500    // Taka
BLUE_COLLAR_FEE = 200     // Taka
```

**API Endpoints (Sandbox)**
```php
SESSION_API: https://sandbox.sslcommerz.com/gwprocess/v3/api.php
VALIDATION_API: https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php
MERCHANT_PANEL: https://sandbox.sslcommerz.com/manage/
```

**Callback URLs**
```php
SUCCESS_URL: https://jobversebd.cse.pstu.ac.bd/payment_success.php
FAILURE_URL: https://jobversebd.cse.pstu.ac.bd/payment_failure.php
CANCEL_URL: https://jobversebd.cse.pstu.ac.bd/payment_cancel.php
IPN_URL: https://jobversebd.cse.pstu.ac.bd/payment_ipn.php
```

## Common Issues & Solutions

### Issue 1: "Payment gateway error"
**Cause**: Invalid credentials or network error
**Solution**: 
- Verify credentials in sslcommerz_config.php
- Check SSL certificate on server
- Verify curl is enabled in PHP

### Issue 2: "Job not created after payment"
**Cause**: Temp directory permissions or storage issue
**Solution**:
- Verify temp directory exists and is writable
- Check temp directory permissions: `chmod 755 temp`
- Verify database connection

### Issue 3: Admin doesn't see pending payments
**Cause**: Query issues or payment status incorrect
**Solution**:
- Verify job_payments table has records
- Check payment_status = 'confirmed'
- Verify admin_status = 'pending'
- Run: SELECT * FROM job_payments WHERE admin_status = 'pending';

### Issue 4: "Unauthorized access" message
**Cause**: Session not properly initialized
**Solution**:
- Verify authorizeEmployer.php/authorizeAdmin.php works
- Check $_SESSION['eid'] and $_SESSION['aid'] are set
- Clear browser cookies and login again

## Test Card Numbers (Sandbox)

| Type | Card Number | Expiry | CVV |
|------|-------------|--------|-----|
| Successful | 4111111111111111 | Any | Any |
| Failed | 4222222222222222 | Any | Any |

## Email Template (Optional)

### Approval Email
```
Subject: Your Job Posting #[ID] - Payment Approved & Published

Dear [Employer Name],

Great news! Your job posting "[Job Title]" has been approved and is now live on JobVerse BD.

Payment Details:
- Transaction ID: [ID]
- Amount: [Amount] Taka
- Status: Approved

Your job posting will now be visible to all job seekers and will start receiving applications.

Manage your posting: [Link to Dashboard]

Best regards,
JobVerse BD Team
```

### Rejection Email
```
Subject: Your Job Posting #[ID] - Payment Rejected

Dear [Employer Name],

We regret to inform you that your job posting "[Job Title]" could not be approved at this time.

Payment Details:
- Transaction ID: [ID]
- Amount: [Amount] Taka
- Status: Rejected

For more information, please contact support.

Best regards,
JobVerse BD Team
```

## API Request/Response Examples

### Initiate Payment Request
```json
POST /initiate_payment.php
Content-Type: application/json

{
  "job_type": "white_collar",
  "job_data": {
    "name": "Senior Developer",
    "category": "IT Jobs",
    "minexp": "5 years",
    "salary": "50000-70000",
    "industry": "IT-Software",
    "desc": "Looking for experienced developer",
    "role": "Senior Developer",
    "eType": "Permanent",
    "status": "open"
  }
}
```

### Initiate Payment Response
```json
{
  "success": true,
  "gateway_url": "https://sandbox.sslcommerz.com/gwprocess/v3/gw.php?Q=sendtoken&val=...",
  "transaction_id": "JOB1701000000...",
  "payment_id": 123,
  "job_payment_id": 456,
  "amount": 500
}
```

### SSLCommerz Callback
```php
POST /payment_success.php
tran_id=JOB170100...
bank_tran_id=...
status=VALID
amount=500
store_amount=500
```

## Monitoring & Logs

### Payment Log
File: `logs/payment_ipn.log`
```
2024-12-01 10:30:45 - IPN Received: {"tran_id":"JOB...", "status":"VALID"}
2024-12-01 10:30:46 - Payment validated: JOB...
```

### Database Queries for Monitoring

**All Payments**
```sql
SELECT * FROM payments ORDER BY payment_date DESC LIMIT 10;
```

**Pending Admin Approvals**
```sql
SELECT jp.*, e.name, p.name FROM job_payments jp 
JOIN employer e ON jp.eid = e.id 
JOIN post p ON jp.pid = p.id 
WHERE jp.admin_status = 'pending';
```

**Jobs by Status**
```sql
SELECT status, COUNT(*) FROM post GROUP BY status;
```

## Migration to Production

### Before Going Live:
1. [ ] Change SSLCOMMERZ credentials to production
2. [ ] Update callback URLs to production domain
3. [ ] Configure email sending
4. [ ] Test complete workflow
5. [ ] Set up monitoring and alerts
6. [ ] Backup database
7. [ ] Document support procedures

### Production Checklist:
- [ ] SSL certificate valid
- [ ] Database backups scheduled
- [ ] Error logging enabled
- [ ] Payment logging enabled
- [ ] Email notifications working
- [ ] Admin notifications working
- [ ] Rate limiting implemented
- [ ] Security headers configured

## Support & Maintenance

### Regular Checks:
- Monitor payment logs for errors
- Check pending payments daily
- Verify payment reconciliation
- Test payment gateway quarterly
- Update security patches

### Contact Information:
- SSLCommerz Support: https://sslcommerz.com/
- Admin Support Email: admin@jobversebd.com
- Employer Support Email: support@jobversebd.com

---

**Implementation Date**: December 2025
**Payment Gateway**: SSLCommerz (Sandbox)
**Currency**: BDT (Bangladeshi Taka)
**Status**: Ready for Testing
