// OTP Verification and Registration System

let otpTimerInterval = null;
let otpExpireTime = null;
let currentUserType = '';
let currentEmail = '';
let isOtpVerified = false;

$(document).ready(function() {
    // Handle registration form submission
    $('#empsignup form').on('submit', function(e) {
        e.preventDefault();
        handleRegistrationForm(this);
    });

    // Handle OTP input - only allow numbers
    $('#otpInput').on('keypress', function(e) {
        if (!/[0-9]/.test(String.fromCharCode(e.which))) {
            e.preventDefault();
        }
    });

    // Handle OTP verification button
    $('#verifyOtpBtn').on('click', function() {
        verifyOTP();
    });

    // Handle Resend OTP button
    $('#resendOtpBtn').on('click', function(e) {
        e.preventDefault();
        resendOTP();
    });

    // Allow verification on Enter key in OTP input
    $('#otpInput').on('keypress', function(e) {
        if (e.which === 13) { // Enter key
            verifyOTP();
        }
    });
});

function handleRegistrationForm(form) {
    const $form = $(form);
    const $tabPane = $form.closest('.tab-pane');
    
    const name = $form.find('input[name="name"]').val().trim();
    const email = $form.find('input[name="email"]').val().trim();
    const password = $form.find('input[name="password"]').val().trim();

    // Determine if employer or seeker registration
    if ($tabPane.attr('id') === 'home') {
        currentUserType = 'employer';
    } else {
        currentUserType = 'seeker';
        // For seeker, also validate additional fields
        const qlf = $form.find('input[name="qlf"]').val().trim();
        const dob = $form.find('input[name="dob"]').val().trim();
        const skills = $form.find('input[name="skills"]').val().trim();

        if (!qlf || !dob || !skills) {
            showErrorMessage('All fields are required for job seeker registration');
            return;
        }
    }

    // Validate basic fields
    if (!name || !email || !password) {
        showErrorMessage('All fields are required');
        return;
    }

    // Validate email format
    if (!isValidEmail(email)) {
        showErrorMessage('Please enter a valid email address');
        return;
    }

    // Validate password length
    if (password.length < 6) {
        showErrorMessage('Password must be at least 6 characters long');
        return;
    }

    // Store form data in session storage for later use
    currentEmail = email;
    sessionStorage.setItem('registrationData', JSON.stringify({
        name: name,
        email: email,
        password: password,
        userType: currentUserType,
        qlf: $form.find('input[name="qlf"]').val() || '',
        dob: $form.find('input[name="dob"]').val() || '',
        skills: $form.find('input[name="skills"]').val() || ''
    }));

    // Send OTP request
    sendOTPRequest(email, currentUserType);
}

function sendOTPRequest(email, userType) {
    $.ajax({
        url: 'sendOTP.php',
        method: 'POST',
        data: {
            email: email,
            user_type: userType
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                // Close registration modal and open OTP modal
                $('#empsignup').modal('hide');
                
                // Reset OTP form
                $('#otpInput').val('');
                $('#otpMessage').hide();
                $('#otpEmail').text(email);
                
                // Set initial timer display
                updateTimerDisplay(120);
                
                // Open OTP verification modal
                $('#otpVerificationModal').modal('show');
                
                // Start countdown timer
                startOTPTimer();
            } else {
                showErrorMessage(response.message || 'Failed to send OTP');
            }
        },
        error: function(xhr, status, error) {
            showErrorMessage('Error sending OTP. Please try again.');
            console.error('AJAX Error:', error);
        }
    });
}

function startOTPTimer() {
    // Clear any existing timer
    if (otpTimerInterval) {
        clearInterval(otpTimerInterval);
    }

    let timeRemaining = 120; // 2 minutes in seconds
    otpExpireTime = Date.now() + (timeRemaining * 1000);

    otpTimerInterval = setInterval(function() {
        timeRemaining--;
        updateTimerDisplay(timeRemaining);

        if (timeRemaining <= 0) {
            clearInterval(otpTimerInterval);
            handleOTPExpiration();
        }
    }, 1000);
}

function updateTimerDisplay(seconds) {
    const minutes = Math.floor(seconds / 60);
    const secs = seconds % 60;
    
    $('#timerMinutes').text(minutes);
    $('#timerSeconds').text(secs < 10 ? '0' + secs : secs);
}

function handleOTPExpiration() {
    $('#otpInput').prop('disabled', true);
    $('#verifyOtpBtn').prop('disabled', true);
    
    showOTPMessage('OTP has expired. Please request a new one.', 'error');
    
    // Show resend message
    $('#resendMessage').show().text('Click Resend OTP');
    
    // Allow resend after expiry
    $('#resendOtpBtn').prop('disabled', false);
}

