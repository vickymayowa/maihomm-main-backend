@extends('dashboards.user.layouts.app')

@section('content')
    <main id="content" class="bg-gray-01">
        <div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10">
            <div class="mb-6">
                <h2 class="mb-0 text-heading fs-22 lh-15">My Profile
                </h2>
            </div>
            @include('notifications.flash_messages')
            <form action="{{ route('dashboard.user.update-profile') }}" method="post" enctype="multipart/form-data">@csrf
                @method('PATCH')
                <div class="row mb-6">
                    <div class="col-lg-5">
                        <div class="card mb-6">
                            <div class="card-body px-6 pt-6 pb-5">
                                <div class="row">
                                    <div class="col-sm-4 col-xl-12 col-xxl-7 mb-6">
                                        <h3 class="card-title mb-0 text-heading fs-22 lh-15">Photo</h3>
                                        <p class="card-text">Upload your profile photo.</p>
                                    </div>
                                    <div class="col-sm-8 col-xl-12 col-xxl-5">
                                        {{-- <img src="{{ $web_assets }}/images/my-profile.png" alt="My Profile" class="w-100"> --}}
                                        <img src="{{ $user->imageUrl() }}" alt="My Profile" style="border-radius: 10px"
                                            class="w-100">
                                        <div class="custom-file mt-4 h-auto">
                                            <input type="file" class="custom-file-input" hidden id="customFile"
                                                name="avatar_id">
                                            <label class="btn btn-secondary btn-lg btn-block" for="customFile">
                                                <span class="d-inline-block mr-1"><i
                                                        class="fal fa-cloud-upload"></i></span>Upload
                                                image</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="card mb-6">
                            <div class="card-body px-6 pt-6 pb-5">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title mb-0 text-heading fs-22 lh-15">Contact information
                                    </h3>

                                    @if ($user->isVerified())
                                        <div class="d-flex">
                                            <p class="fs-20">Verified</p>
                                            <div class="ml-2 text-success" style="margin-top:5px">
                                                <i class="fa fa-check-square-o fa-2x" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    @else
                                        <div class="d-flex">
                                            <p class="fs-20">
                                                <a class="btn btn-primary d-flex"
                                                    href="{{ route('dashboard.user.show-kyc-page', ['redirect_url' => $redirect_url ?? url()->current()]) }}">
                                                    Unverified
                                                    <i class="fa fa-ban fa-2x ml-2" style="margin-top:-2px" aria-hidden="true"></i>
                                                </a>
                                            </p>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-row mx-n4 mt-3">
                                    <div class="form-group col-md-6 px-4">
                                        <label for="firstName" class="text-heading">First name</label>
                                        <input type="text" class="form-control form-control-lg border-0" id="firstName"
                                            name="first_name" value="{{ $user->first_name ?? old('first_name') }}">
                                    </div>
                                    <div class="form-group col-md-6 px-4">
                                        <label for="lastName" class="text-heading">Last name</label>
                                        <input type="text" class="form-control form-control-lg border-0" id="lastName"
                                            name="last_name" value="{{ $user->last_name ?? old('last_name') }}">
                                    </div>
                                </div>
                                <div class="form-row mx-n4">
                                    <div class="form-group col-md-6 px-4">
                                        <label for="phone" class="text-heading">Phone</label>
                                        <input type="text" class="form-control form-control-lg border-0" id="phone"
                                            name="phone_no" value="{{ $user->phone_no ?? old('phone_no') }}">
                                    </div>
                                    <div class="form-group col-md-6 px-4 mb-md-0">
                                        <label for="email" class="text-heading">Email</label>
                                        <input type="email" class="form-control form-control-lg border-0" id="email"
                                            name="" readonly value="{{ $user->email ?? old('email') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body px-6 pt-6 pb-5">
                                <h3 class="card-title mb-0 text-heading fs-22 lh-15">Change password</h3>
                                <div class="form-group">
                                    <label for="oldPassword" class="text-heading">Old Password</label>
                                    <input type="password" class="form-control form-control-lg border-0" id="oldPassword"
                                        autocomplete="new-password" name="old_password">
                                </div>
                                <div class="form-row mx-n4">
                                    <div class="form-group col-md-6 col-lg-12 col-xxl-6 px-4">
                                        <label for="newPassword" class="text-heading">New Password</label>
                                        <input type="password" class="form-control form-control-lg border-0"
                                            id="newPassword" name="password">
                                    </div>
                                    <div class="form-group col-md-6 col-lg-12 col-xxl-6 px-4">
                                        <label for="confirmNewPassword" class="text-heading">Confirm New
                                            Password</label>
                                        <input type="password" class="form-control form-control-lg border-0"
                                            id="confirmNewPassword" name="password_confirmation">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end flex-wrap">
                    <button class="btn btn-lg btn-primary ml-4 mb-3">Update Profile</button>
                </div>
            </form>
        </div>
    </main>
@endsection
