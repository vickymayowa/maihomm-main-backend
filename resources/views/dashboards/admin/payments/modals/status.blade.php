<div class="modal fade" id="paymentStatusModal_{{$payment->id}}" tabindex="-1" role="dialog" aria-labelledby="paymentStatusModal_{{$payment->id}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route("dashboard.admin.finance.payments.change_status" , $payment->id) }}" method="POST"> @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change Payment Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- <div class="mt-2 mb-4">
                        <p>
                            <b>Amount: </b> <span class="text-danger">{{ int_format($payment->amount) }} {{ $payment->currency->name }}</span>
                        </p>
                        <p>
                            <b>Account Name: </b> <span class="text-success">{{ $payment->account_name }}</span>
                        </p>
                        <p>
                            <b>Account Number: </b> <span class="text-success">{{ $payment->account_number }}</span>
                        </p>
                        <p>
                            <b>Bank Name: </b> <span class="text-success">{{ $payment->bank_name }}</span>
                        </p>
                    </div> --}}
                    <div class="form-group">
                        <label for="">Status</label>
                        <select name="status" id="" class="form-control status_select_input" data-target="#comment_box_{{$payment->id}}" required>
                            <option value="" disabled selected>Select Status</option>
                            @foreach ($statusOptions as $key => $value)
                            <option value="{{$key}}" {{$payment->status == $key ? "selected" : ""}}>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group d-none" id="comment_box_{{$payment->id}}">
                        <label for="">Comment</label>
                        <textarea name="comment" class="form-control" rows="3" placeholder="Enter a comment if you wish to cancel the request"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
