@extends('layouts.master')
@push('form-style')
    @include('layouts.partials.form_css')
@endpush
@section('style')
    <style>
        .error-msg {
            color: red;
        }

        #verify_email {
            display: none;
        }
    </style>
@endsection
@section('content')
    <!-- End this section for HTML content -->
    <div class="d-flex flex-column flex-root">
        <div id="pageloader">
            <div id="top">
                <span class="loader"></span>
            </div>
        </div>
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <div class="d-flex flex-column flex-lg-row-auto w-xl-600px positon-xl-relative" style="background-color: #F2C98A">
                <div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px scroll-y">
                    <div class="d-flex flex-row-fluid flex-column text-center p-10 pt-lg-20">
                        <a href="{{ route('index') }}" class="py-9 mb-5">
                            <img alt="Logo" src="{{ asset('assets/media/logos/logo-2.svg') }}" class="h-60px" />
                        </a>
                        <h1 class="fw-bolder fs-2qx pb-5 pb-md-10" style="color: #986923;">Welcome to Metronic</h1>
                        <p class="fw-bold fs-2" style="color: #986923;">Discover Amazing Metronic
                            <br />with great build tools
                        </p>
                    </div>
                    <div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px"
                        style="background-image: url({{ asset('assets/media/illustrations/sketchy-1/13.png') }}"></div>
                </div>
            </div>
            <div class="d-flex flex-column flex-lg-row-fluid py-10">
                <div class="d-flex flex-center flex-column flex-column-fluid">
                    <div class="w-lg-500px p-10 p-lg-15 mx-auto">
                        <form action="{{ route('auth.checkForgotPassword') }}" method="POST" class="mt-4 mb-5"
                            id="forgot_password_form">
                            @csrf
                            <div class="text-center mb-10">
                                <h1 class="text-dark mb-3">Forgot Password ?</h1>
                                <div class="text-gray-400 fw-bold fs-4">Enter your email and we'll send you a link to to get
                                    back into your account</div>
                                <p class="error-msg"></p>
                            </div>
                            @if (empty($user))
                                <div class="fv-row mb-10">
                                    <label class="form-label fw-bolder text-gray-900 fs-6">Enter Email or Phone<em
                                            class="text-danger">*</em></label></label>
                                    <input type="text" name="email_or_phone" id="email"
                                        value="{{ old('email_or_phone') }}"
                                        class="form-control form-control form-control-solid" data-parsley-type="text"
                                        placeholder="email or phone"
                                        data-parsley-error-message="Please enter email or phone"
                                        data-parsley-trigger="keyup" required>
                                    @if ($message = Session::get('error'))
                                        <p class="error-msg">{{ $message }}</p>
                                    @endif
                                    @if ($message = Session::get('success'))
                                        <p class="error-msg">{{ $message }}</p>
                                    @endif
                                    <strong id="msg" class="text-success my-2 d-none">Successfull Send</strong>
                                </div>
                                <div class="mt-4 mb-4">
                                    @if ($errors->has('g-recaptcha-response'))
                                        <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                                    @endif
                                </div>
                                <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                                    <button data-sitekey="{{ config('services.recaptcha.site_key') }}"
                                        data-callback='onForgot' data-action='login'
                                        class="g-recaptcha btn btn-primary btn-sm" id="send">Send</button>
                                </div>
                            @else
                                <div class="text-blue-400 fw-bold fs-4 text-center bg-primary text-white p-2">Choose From
                                    Below Option</div>
                                <div id="varification" class="mt-3">
                                    <div class="position-relative">
                                        <h2 class="text-primary"><i
                                                class="text-primary fas fa-mobile-alt position-absolute start-0"></i></h3>
                                            <input type="hidden" name="email" value="{{ $user->mobile_number }}"
                                                id="forgot_mobile_number">
                                            <span class="ms-4 ps-2"> <a href="#" id="reset_password_mobile_number"
                                                    class="text-black">Get a verification code at +91
                                                    {{ substr($user->mobile_number, 0, 2) }}******{{ substr($user->mobile_number, -2) }}
                                                    phone number</a></span>
                                    </div><br>
                                    <div class="text-blue-400 fw-bold fs-4 text-center">OR</div>
                                    <div class="position-relative">
                                        <h3 class="text-primary"><i
                                                class="text-primary fa fa-envelope-open-text position-absolute start-0"></i>
                                        </h3>
                                        <input type="hidden" name="email" value="{{ $user->email }}" id="forgot_email">
                                        <span class="ms-4 ps-2"><a href="#"
                                                class="text-black reset_password_email">Get a verification code at
                                                {{ substr($user->email, 0, 2) }}*******{{ substr($user->email, -12) }}
                                                email</a></span>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Verification OTP model show -->
        <div id="otpModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div id="pageloader">
                <div id="top">
                    <span class="loader"></span>
                </div>
            </div>
            <div class="modal-dialog modal-dialog-centered modal" role="document">

                <div class="modal-content border-0">
                    <div class="modal-header p-4 bg-primary">
                        <h4 class="mb-0 text-center text-white">OTP</h4>
                        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                    </div>
                    <div class="text mt-4 text-center">
                        <h6 class="text-primary">Verification</h6>
                        <img src="{{ asset('assets/media/svg/misc/smartphone.svg') }}" alt="" class=""
                            width="80">
                    </div>
                    <div class="modal-body pt-0 mb-3">
                        <div class="login-register">
                            <div class="tab-content">
                                <div class="tab-pane active" id="candidate" role="tabpanel">
                                    @if (session('error'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    @if (session('success'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    <div class="row">

                                        <form action="{{ route('auth.verifyOtp') }}" method="POST"
                                            class="mt-4 input_formate_otp" id="verify_forgot_otp">
                                            @csrf
                                            <div class="otp-event text-center verification-code">
                                                <span
                                                    class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Sent
                                                    a verification code to verify <br>your mobile number </span><br>
                                                <b><label class="control-label my-3"><span
                                                            id="hidden_forgot_num"></span></label></b>
                                                <input type="hidden" name="mobile_number" id="mob_number"
                                                    value="">
                                                <input type="hidden" name="email" id="email" value="">
                                                <input type="hidden" name="userRole" id="user_role" value="">
                                                <input type="hidden" name="otp_type" id="otp_type" value="">
                                                <div class="verification-code otp-container inputs border-top-0">
                                                    <input class="inputs otp-number-input keyword_1" type="text"
                                                        name="verify_otp[]" id="otp-number-input-1" maxlength="1"
                                                        required />
                                                    <input class="inputs otp-number-input keyword_1" type="text"
                                                        name="verify_otp[]" id="otp-number-input-2" maxlength="1"
                                                        required />
                                                    <input class="inputs otp-number-input keyword_1" type="text"
                                                        name="verify_otp[]" id="otp-number-input-3" maxlength="1"
                                                        required />
                                                    <input class="inputs otp-number-input keyword_1" type="text"
                                                        name="verify_otp[]" id="otp-number-input-4" maxlength="1"
                                                        required />

                                                </div>
                                                <h6 class="text-center mb-0 pb-0 mt-3">expery: <b style="color:#f25e20;"
                                                        id="timer"></b><b style="color:#f25e20;"
                                                        id="forgot_resend_timer"></b></h6>
                                                <input type="hidden" id="verificationCode" />
                                            </div>
                                            <div class="row text-center mt-3">
                                                <div class="col-md-12">
                                                    <button type="button" name="" value="Verify"
                                                        class="otp-submit verify_forgot_otp_btn btn btn-primary btn-sm">Verify</button>
                                                    <div class="text-center">
                                                        <span class="text-danger otp_timer_expired"></span></p>
                                                        <span class="text-danger verify_otp_error"></span>
                                                        <span class="text-danger" id="resend"></span>
                                                        <a href="#" class="forgot_resend_sms"><u>Resend OTP</u></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Email semd success Popup Open -->
        <div id="emailModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal" role="document">
                <div class="modal-content border-0">
                    <div class="modal-header p-4 bg-primary">
                        <h4 class="mb-0 text-center text-white">OTP</h4>
                        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                    </div>
                    <div class="text mt-4 text-center">
                        <h6 class="text-primary">Verification</h6>
                        <img src="{{ asset('assets/media/images/forgot.png') }}" alt="" class=""
                            width="120">
                    </div>
                    <div class="modal-body pt-0 mb-3">
                        <div class="login-register">
                            <div class="tab-content">
                                <div class="tab-pane active" id="candidate" role="tabpanel">
                                    <div class="row">
                                        <form class="mt-4">
                                            <div class="verification-code text-center">
                                                <h5 class="">Check Your Mail</h5>
                                                <span class="text-black">We have sent a password recover<br> instructions
                                                    to your email.</span><br>
                                                <a href="#"
                                                    class="btn btn-primary btn-sm mx-auto text-center mt-3">Open email
                                                    aap</a><br>
                                            </div>

                                            <div class="row text-center">
                                                <div class="col-md-12">
                                                    <span class=""><a href="#" class="btn"
                                                            id="resend_password_email" style="color:#f25e20;">Resend
                                                            email</a></span>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- JS script links only starts here -->
@push('js-scripts')
    @include('layouts.partials.form_js')
    @include('layouts.partials.auth.auth')
@endpush
<!-- Custom script only starts here -->
@section('script')
    <script>
        // send reset password link on email
        $(document).on('click', '.reset_password_email', function() {
            $("#pageloader").fadeIn();
            let email = $('#forgot_email').val();
            const data = {
                "_token": "{{ csrf_token() }}",
                email: email,
            };
            $.ajax({
                type: "POST",
                url: "{{ route('auth.submitForgetPassword') }}",
                data: data,
                success: function(response) {
                    $("#pageloader").fadeOut();
                    if (response == 402) {
                        $('.error-msg ').text('Oops something went wrong !');
                    } else {
                        $("#emailModal").modal("show");
                    }
                }
            });

        });
        // End Send reset password link
        // resend emailForgot password
        $(document).on('click', '#resend_password_email', function() {
            $("#pageloader").fadeIn();
            let email = $('#forgot_email').val();
            const data = {
                "_token": "{{ csrf_token() }}",
                email: email,
            };
            $.ajax({
                type: "POST",
                url: "{{ route('auth.submitForgetPassword') }}",
                data: data,
                success: function(response) {
                    $("#pageloader").fadeOut();
                    if (response == 402) {
                        $('.error-msg ').text('Oops something went wrong !');
                    } else {
                        $("#emailModal").modal("show");
                    }
                }
            });

        });
        // End resend emailForgot password

        // Send OTP For Reset password
        $(document).on('click', '#reset_password_mobile_number', function() {
            $("#pageloader").fadeIn();
            let mobile_number = $('#forgot_mobile_number').val();
            const data = {
                "_token": "{{ csrf_token() }}",
                mobile_number: mobile_number,
                login_with_otp: 'reset_with_mobile_number',
            };
            $.ajax({
                type: "POST",
                url: "{{ route('auth.submitForgetPassword') }}",
                data: data,
                success: function(response) {
                    $("#pageloader").fadeOut();
                    if (response == 402) {
                        $('#login_mobile_number').text('Oops something went wrong !')
                    } else {
                        // check OTP Expiration
                        let timerOn = true;

                        function timer(remaining) {
                            var m = Math.floor(remaining / 60);
                            var s = remaining % 60;

                            m = m < 10 ? '0' + m : m;
                            s = s < 10 ? '0' + s : s;
                            document.getElementById('timer').innerHTML = m + ':' + s;
                            remaining -= 1;

                            if (remaining >= 0 && timerOn) {
                                setTimeout(function() {
                                    timer(remaining);
                                }, 1000);
                                return;
                            }

                            if (!timerOn) {
                                // Do validate stuff here
                                return;
                            }
                            $(".otp_timer_expired").text("OTP expired !");
                        }
                        timer(120);

                        $("#otpModal").modal("show");
                        var mobileNum = response.userDetail.mobile_number;
                        var lastTwoDigit = String(mobileNum).slice(-3);
                        var numTest = 'Send To +91********' + lastTwoDigit;
                        $('#hidden_forgot_num').text(numTest);
                        $('#mob_number').val(response.userDetail.mobile_number);
                        $('#email').val(response.userDetail.email);
                        $('#user_role').val(response.userDetail.userRole);
                        $('#otp_type').val(response.userDetail.otp_type);
                    }

                }
            });

        });
        // End Send OTp For Reset password

        // Check OTP Vrification
        // resend OTP
        jQuery(document).on('click', ".forgot_resend_sms", function() {
            $(".verify_otp_error").text('');
            $("#pageloader").fadeIn();
            let email = $('#email').val();
            let mobile_number = $('#mob_number').val();
            let otp_type = $('#otp_type').val();
            jQuery.ajax({
                type: 'post',
                url: '{{ route('auth.resendOtp') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "action": "resend_sms",
                    'email': email,
                    'mobile_number': mobile_number,
                    'otp_type': otp_type
                },
                success: function(response) {
                    $("#pageloader").fadeOut();
                    // console.log("response", response)
                    $('#resend').text(response);
                    $('#timer').css("display", "none");
                    $(".otp_timer_expired").css("display", "none");
                    let timerOn = true;

                    function timer(remaining) {
                        var m = Math.floor(remaining / 60);
                        var s = remaining % 60;

                        m = m < 10 ? '0' + m : m;
                        s = s < 10 ? '0' + s : s;
                        document.getElementById('forgot_resend_timer').innerHTML = m + ':' + s;
                        remaining -= 1;

                        if (remaining >= 0 && timerOn) {
                            setTimeout(function() {
                                timer(remaining);
                            }, 1000);
                            return;
                        }

                        if (!timerOn) {
                            // Do validate stuff here
                            return;
                        }
                        $(".otp_timer_expired").text("OTP expired !");
                    }
                    timer(120);
                }
            });
        });

        // Verify OTP 
        jQuery(document).on('click', ".verify_forgot_otp_btn", function() {
            $("#resend").text('');
            $("#pageloader").fadeIn();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var verify_otp_1 = $("#verify_otp_1").val();
            var verify_otp_2 = $("#verify_otp_2").val();
            var verify_otp_3 = $("#verify_otp_3").val();
            var verify_otp_4 = $("#verify_otp_4").val();
            if (verify_otp_1 == "" || verify_otp_2 == "" || verify_otp_3 == "" || verify_otp_4 == "") {
                $(".verify_otp_error").text("Please enter your verification code.");
            } else {
                var data = new FormData(verify_forgot_otp);
                var otp_type = 'forgot_password';
                $.ajax({
                    type: "POST",
                    url: "{{ route('auth.verifyOtp') }}",
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $("#pageloader").fadeOut();
                        if (response.status == 1) {
                            window.location.href = response.token
                        } else if (response.status == 0) {
                            $(".verify_otp_error").text("Please enter valid verification code.");
                        } else if (response.status == 2) {
                            $(".verify_otp_error").text("Your OTP Expired !");
                        }
                    }
                });
            }

        });
        // End Verify OTP
        function onForgot(token) {
            document.getElementById("forgot_password_form").submit();
        }
    </script>
    <!-- Custom script links only ends here -->
@endsection
<!-- End Custom script only starts here -->
