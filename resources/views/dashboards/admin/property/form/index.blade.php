@extends('dashboards.admin.layouts.app')
@section('content')
    <main id="content">
        <section class="py-5 mt-5">
            <div class="container">
                @include("layout.notifications.flash_messages")
                <div class="row login-register justify-content-center">
                    <div class="col-lg-5">
                        <div class="card border-0 shadow-xxs-2 mb-6">
                            <div class="card-body px-8 py-6">
                                <h2 class="card-title fs-30 font-weight-600 text-dark lh-16 mb-2">Upload Properties</h2>
                                <p class="mb-4">Select a CSV or Excel file containing the properties you want to upload in the right format.</p>
                                <form id="kycForm"action="{{ route("dashboard.admin.upload-property") }}" method="POST" class="form pb-3" enctype="multipart/form-data">@csrf
                                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                    <input type="hidden" name="redirect_url" value="{{ $redirect_url ?? null}}">
                                    <div class="form-group mb-4">
                                        <input type="file" class="form-control" name="property_file">
                                    </div>

                                    <button type="submit" class="btn btn-outline-primary btn-lg btn-block rounded">Upload</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
