<div class="modal fade" id="paymentProofModal_{{ $payment->id }}" tabindex="-1" role="dialog"
    aria-labelledby="paymentStatusModal_{{ $payment->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Payment Proof</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                @foreach ($payment->files as $payment_file)
                    <a href="{{ optional($payment_file->file)->url() }}" class="mt-2 mb-4 text-center">
                        <img src="{{ optional($payment_file->file)->url() }}" style="width: 500px; height: 500px;"
                            alt="">
                    </a>
                @endforeach
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Close</button>
            </div>
        </div>
    </div>
</div>
