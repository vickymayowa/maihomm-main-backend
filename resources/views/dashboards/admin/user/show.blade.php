@extends('dashboards.admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-12">
                <div class="d-flex justify-content-between">
                    <h5 class="default-color">View {{ $user->names() }}</h5>
                </div>
            </div>
            {{-- <a class="btn pt-0 pl-0 d-inline-block d-md-none" data-toggle="collapse" href="#displayOptions" role="button"
                aria-expanded="true" aria-controls="displayOptions">Display Options <i
                    class="simple-icon-arrow-down align-middle"></i></a>
            <div class="collapse d-md-block" id="displayOptions"> --}}
        </div>
        <div class="separator mb-5"></div>
        <div class="row">
            <div class="col-md-5">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="justify-content-between align-items-center d-flex">
                            <h6>Image</h6>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <img src="{{ $user->imageUrl() }}" style="max-width:50%; height:auto"
                                    class="rounded-circle img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header justify-content-between align-items-center d-flex">
                        <b>More Details</b>
                        <a class="btn btn-success btn-sm mb-2"
                        href="{{ route('dashboard.admin.users.edit', $user->id) }}">
                        <i class="fa fa-pencil"></i>
                    </a>
                    </div>
                    <div class="card-body">
                        <div class="mt-2">
                            <div class="mb-2">
                                <b>First name</b> : {{ $user->first_name }}
                            </div>
                            <div class="mb-2">
                                <b>Last name</b> : {{ $user->last_name }}
                            </div>
                            <div class="mb-2">
                                <b>Phone</b> : {{ $user->phone ?? 'N/A' }}
                            </div>
                            <div class="mb-2">
                                <b>Email</b> : {{ $user->email ?? 'N/A' }}
                            </div>
                            <div class="mb-2">
                                <b>Gender</b> : {{ $user->gender ?? 'N/A' }}
                            </div>
                            <div class="mb-2">
                                <b>Maiden Name</b> : {{ $user->maiden_name ?? 'N/A' }}
                            </div>
                            <div class="mb-2">
                                <b>Home Address</b> : {{ $user->home_address ?? 'N/A' }}
                            </div>
                            <div class="mb-2">
                                <b>DOB</b> : {{ $user->date_of_birth ?? 'N/A' }}
                            </div>
                            <div class="mb-2">
                                <b>Country</b> : {{ $user->country->name ?? 'N/A' }}
                            </div>
                            <div class="mb-2">
                                <b>State</b> : {{ $user->state->name ?? 'N/A' }}
                            </div>
                            <div class="mb-2">
                                <b>City</b> : {{ $user->city->name ?? 'N/A' }}
                            </div>
                            <div class="mb-2">
                                <b>Ref Code</b> : {{ $user->ref_code ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
