<style>

.sgn {
  color: white;
  text-align:right;
  padding-right:30px;
  cursor: context-menu;
}

.lk {
  color: #e9c46a;
  text-decoration:none;
}

.lk:hover {
  color: #e9c46a;
  text-decoration:none;
  cursor: pointer;
}
.ba {
  color:#e9c46a;
}

  </style>

<!-- Modal -->
<script src='https://www.google.com/recaptcha/api.js'></script>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/lang.php';
?>
<div class="modal fade" id="myEmployerModal" tabindex="-1" role="dialog" aria-labelledby="myEmployerModalLabel" 
     style="background-image:url('img/siginBack.jpg'); background-size: cover; background-repeat: no-repeat;">
    
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="background-image: url(img/1bck.jpg);">
       
            <div class="modal-header">
              <button id="empSignInCloseBtn" class="close" data-dismiss="modal" aria-label="Close" style="color:white;">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="myEmployerModalLabel" style="color:white;">Sign In</h4>
            </div>
           
          <div class="modal-body"> 
              
            <!-- log in form -->
	    <div id="cd-login"> 
              <form class="cd-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<p class="fieldset">
            		<label class="image-replace cd-email" for="eemail"><?php echo t('enter_email'); ?></label>
                        <input class="full-width has-padding has-border" id="email" name="email" type="email" placeholder="<?php echo t('enter_email'); ?>">
                        <span class="cd-error-message" style="color:white;">Error message here!</span>
		</p>

                <p class="fieldset">
            		<label class="image-replace cd-password" for="epass"><?php echo t('enter_password'); ?></label>
                        <input class="full-width has-padding has-border" id="password" name="password" type="password"  placeholder="<?php echo t('enter_password'); ?>">
            		<a href="#0" class="hide-password"><?php echo t('done'); ?></a>
            		<div id="loginresult" style="display:none;color:white;">Error message here!</div>
                </p>

                        <input type="hidden" id="currentPage" name="currentPage" value="<?php echo $_SERVER['PHP_SELF']; ?>">
                <p class="fieldset">
                        <input id="loginsubmit" class="full-width" type="submit" name="loginsubmit" id="login" value="<?php echo t('login'); ?>">
                </p>
	      </form>
		
                <p class="cd-form-bottom-message">
                  <p id="regNowBtn"  class="sgn" data-toggle="modal" data-target="#empsignup"><?php echo t('register_now'); ?></p>
                </p>                
	    </div>
          </div>
          <div class="modal-footer"></div>           
      </div>
    </div>
</div>
<!--------------------------------------------------------------------------------------------------------->  
 

<div class="modal fade" id="empsignup" tabindex="-1" role="dialog" aria-labelledby="myEmployerModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="background-image: url(img/1bck.jpg);">
    <div class="modal-header">
      <button id="signUpCloseBtn" class="close" data-dismiss="modal" aria-label="Close" style="color:white;">
        <span aria-hidden="true">&times;</span>
      </button>
      <h4 class="modal-title" id="myEmployerModalLabel"><?php echo t('create_account'); ?></h4>
    </div>
        
      <div class="modal-body">
          
          <!-- sign up form -->
          <div id="cd-empsignup"> 
            <div id="result" style="display:none;"></div>
            
            <div class="container" styles="">

                <ul class="nav nav-tabs" style="width: 535px;">
          <li class="active " style="padding-left: 30px;"><a data-toggle="tab" href="#home" class="ba"><?php echo t('employer_register'); ?></a></li>
          <li><a data-toggle="tab" class="ba" href="#menu1"><?php echo t('jobseeker_register'); ?></a></li>
                </ul>

                <div class="tab-content">
      <div id="home" class="tab-pane fadein active" style="width: 50%;">
          <h3 style="color: white; padding-left: 30px;"><?php echo t('register_as_employer'); ?></h3>
      <form class="cd-form" method="post" action="registerEmployer.php" enctype="multipart/form-data">
                                        <p class="fieldset" style="padding-right: 30px;">
						<label class="image-replace cd-username" for="empsignup-username">Username</label>
                                                <input class="full-width has-padding has-border" id="name" name="name" type="text" placeholder="<?php echo t('enter_username'); ?>">
						
					</p>

					<p class="fieldset" style="padding-right: 30px;">
						<label class="image-replace cd-email" for="empsignup-email">E-mail</label>
                                                <input class="full-width has-padding has-border" id="email" name="email" type="email" placeholder="<?php echo t('enter_email'); ?>">
						
					</p>

					<p class="fieldset" style="padding-right: 30px;">
						<label class="image-replace cd-password" for="empsignup-password">Password</label>
                                                <input class="full-width has-padding has-border" id="password" name="password" type="password"  placeholder="<?php echo t('enter_password'); ?>">
                                                <a href="#0" class="hide-password" style="color: grey; padding-right: 70px;">Show</a>
						
					</p>
                                 
                                        
					<p class="form-group">
                                            <button id="regsubmit" class="full-width has-padding btn-success"  style="padding:10px; background-color: #e9c46a;color:#1d3557;"><?php echo t('create_account'); ?></button>
					</p>
                                       
				</form>

    </div>
    <div id="menu1" class="tab-pane fade"  style="width: 50%;">
  <h3 style="color: white; padding-left: 30px;"><?php echo t('register_as_jobseeker'); ?></h3>
      <form class="cd-form" method="post" action="registerJobseeker.php" enctype="multipart/form-data">
					<p class="fieldset" style="padding-right: 30px;">
						<label class="image-replace cd-username" for="empsignup-username">Username</label>
                                                <input class="full-width has-padding has-border" id="name" name="name" type="text" placeholder="<?php echo t('enter_username'); ?>">
						
					</p>

					<p class="fieldset" style="padding-right: 30px;">
						<label class="image-replace cd-email" for="empsignup-email">E-mail</label>
                                                <input class="full-width has-padding has-border" id="email" name="email" type="email" placeholder="<?php echo t('enter_email'); ?>">
						
					</p>

					<p class="fieldset" style="padding-right: 30px;">
						<label class="image-replace cd-password" for="empsignup-password">Password</label>
                                                <input class="full-width has-padding has-border" id="password" name="password" type="password"  placeholder="<?php echo t('enter_password'); ?>">
                                                <a href="#0" class="hide-password" style="padding-right: 70px;">Show</a>
					
					</p>
                                        <p class="fieldset" style="padding-right: 30px;">
                                        	<label class="image-replace cd-username" for="empsignup-username"><?php echo t('qualification'); ?></label>
                                        	<input class="full-width has-padding has-border" id="qlf" name="qlf" type="text" placeholder="<?php echo t('qualification'); ?>">
                        	
                                        </p>
                                            <p class="fieldset" style="padding-right: 30px;">
                        	<label class=" image-replace cd-username" for="empsignup-username"><?php echo t('date_of_birth'); ?></label>
                        	<input class="full-width has-padding has-border" id="dob" name="dob" type="date" placeholder="<?php echo t('date_of_birth'); ?>">
                        	
                        </p>
                                         <p class="fieldset" style="padding-right: 30px;">
                        	<label class="image-replace cd-username" for="empsignup-username"><?php echo t('skills'); ?></label>
                                                <input class="full-width has-padding has-border" id="skills" name="skills" type="text" placeholder="<?php echo t('skills'); ?>">
                        	
                        </p>
                                        
                                       
					<p class="form-group">
                                            <button id="regsubmit" class="full-width has-padding btn-success" style="padding:10px; background-color: #e9c46a;color:#1d3557;">Create account</button>
					</p>
                                       
				</form>

    </div>
    
    
  </div>
