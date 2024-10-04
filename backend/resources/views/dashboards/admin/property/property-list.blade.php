@extends('dashboards.admin.layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <h5 class="default-color">All Properties</h5>
                <div class="d-block d-md-inline-block">
                    <div class="btn-group float-md-left mr-1 mb-1">
                        <div class=" d-inline-block float-md-left mr-1 mb-1 align-top">
                            <form class="input-group" action="{{ url()->current() }}" method="GET">
                                <input class="form-control" type="text" name="search" value="{{ request()->query('search') }}" placeholder="Search...">
                                <button class="btn btn-outline-primary btn-sm ml-3">Filter</button>
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
                    <a href="{{route("dashboard.admin.properties.create")}}" class="btn default-btn btn-sm float-right">Add new</a>
                    <a href="#" data-target="#upload_properties" data-toggle="modal" class="btn default-btn btn-sm float-right mr-3">Upload</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sn</th>
                                    <th>Property Name</th>
                                    <th>UUID</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Total Views</th>
                                    <th>Total Clicks</th>
                                    <th>Total Sold</th>
                                    <th>Status</th>
                                    <th>Closing Date</th>
                                    <th>Upload Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            @php
                            $sn = $properties->firstItem();
                            @endphp
                            @if ($properties->isNotEmpty())
                            @foreach ($properties as $property)
                            <tbody>
                                <tr>
                                    <td>{{ $sn++ }}</td>
                                    <td>{{ $property->name }}</td>
                                    <td>{{ $property->uuid }}</td>
                                    {{-- <td>{{ $property->category->name }}</td> --}}
                                    <td>{{ format_money($property->price, 2, $property->currency->short_name) }}</td>
                                    <td>{{ $property->total_views}}</td>
                                    <td>{{ $property->total_clicks }}</td>
                                    <td>{{ $property->total_sold }}</td>
                                    <td>{{ $property->status }}</td>
                                    <td>{{ $property->closing_date }}</td>
                                    <td>{{ $property->created_at }}</td>
                                    <td>
                                        <form action="{{ route('dashboard.admin.properties.destroy', $property->id) }}" onsubmit="return confirm('Do you really want to delete this property?');" method="POST">
                                            @csrf @method('DELETE')
                                            <a class="btn btn-warning btn-sm mb-2" href="{{ Route('dashboard.admin.properties.show', $property->id) }}">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a class="btn btn-success btn-sm mb-2" href="{{ route('dashboard.admin.properties.edit', $property->id) }}">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <button class="btn btn-danger btn-sm mb-2"><i class="fa fa-trash"></i></button>
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
                    @include('layout.includes.pagination', ['items' => $properties])

                </div>
            </div>
        </div>
    </div>
</div>
@include('dashboards.admin.property.modals.upload_properties')


@endsection
