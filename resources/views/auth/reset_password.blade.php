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
                    <a href="../../demo1/dist/index.html" class="py-9 mb-5">
                        <img alt="Logo" src="{{asset('assets/media/logos/logo-2.svg')}}" class="h-60px" />
                    </a>
                    <h1 class="fw-bolder fs-2qx pb-5 pb-md-10" style="color: #986923;">Welcome to E-Office</h1>
                    <p class="fw-bold fs-2" style="color: #986923;">Discover Amazing Metronic
                        <br />with great build tools
                    </p>
                </div>
                <div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px" style="background-image: url({{asset('assets/media/illustrations/sketchy-1/13.png')}}"></div>
            </div>
        </div>
        <div class="d-flex flex-column flex-lg-row-fluid py-10">
        <div class="d-flex flex-center flex-column flex-column-fluid">
						<div class="w-lg-550px p-10 p-lg-15 mx-auto">
                        <form action="{{ route('auth.passwordResetSubmit') }}" method="POST" class="mt-4 mb-5" id="reset_password_form">
                        @csrf
								<div class="text-center mb-10">
									<h1 class="text-dark mb-3">Setup New Password</h1>									
								</div>
                                @if ($message = Session::get('error'))
                                <div class="alert alert-danger alert-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @endif
                                @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @endif
                                <input type="hidden" name="token" value="{{ $token }}">
								<div class="mb-10 fv-row" data-kt-password-meter="true">
									<div class="mb-1">                                    
										<label class="form-label fw-bolder text-dark fs-6">Password</label>
										<div class="position-relative mb-3">
                                            <input type="password" name="password" class="form-control form-control-lg form-control-solid" placeholder="Password" id="candidate_password_2">
											<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
												<i class="bi bi-eye-slash fs-2"></i>
												<i class="bi bi-eye fs-2 d-none"></i>
											</span>
										</div>
										<div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
										</div>
									</div>
									<div class="text-muted">Use 8 or more characters with a mix of letters, numbers &amp; symbols.</div>
								</div>
								<div class="fv-row mb-10">
									<label class="form-label fw-bolder text-dark fs-6">Confirm Password</label>
									<input type="password" name="password_confirm" class="form-control form-control-lg form-control-solid" placeholder="Confirm Password" id="confirm_password">
								</div>
                                
								<div class="d-flex flex-wrap justify-content-center pb-lg-0">
                                    <button data-sitekey="{{ config('services.recaptcha.site_key') }}"
                                    data-callback='onReset'
                                    data-action='login' class="g-recaptcha btn btn-primary btn-sm" id="send">Reset</button>
                                </div>
							</form>
						</div>
					</div>
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