@extends('dashboards.admin.layouts.app')
@section('content')

<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <h5 class="default-color">Payments</h5>
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
        </div>
        <div class="separator mb-5"></div>
    </div>
    <div class="row mb-4">
        <div class="col-12 mb-4">
                 <div class="card">
                <div class="card-body table-responsive">
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
                        @foreach($payments as $payment)
                        <tbody>
                            <tr>
                                <td>{{ $payment->user->full_name }}</td>
                                <td>{{ $payment->reference }}</td>
                                <td>{{ $payment->getAmount("amount") }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary mb-1"
                                        data-toggle="modal" data-target="#paymentProofModal_{{$payment->id}}">
                                        View Proof
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-{{pillClasses($payment->status)}} mb-1"
                                        data-toggle="modal" data-target="#paymentStatusModal_{{$payment->id}}">
                                        {{ $payment->status }}
                                    </button>
                                </td>
                                <td>{{ $payment->created_at }}</td>
                            </tr>
                        </tbody>
                        @include("dashboards.admin.payments.modals.status" , ["payment" => $payment , "statusOptions" => $statusOptions])
                        @include("dashboards.admin.payments.modals.payment_proof" , ["payment" => $payment , "statusOptions" => $statusOptions])
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section("script")
<script>
$(".status_select_input").on("change", function () {
    const value = $(this).val();
    const target = $($(this).attr("data-target"));
    if(value == "Declined"){
        target.removeClass("d-none");
        target.find("textarea").attr("required" , true);
        target.find("textarea").val("");
    }
    else{
       target.addClass("d-none");
        target.find("textarea").removeAttr("required");
        target.find("textarea").val("");
    }
})
</script>
@endsection
