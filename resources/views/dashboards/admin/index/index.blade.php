@extends('dashboards.admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 style="color: #dea739">Dashboard</h1>
                <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                    <ol class="breadcrumb pt-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Library</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data</li>
                    </ol>
                </nav>
                <div class="separator mb-5"></div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="position-absolute card-top-buttons">
                        <a href="{{ route('dashboard.admin.users.index') }}" class="btn btn-header-light icon-button"
                            title="View All"><i class="simple-icon-refresh"></i></a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">New Users</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Names</th>
                                        <th>Email Address</th>
                                        <th>Date/Time</th>
                                    </tr>
                                </thead>
                                @foreach ($users as $user)
                                    <tbody>
                                        <tr>
                                            <td>{{ $user->names() }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->created_at }}</td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="position-absolute card-top-buttons">
                        <a href="{{ route('dashboard.admin.finance.transactions.index') }}"
                            class="btn btn-header-light icon-button" title="View All"><i
                                class="simple-icon-refresh"></i></a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Recent Payments</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>

                                    <tr>
                                        <th>User</th>
                                        <th>Reference</th>
                                        <th>Amount</th>
                                        <th>Proof</th>
                                        <th>Status</th>
                                        <th>Date</th>

                                    </tr>
                                </thead>
                                @foreach ($payments as $payment)
                                    <tbody>
                                        <tr>
                                            <td>{{ $payment?->user?->full_name }}</td>
                                            <td>{{ $payment->reference }}</td>
                                            <td>{{ $payment->getAmount('amount') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary mb-1" data-toggle="modal"
                                                    data-target="#paymentProofModal_{{ $payment->id }}">
                                                    View Proof
                                                </button>
                                            </td>
                                            <td>
                                                {{ $payment->status }}
                                            </td>
                                            <td>{{ $payment->created_at }}</td>
                                        </tr>
                                    </tbody>
                                    @include('dashboards.admin.payments.modals.payment_proof', [
                                        'payment' => $payment,
                                    ])
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>
@endsection
