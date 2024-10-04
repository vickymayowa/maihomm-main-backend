@extends('dashboards.admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-12">
                <div class="d-flex justify-content-between">
                    <h5 class="default-color">Users</h5>
                    <div class="d-block d-md-inline-block">
                        <div class="btn-group float-md-left mr-1 mb-1">
                            <div class=" d-inline-block float-md-left mr-1 mb-1 align-top">
                                <form class="input-group" action="{{ url()->current() }}" method="GET">
                                    <input class="form-control" type="text" name="search"
                                        value="{{ request()->query('search') }}" placeholder="Search...">
                                    <button class="btn btn-outline-primary btn-sm ml-3">Search</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <a class="btn pt-0 pl-0 d-inline-block d-md-none" data-toggle="collapse" href="#displayOptions" role="button"
                    aria-expanded="true" aria-controls="displayOptions">Display Options <i
                        class="simple-icon-arrow-down align-middle"></i></a>
                <div class="collapse d-md-block" id="displayOptions"> --}}
            </div>
            <div class="separator mb-5"></div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{route("dashboard.admin.users.create")}}" class="btn default-btn btn-sm float-right">Add new</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sn</th>
                                        <th>Full name</th>
                                        <th>Email Address</th>
                                        <th>Phone</th>
                                        <th>Role</th>
                                        <th>Date Joined</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                @php
                                    $sn = $users->firstItem();
                                @endphp
                                @if ($users->isNotEmpty())
                                    @foreach ($users as $user)
                                        <tbody>
                                            <tr>
                                                <td>{{ $sn++ }}</td>
                                                <td>{{ $user->names() }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone ?? 'N/A' }}</td>
                                                <td>{{ $user->role }}</td>
                                                <td>{{ $user->created_at }}</td>
                                                <td>
                                                    <form action="{{ route('dashboard.admin.users.destroy', $user->id) }}" onsubmit="return confirm('Do you really want to delete this user?');"
                                                        method="POST">
                                                        @csrf @method('Delete')
                                                        <a class="btn btn-warning btn-sm mb-2"
                                                            href="{{ Route('dashboard.admin.users.show', $user->id) }}">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('dashboard.admin.users.imitate', $user->id) }}"
                                                            class="btn btn-dark btn-sm mb-2"
                                                            onclick="return confirm('Are you sure you want to login as this user?')"
                                                            data-toggle="tooltip" data-placement="top" title="Imitate"><i>
                                                                <i class="fa fa-arrow-right"></i>
                                                        </a>
                                                        <a class="btn btn-success btn-sm mb-2"
                                                            href="{{ route('dashboard.admin.users.edit', $user->id) }}">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                        <button class="btn btn-danger btn-sm mb-2"><i
                                                                class="fa fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        </tbody>
                                    @endforeach
                                @else
                                    <div class="alert alert-danger">
                                        No record found!
                                    </div>
                                @endif
                            </table>
                        </div>
                        @include('layout.includes.pagination', ['items' => $users])


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
