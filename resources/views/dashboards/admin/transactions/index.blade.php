@extends('dashboards.admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <h1 style="color: #dea739">Transaction Details</h1>

                <!-- <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item"><a href="#">Library</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Data</li>
                            </ol>
                        </nav> -->
                <a class="btn pt-0 pl-0 d-inline-block d-md-none" data-toggle="collapse" href="#displayOptions"
                    role="button" aria-expanded="true" aria-controls="displayOptions">Display Options <i
                        class="simple-icon-arrow-down align-middle"></i></a>
                <div class="collapse d-md-block" id="displayOptions">
                    <div class="d-block d-md-inline-block">
                        <div class="btn-group float-md-left mr-1 mb-1">
                            <div class=" d-inline-block float-md-left mr-1 mb-1 align-top">
                                <form class="input-group" action="{{ url()->current() }}" method="GET">
                                    <select class="form-control" name="filter">
                                        <option value="" disabled selected>Select Filter</option>
                                        @foreach ($filterOptions as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ $key == request()->query('filter') ? 'selected' : '' }}>
                                                {{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <input class="form-control" type="text" name="search"
                                        value="{{ request()->query('search') }}" placeholder="Search...">
                                    <select class="form-control" name="type">
                                        <option value="" disabled selected>Select Type</option>
                                        @foreach ($typeOptions as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ $key == request()->query('type') ? 'selected' : '' }}>{{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <select class="form-control" name="activity">
                                        <option value="" disabled selected>Select Activity</option>
                                        @foreach ($activities as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ $key == request()->query('activity') ? 'selected' : '' }}>
                                                {{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-outline-primary btn-sm ml-3">Filter</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="separator mb-5"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>User</th>
                                    <th>Currency</th>
                                    <th>Amount</th>
                                    <th>Fees</th>
                                    <th>Description</th>
                                    <th>Batch_No</th>
                                    <th>Reference</th>
                                    <th>Type</th>
                                    <th>Date/TIme</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            @php
                                $sn = $transactions->firstItem();
                            @endphp
                            @foreach ($transactions as $transaction)
                                <tbody>
                                    <tr>
                                        <td>{{ $sn++ }}</td>
                                        <td>
                                            <a
                                                href="{{ route('dashboard.admin.users.index', ['username' => $transaction->user->username]) }}">
                                                {{ $transaction->user->username }}
                                            </a>
                                        </td>
                                        <td>{{ $transaction->currency['name'] }}</td>
                                        <td>{{ $transaction->formattedAmount() }}</td>
                                        <td>{{ $transaction->fees }}</td>
                                        <td>{{ $transaction->description }}</td>
                                        <td>{{ $transaction->activity }}</td>
                                        <td>{{ $transaction->batch_no }}</td>
                                        <td>{{ $transaction->reference }}</td>
                                        <td class="text-center">
                                            <span
                                                class="badge badge-pill badge-{{ pillClasses($transaction->type) }} mb-1">
                                                {{ $transaction->type }}
                                            </span>
                                        </td>
                                        <td>{{ $transaction->created_at }}</td>
                                        <td>
                                            <form
                                                action="{{ route('dashboard.admin.finance.transactions.destroy', [$transaction->id]) }}"
                                                method="POST"
                                                onSubmit="return confirm('Are you sure you want to delete this item?')">
                                                @csrf @method('Delete')
                                                <button class="btn btn-danger btn-sm"><i
                                                        class="simple-icon-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                    @include('layout.includes.pagination', ['items' => $transactions])
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(".status_select_input").on("change", function() {
            const value = $(this).val();
            const target = $($(this).attr("data-target"));
            if (value == "Declined") {
                target.removeClass("d-none");
                target.find("textarea").attr("required", true);
                target.find("textarea").val("");
            } else {
                target.addClass("d-none");
                target.find("textarea").removeAttr("required");
                target.find("textarea").val("");
            }
        })
    </script>
@endsection
