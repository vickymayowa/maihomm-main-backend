@extends('dashboards.admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 style="color: #dea739">All Users</h1>
                <div class="top-right-button-container">
                    <a href="" class="btn btn-primary btn-lg top-right-button mr-1">ADD NEW</a>
                </div>
                <a class="btn pt-0 pl-0 d-inline-block d-md-none" data-toggle="collapse" href="#displayOptions" role="button"
                    aria-expanded="true" aria-controls="displayOptions">Display Options <i
                        class="simple-icon-arrow-down align-middle"></i></a>
                <div class="collapse d-md-block" id="displayOptions">
                    <div class="d-block d-md-inline-block">
                        <div class="btn-group float-md-left mr-1 mb-1">
                            <div class=" d-inline-block float-md-left mr-1 mb-1 align-top">
                                <form class="input-group" action="{{ url()->current() }}" method="GET">
                                    <input class="form-control" type="text" name="search"
                                        value="{{ request()->query('search') }}" placeholder="Search...">
                                    <button class="btn btn-outline-primary btn-sm ml-3">Filter</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="separator mb-5"></div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sn</th>
                                        <th>Full name</th>
                                        <th>Email Address</th>
                                        <th>Gender</th>
                                        <th>Phone</th>
                                        <th>D.O.B</th>
                                        <th>Status</th>
                                        <th>Date/Time</th>
                                        {{-- <th>Actions</th> --}}

                                    </tr>
                                </thead>
                                @php
                                    $sn = $users->firstItem();
                                @endphp
                                @foreach ($users as $user)
                                    <tbody>
                                        <tr>
                                            <td>{{ $sn++ }}</td>
                                            <td>{{ $user->first_name }}{{ $user->last_name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->gender }}</td>
                                            <td>{{ $user->phone }}</td>
                                            <td>{{ $user->dob }}</td>
                                            <td>{{ $user->status }}</td>
                                            <td>{{ $user->created_at }}</td>
                                            {{-- <td>
                                                <form action="{{ route('dashboard.admin.users.destroy', [$user->id]) }}"
                                                    method="POST">
                                                    @csrf @method('Delete')
                                                    @if (isSudo())
                                                        <a class="btn btn-warning btn-sm mb-2"
                                                            href="{{ Route('dashboard.admin.users.show', [$user->id]) }}">
                                                            <i class="simple-icon-settings"></i>
                                                        </a>
                                                        <a href="{{ route('dashboard.admin.users.imitate', $user->id) }}"
                                                            class="btn btn-dark btn-sm mb-2"
                                                            onclick="return confirm('Are you sure you want to login as this user?')"
                                                            data-toggle="tooltip" data-placement="top" title="Edit"><i>
                                                                <i class="simple-icon-user"></i>
                                                        </a>
                                                    @endif
                                                    <a class="btn btn-success btn-sm mb-2"
                                                        href="{{ route('dashboard.admin.users.edit', [$user->id]) }}">
                                                        <i class="simple-icon-pencil"></i>
                                                    </a>
                                                    <button class="btn btn-danger btn-sm mb-2"><i
                                                            class="simple-icon-trash"></i></button>
                                                </form>
                                            </td> --}}
                                        </tr>
                                    </tbody>
                                @endforeach
                            </table>
                        </div>
                        @include('layout.includes.pagination', ['items' => $users])

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