function verifyOTP() {
    const otp = $('#otpInput').val().trim();

    if (!otp) {
        showOTPMessage('Please enter the OTP', 'error');
        return;
    }

    if (!/^\d{6}$/.test(otp)) {
        showOTPMessage('OTP must be 6 digits', 'error');
        return;
    }

    // Disable button during submission
    $('#verifyOtpBtn').prop('disabled', true).text('Verifying...');

    $.ajax({
        url: 'verifyOTP.php',
        method: 'POST',
        data: {
            email: currentEmail,
            otp: otp,
            user_type: currentUserType
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                isOtpVerified = true;
                clearInterval(otpTimerInterval);
                
                showOTPMessage('OTP verified successfully! Completing registration...', 'success');
                
                // Wait a moment then complete registration
                setTimeout(function() {
                    completeRegistration();
                }, 1500);
            } else if (response.expired) {
                showOTPMessage('OTP has expired. Please request a new one.', 'error');
                handleOTPExpiration();
            } else {
                showOTPMessage(response.message || 'Invalid OTP. Please try again.', 'error');
                $('#verifyOtpBtn').prop('disabled', false).text('Verify OTP');
            }
        },
        error: function(xhr, status, error) {
            showOTPMessage('Error verifying OTP. Please try again.', 'error');
            $('#verifyOtpBtn').prop('disabled', false).text('Verify OTP');
            console.error('AJAX Error:', error);
        }
    });
}

function resendOTP() {
    if (!currentEmail || !currentUserType) {
        showOTPMessage('Session error. Please refresh and try again.', 'error');
        return;
    }

    $('#resendOtpBtn').prop('disabled', true);

    $.ajax({
        url: 'sendOTP.php',
        method: 'POST',
        data: {
            email: currentEmail,
            user_type: currentUserType
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                // Reset OTP input
                $('#otpInput').val('').prop('disabled', false);
                $('#verifyOtpBtn').prop('disabled', false).text('Verify OTP');
                
                showOTPMessage('New OTP sent to your email!', 'success');
                $('#resendMessage').hide();
                
                // Restart timer
                startOTPTimer();
            } else {
                showOTPMessage(response.message || 'Failed to resend OTP', 'error');
                $('#resendOtpBtn').prop('disabled', false);
            }
        },
        error: function(xhr, status, error) {
            showOTPMessage('Error resending OTP. Please try again.', 'error');
            $('#resendOtpBtn').prop('disabled', false);
            console.error('AJAX Error:', error);
        }
    });
}

function completeRegistration() {
    const registrationData = JSON.parse(sessionStorage.getItem('registrationData'));
    
    if (!registrationData) {
        showOTPMessage('Registration data not found. Please try again.', 'error');
        return;
    }

    const formData = {
        name: registrationData.name,
        email: registrationData.email,
        password: registrationData.password,
        user_type: registrationData.userType,
        verified_otp: 'yes'
    };

    // Add seeker-specific fields if needed
    if (registrationData.userType === 'seeker') {
        formData.qlf = registrationData.qlf;
        formData.dob = registrationData.dob;
        formData.skills = registrationData.skills;
    }

    const registerUrl = registrationData.userType === 'employer' 
        ? 'registerEmployer.php' 
        : 'registerJobseeker.php';

    $.ajax({
        url: registerUrl,
        method: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                // Clear session storage
                sessionStorage.removeItem('registrationData');
                
                // Close OTP modal
                $('#otpVerificationModal').modal('hide');
                
                // Show success message
                alert(response.message);
                
                // Redirect to login
                if (response.redirect) {
                    window.location.href = response.redirect;
                }
            } else {
                showOTPMessage(response.message || 'Registration failed. Please try again.', 'error');
            }
        },
        error: function(xhr, status, error) {
            showOTPMessage('Error completing registration. Please try again.', 'error');
            console.error('AJAX Error:', error);
        }
    });
}

function showOTPMessage(message, type) {
    const $msgDiv = $('#otpMessage');
    $msgDiv.removeClass('text-success text-danger');
    
    if (type === 'success') {
        $msgDiv.addClass('text-success').css('color', '#4caf50');
    } else if (type === 'error') {
        $msgDiv.addClass('text-danger').css('color', '#f44336');
    }
    
    $msgDiv.text(message).show();
}

function showErrorMessage(message) {
    alert(message);
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Handle OTP modal close - cleanup
$(document).on('hidden.bs.modal', '#otpVerificationModal', function() {
    clearInterval(otpTimerInterval);
    $('#otpInput').val('').prop('disabled', false);
    $('#verifyOtpBtn').prop('disabled', false).text('Verify OTP');
    $('#resendOtpBtn').prop('disabled', false);
    $('#otpMessage').hide();
    $('#resendMessage').hide();
});