</div>
            
	</div> <!-- cd-empsignup -->

		
     
    </div>
  </div>
</div></div>


<div><button id="regEmpSuccessSubmit" data-toggle="modal" data-target="#regEmpSuccess" style="display: none">Success Message</button></div>



  <!-- Success Modal -->
  <div class="modal fade" id="regEmpSuccess" tabindex="-1" role="dialog" aria-labelledby="myEmployerModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <button id="empSignInCloseBtn" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myEmployerModalLabel"><?php echo t('registration_successful'); ?></h4>
      </div>
      <div class="modal-body">
        <div id="cd-login">
                    
                       
                        <br><span>Login to continue</span>
                            <div class="center-block">
                              <button id="cancelEmpregModal" type="button" class="btn btn-default" data-dismiss="modal"  style="width: 150px;"><?php echo t('done'); ?></button>   
                              </div>             
			 
		</div>
        </div>
    </div>
</div>
  </div> 
  
<!-- OTP Verification Modal -->
<div class="modal fade" id="otpVerificationModal" tabindex="-1" role="dialog" aria-labelledby="otpModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="background-image: url(img/1bck.jpg);">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white;">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="otpModalLabel" style="color:white;">Email Verification</h4>
      </div>
      <div class="modal-body" style="color:white;">
        <p>An OTP has been sent to:</p>
        <p style="color: #e9c46a; font-weight: bold;" id="otpEmail"></p>
        
        <p style="margin-top: 20px;">Enter the 6-digit OTP:</p>
        <input type="text" id="otpInput" class="form-control" maxlength="6" placeholder="000000" style="font-size: 24px; text-align: center; letter-spacing: 10px; font-weight: bold;">
        
        <div id="otpMessage" style="margin-top: 15px; display: none;"></div>
        
        <div style="margin-top: 20px; text-align: center;">
          <p style="color: #999; font-size: 14px;">Time remaining:</p>
          <p style="font-size: 24px; color: #e9c46a; font-weight: bold;">
            <span id="timerMinutes">2</span>:<span id="timerSeconds">00</span>
          </p>
        </div>

        <div style="margin-top: 20px; text-align: center;">
          <button type="button" class="btn btn-primary" id="verifyOtpBtn" style="background-color: #e9c46a; color: #1d3557; border: none; width: 100%; padding: 10px;">
            Verify OTP
          </button>
        </div>

        <div style="margin-top: 15px; text-align: center;">
          <p style="color: #999; font-size: 13px;">Didn't receive OTP?</p>
          <button type="button" class="btn btn-link" id="resendOtpBtn" style="color: #e9c46a; text-decoration: none; padding: 0;">
            Resend OTP
          </button>
          <span id="resendMessage" style="display: none; color: #999; font-size: 13px; margin-left: 5px;"></span>
        </div>
      </div>
    </div>
  </div>
</div>

  <script src="js/registerUser.js"></script>
  <script src="js/otpVerification.js"></script>
