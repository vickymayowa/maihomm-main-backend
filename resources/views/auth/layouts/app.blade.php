<!doctype html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

@include("auth.layouts.includes.head")

<body>
    {{-- @include("auth.layouts.includes.header") --}}

    @yield("content")

    {{-- @include("auth.layouts.includes.footer") --}}
    @include("auth.layouts.includes.scripts")
    <div class="modal fade login-register login-register-modal" id="login-register-modal" tabindex="-1" role="dialog" aria-labelledby="login-register-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mxw-571" role="document">
            <div class="modal-content">
                <div class="modal-header border-0 p-0">
                    <div class="nav nav-tabs row w-100 no-gutters" id="myTab" role="tablist">
                        <a class="nav-item col-sm-3 ml-0 nav-link pr-6 py-4 pl-9 active fs-18" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">Login</a>
                        <a class="nav-item col-sm-3 ml-0 nav-link py-4 px-6 fs-18" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">Register</a>
                        <div class="nav-item col-sm-6 ml-0 d-flex align-items-center justify-content-end">
                            <button type="button" class="close m-0 fs-23" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-body p-4 py-sm-7 px-sm-8">
                    <div class="tab-content shadow-none p-0" id="myTabContent">
                        <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                            <form class="form">
                                <div class="form-group mb-4">
                                    <label for="username" class="sr-only">Username</label>
                                    <div class="input-group input-group-lg">
                                        <div class="input-group-prepend ">
                                            <span class="input-group-text bg-gray-01 border-0 text-muted fs-18" id="inputGroup-sizing-lg">
                                                <i class="far fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control border-0 shadow-none fs-13" id="username" name="username" required placeholder="Username / Your email">
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="password" class="sr-only">Password</label>
                                    <div class="input-group input-group-lg">
                                        <div class="input-group-prepend ">
                                            <span class="input-group-text bg-gray-01 border-0 text-muted fs-18">
                                                <i class="far fa-lock"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control border-0 shadow-none fs-13" id="password" name="password" required placeholder="Password">
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-gray-01 border-0 text-body fs-18">
                                                <i class="far fa-eye-slash"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="remember-me" name="remember-me">
                                        <label class="form-check-label" for="remember-me">
                                            Remember me
                                        </label>
                                    </div>
                                    <a href="password-recovery.html" class="d-inline-block ml-auto text-orange fs-15">
                                        Lost password?
                                    </a>
                                </div>
                                <div class="d-flex p-2 border re-capchar align-items-center mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="verify" name="verify">
                                        <label class="form-check-label" for="verify">
                                            I'm not a robot
                                        </label>
                                    </div>
                                    <a href="#" class="d-inline-block ml-auto">
                                        <img src="images/re-captcha.png" alt="Re-capcha">
                                    </a>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Log in</button>
                            </form>
                            <div class="divider text-center my-2">
                                <span class="px-4 bg-white lh-17 text">
                                    or continue with
                                </span>
                            </div>
                            <div class="row no-gutters mx-n2">
                                <div class="col-4 px-2 mb-4">
                                    <a href="#" class="btn btn-lg btn-block facebook text-white px-0">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </div>
                                <div class="col-4 px-2 mb-4">
                                    <a href="#" class="btn btn-lg btn-block google px-0">
                                        <img src="images/google.png" alt="Google">
                                    </a>
                                </div>
                                <div class="col-4 px-2 mb-4">
                                    <a href="#" class="btn btn-lg btn-block twitter text-white px-0">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                            <form class="form">
                                <div class="form-group mb-4">
                                    <label for="full-name" class="sr-only">Full name</label>
                                    <div class="input-group input-group-lg">
                                        <div class="input-group-prepend ">
                                            <span class="input-group-text bg-gray-01 border-0 text-muted fs-18">
                                                <i class="far fa-address-card"></i></span>
                                        </div>
                                        <input type="text" class="form-control border-0 shadow-none fs-13" id="full-name" name="full-name" required placeholder="Full name">
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="username01" class="sr-only">Username</label>
                                    <div class="input-group input-group-lg">
                                        <div class="input-group-prepend ">
                                            <span class="input-group-text bg-gray-01 border-0 text-muted fs-18">
                                                <i class="far fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control border-0 shadow-none fs-13" id="username01" name="username01" required placeholder="Username / Your email">
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="password01" class="sr-only">Password</label>
                                    <div class="input-group input-group-lg">
                                        <div class="input-group-prepend ">
                                            <span class="input-group-text bg-gray-01 border-0 text-muted fs-18">
                                                <i class="far fa-lock"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control border-0 shadow-none fs-13" id="password01" name="password01" required placeholder="Password">
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-gray-01 border-0 text-body fs-18">
                                                <i class="far fa-eye-slash"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <p class="form-text">Minimum 8 characters with 1 number and 1 letter</p>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Sign up</button>
                            </form>
                            <div class="divider text-center my-2">
                                <span class="px-4 bg-white lh-17 text">
                                    or continue with
                                </span>
                            </div>
                            <div class="row no-gutters mx-n2">
                                <div class="col-4 px-2 mb-4">
                                    <a href="#" class="btn btn-lg btn-block facebook text-white px-0">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </div>
                                <div class="col-4 px-2 mb-4">
                                    <a href="#" class="btn btn-lg btn-block google px-0">
                                        <img src="images/google.png" alt="Google">
                                    </a>
                                </div>
                                <div class="col-4 px-2 mb-4">
                                    <a href="#" class="btn btn-lg btn-block twitter text-white px-0">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="mt-2">By creating an account, you agree to HomeID
                                <a class="text-heading" href="#"><u>Terms of Use</u> </a> and
                                <a class="text-heading" href="#"><u>Privacy Policy</u></a>.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include("auth.layouts.includes.symbols")

    <div class="position-fixed pos-fixed-bottom-right p-6 z-index-10">
        <a href="#" class="gtf-back-to-top bg-white text-primary hover-white bg-hover-primary shadow p-0 w-52px h-52 rounded-circle fs-20 d-flex align-items-center justify-content-center" title="Back To Top"><i class="fal fa-arrow-up"></i></a>
    </div>
</body>

</html>
