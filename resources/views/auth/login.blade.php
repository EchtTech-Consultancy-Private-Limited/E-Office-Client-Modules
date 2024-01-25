@extends('layouts.master')
@push('form-style')
@include('layouts.partials.form_css')
@endpush
@section('style')
@endsection
@section('content')
<div class="d-flex flex-column flex-root">
	<div class="d-flex flex-column flex-lg-row flex-column-fluid">
		<div class="d-flex flex-column flex-lg-row-auto w-xl-600px positon-xl-relative" style="background-color: #F2C98A">
			<div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px scroll-y">
				<div class="d-flex flex-row-fluid flex-column text-center p-10 pt-lg-20">
					<a href="{{ route('index') }}" class="py-9 mb-5">
          <img alt="Logo" src="{{asset('assets/media/logos/logo-2.svg')}}" class="h-60px" />
					</a>
					<h1 class="fw-bolder fs-2qx pb-5 pb-md-10" style="color: #986923;">Welcome to E-Office</h1>
					<p class="fw-bold fs-2" style="color: #986923;">Discover Amazing Metronic
					<br />with great build tools</p>
				</div>
        <div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px" style="background-image: url({{asset('assets/media/illustrations/sketchy-1/13.png')}}"></div>
			</div>
		</div>
		<div class="d-flex flex-column flex-lg-row-fluid py-10">
			<div class="d-flex flex-center flex-column flex-column-fluid">
				<div class="w-lg-500px p-10 p-lg-15 mx-auto" id="login_user_name">
        <form action="{{ route('auth.loginUser') }}" method="post" class="mt-4" id="candidate_login_form">
        @csrf
        <input type="hidden" name="g-recaptcha-response" value="" id="g-recaptcha-response">
						<div class="text-center mb-10">
							<h1 class="text-dark mb-3">Sign In to E-Office</h1>
						</div>
						<div class="fv-row mb-10">
							<label class="form-label fw-bolder text-dark fs-6 mb-0">Enter User Name<em class="text-danger">*</em></label>
              <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg" type="text" name="username" placeholder="Enter User name" autocomplete="off"/>
              
              <span class="error-msg" id="login_username"></span>
						</div>
						<div class="text-center">
							<button type="button" value="login_with_otp" id="login_with_otp" class="btn btn-lg btn-primary w-40 mb-5">
								<span class="indicator-label">Sign In</span>
							</button>
              <a href="{{ route('auth.forgetPassword') }}" role="tab" class="fs-6 px-2 fw-bolder link-primary">Forgot Password</a>
						</div>
					</form>
				</div>
			</div>

      <!-- OTP Verification section -->
      <div class="w-lg-600px p-10 p-lg-15 mx-auto" id="otp">
          <div class="text-center mb-10">
            <img alt="Logo" class="mh-125px" src="{{ asset('assets/media/svg/misc/smartphone.svg') }}" />
          </div>
          <div class="text-center mb-10">
            <h1 class="text-dark mb-3">Two Step OTP Verification</h1>
            <div class="text-muted fw-bold fs-5 mb-5">Enter the verification code we sent to mobile number and email</div>
            <div class="fw-bolder text-dark fs-3" id="hidden_mobile_num"></div>
            <div class="fw-bolder text-dark fs-3" id="hidden_email_num"></div>
          </div>
          <form action="{{ route('auth.verifyOtp') }}" method="POST" class="mt-4" id="verify_otp">
            @csrf
            <input type="hidden" name="email" id="email" value="">
            <input type="hidden" name="mobile_number" id="mob_number" value="">
            <input type="hidden" name="userRole" id="user_role" value="">
            <input type="hidden" name="otp_type" id="otp_type" value="">
            <input type="hidden" name="g-recaptcha-response" value="" id="g-recaptcha-response">
          <div class="mb-10 px-md-10 otp-event">
            <div class="text-center fw-bolder text-start text-dark fs-6 mb-1 ms-1">Type your 4 digit security code</div>
            <div class="otp-container">
              <input type="tel" name="verify_otp[]" id="otp-number-input-1" class="otp-number-input" maxlength="1" autocomplete="off">
              <input type="tel" name="verify_otp[]" id="otp-number-input-2" class="otp-number-input" maxlength="1" autocomplete="off">
              <input type="tel" name="verify_otp[]" id="otp-number-input-3" class="otp-number-input" maxlength="1" autocomplete="off">
              <input type="tel" name="verify_otp[]" id="otp-number-input-4" class="otp-number-input" maxlength="1" autocomplete="off">            
            </div>
            <div class="text-center mb-10">
              <h6 class="mb-0 pb-0 mt-3">expery: <b class="orange-clr" id="timer"></b>
              <b class="orange-clr" id="resend_timer"></b></h6>
              <input type="hidden" id="verificationCode" />
              <span class="text-danger otp_timer_expired"></span></p>
              <span class="text-danger otp_resend_expired"></span></p>
              <span class="text-danger verify_otp_error"></span>
              <span class="text-danger" id="resend"></span>
            </div>
          </div>
          <div class="d-flex flex-center">
            <button  id="confirm" type="button" name="" value="Verify" class="otp-submit verify_otp_btn btn btn-lg btn-primary fw-bolder">
              <span class="indicator-label">Verify OTP</span>
              <span class="indicator-progress">Please wait...
              <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
          </div>
        </form>
        <div class="text-center fw-bold fs-5">
          <span class="text-muted me-1">Didn’t get the code ?</span>
          <a href="javascript:;" class="text-primary fw-bolder fs-5 me-1 font-size-h6 font-weight-bolder text-hover-primary pt-5 resend_sms disabled">Resend OTP</a>
        </div>
      </div>
    <!-- End OTP Verification HTML -->
                
    <!-- Enter Password section -->
    <div class="d-flex flex-center flex-column flex-column-fluid">        
				<div class="w-lg-500px p-10 p-lg-15 mx-auto" id="user_password">
        <form action="{{ route('auth.loginPassworsUser') }}" method="post" id="login_with_pass">
        @csrf
        <input type="hidden" name="g-recaptcha-response" value="" id="g-recaptcha-response">
            <div class="text-center pb-13 pt-lg-0 pt-5">
                <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Enter your password to login your account</h3>
                <img alt="Logo" class="mh-125px" src="{{ asset('assets/media/images/reset-password.png') }}" />
            </div>
            <!-- <div class="text-center fw-bolder text-start text-dark fs-6 mb-1 ms-1">Enter your password to login your account</div> -->
            <div class="form-group">
                <input type="hidden" name="password_email" id="password_email" value="">
                <input type="hidden" name="password_mobile_number" id="password_mob_number" value="">
                <input type="hidden" name="login" value="login_with_password">
                <input type="hidden" name="password_userRole" id="password_user_role" value="">
                <label class="form-label fw-bolder text-dark fs-6 mb-0">Enter Password<em class="text-danger">*</em></label>
                <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg font-size-h6" type="password" placeholder="Enter Password" name="password" autocomplete="off" />
                <span class="text-danger password_error"></span></p>
            </div>
            <div class="form-group d-flex flex-wrap pb-lg-0 align-items-center">
                <button type="button" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-4 verify_password_btn">Login</button>
                <a href="{{ route('auth.forgetPassword') }}" role="tab" class="fs-6 px-2 fw-bolder link-primary">Forgot Password</a>
            </div>
        </form>
				</div>
			</div>
    <!-- End Enter Password section -->

			<div class="d-flex flex-center flex-wrap fs-6 p-5 pb-0">
				<div class="d-flex flex-center fw-bold fs-6">
					<a href="#" class="text-muted text-hover-primary px-2" target="_blank">© 2023 E-Office, All rights reserved.</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
<!-- End this section for HTML content -->

<!-- JS script links only starts here -->
@push('js-scripts')
    @include('layouts.partials.form_js')
    @include('layouts.partials.auth.auth')
@endpush
<!-- Custom script only starts here -->
@section('script')
@endsection
<!-- End Custom script only starts here -->