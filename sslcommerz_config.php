<?php
/**
 * SSLCommerz Configuration
 * Sandbox environment credentials for job posting payments
 */

// SSLCommerz Sandbox Credentials
// Note: These are your actual store credentials - they work with both localhost and production
define('SSLCOMMERZ_STORE_ID', 'jobve692dab0c4dd17');
define('SSLCOMMERZ_STORE_PASSWORD', 'jobve692dab0c4dd17@ssl');
define('SSLCOMMERZ_STORE_NAME', 'testjobve3813');

// Determine environment for callback URLs
$currentHost = $_SERVER['HTTP_HOST'];
$isLocalhost = strpos($currentHost, 'localhost') !== false || strpos($currentHost, '127.0.0.1') !== false;

if ($isLocalhost) {
    // LOCAL TESTING
    define('SSLCOMMERZ_REGISTERED_URL', 'http://localhost/JobVerseBD/');
} else {
    // PRODUCTION
    define('SSLCOMMERZ_REGISTERED_URL', 'https://jobversebd.cse.pstu.ac.bd/');
}

// SSLCommerz API Endpoints (Sandbox)
// Updated to v4 API as v3 is deprecated as of 2026
define('SSLCOMMERZ_SESSION_API', 'https://sandbox.sslcommerz.com/gwprocess/v4/api.php');
define('SSLCOMMERZ_VALIDATION_API', 'https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php?wsdl');
define('SSLCOMMERZ_MERCHANT_PANEL', 'https://sandbox.sslcommerz.com/manage/');

// Job Posting Fees (in Taka)
define('WHITE_COLLAR_FEE', 500);
define('BLUE_COLLAR_FEE', 200);

// Callback URLs (Update these with your actual domain)
define('PAYMENT_SUCCESS_URL', SSLCOMMERZ_REGISTERED_URL . 'payment_success.php');
define('PAYMENT_FAILURE_URL', SSLCOMMERZ_REGISTERED_URL . 'payment_failure.php');
define('PAYMENT_CANCEL_URL', SSLCOMMERZ_REGISTERED_URL . 'payment_cancel.php');
define('PAYMENT_IPN_URL', SSLCOMMERZ_REGISTERED_URL . 'payment_ipn.php');

// Session timeout (in seconds)
define('PAYMENT_SESSION_TIMEOUT', 3600); // 1 hour

/**
 * Function to get job posting fee based on job type
 */
function getJobPostingFee($jobType) {
    if ($jobType === 'white_collar') {
        return WHITE_COLLAR_FEE;
    } else if ($jobType === 'blue_collar') {
        return BLUE_COLLAR_FEE;
    }
    return 0;
}

/**
 * Function to get job type from category
 */
function getJobTypeFromCategory($category, $jobType = null) {
    if ($jobType) {
        return $jobType;
    }
    
    // Define blue collar categories
    $blueCollarCategories = [
        'Caregiver/Nanny',
        'Beautician/Salon',
        'Sewing machine operator',
        'Carpenter',
        'Plumber/Pipe fitting',
        'Welder',
        'Boiler Operator',
        'Gym/Fitness Trainer',
        'Interpreter',
        'Imam/Khatib/Muezzin',
        'Mason/Construction worker',
        'Nurse',
        'Deliveryman',
        'Pathologist'
    ];
    
    if (in_array($category, $blueCollarCategories)) {
        return 'blue_collar';
    }
    
    return 'white_collar';
}

?>
