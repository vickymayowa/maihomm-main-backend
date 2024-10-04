@extends('dashboards.user.layouts.app')

@section('style')
    <style>
        .p-vals {
            margin-left: -3px;
        }
    </style>
@endsection
@section('content')
    <main id="content" class="bg-gray-01">
        <section class="py-5 bg-gray-01">
            <div class="container">
                @include('layout.notifications.flash_messages')
                <div class="row login-register justify-content-center">
                    <div class="col-lg-12">
                        <div class="card border-0 shadow-xxs-2 mb-4">
                            <div class="card-body px-6 py-2">
                                <h2 class="card-title fs-22 font-weight-600 text-dark lh-16 mb-2">Slots</h2>
                                <div class="form-group mb-4">
                                    <div class="form-group">
                                        <select class="form-control border-0 shadow-none form-control-lg selectpicker"
                                            title="Select" data-style="btn-lg h-52" id="slot_selector_input"
                                            name="user-role">
                                            <option disabled selected>Select slots</option>
                                            @for ($i = 1; $i <= $available_slots; $i++)
                                                <option value="{{ $i }}">{{ $i }}
                                                    Slot{{ $i == 1 ? '' : 's' }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card border-0 shadow-xxs-2 mb-4">
                            <div class="card-body px-6 py-2">
                                <h2 class="card-title fs-22 font-weight-600 text-dark lh-16 mb-2">Financial Details</h2>
                                <div>
                                    <div class="d-flex align-items-center">
                                        <div class="mr-auto">
                                            <p>Property Cost:</p>
                                        </div>

                                        <div class="font-weight-bold">
                                            <span class="font-weight-bold fs-17">{{ $property->currency->short_name }}
                                                <span id="property_cost" data-per_slot="{{ $property->price }}"
                                                    class="p-vals">{{ $property->price }}</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="mr-auto">
                                            <p>Maihomm fee:</p>
                                        </div>

                                        <div class="font-weight-bold">
                                            <span class="font-weight-bold fs-17">{{ $property->currency->short_name }}
                                                <span id="maihomm_fee" data-per_slot="{{ $property->maihomm_fee }}"
                                                    class="p-vals">{{ $property->maihomm_fee }}</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="mr-auto">
                                            <p>Legal and closing cost:</p>
                                        </div>

                                        <div class="font-weight-bold">
                                            <span class="font-weight-bold fs-17">{{ $property->currency->short_name }}
                                                <span id="legal_and_closing_cost"
                                                    data-per_slot="{{ $property->legal_and_closing_cost }}"
                                                    class="p-vals">{{ $property->legal_and_closing_cost }}</span>
                                            </span>
                                        </div>
                                    </div>
                                    <hr style="margin-top: -3px;">

                                    <div class="d-flex align-items-center">
                                        <div class="mr-auto">
                                            <p>Property Acq cost:</p>
                                        </div>

                                        <div class="font-weight-bold">
                                            <span class="font-weight-bold fs-17">{{ $property->currency->short_name }}
                                                <span id="property_acq_cost" data-per_slot="0" class="p-vals">0</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="card border-0 shadow-xxs-2 mb-6">
                                <div class="card-body px-6 py-3">
                                    <div class="form-group mb-4">
                                        <div class="mb-3 ">
                                            <h2 class="mb-0 text-heading font-weight-bold fs-25 mb-2 lh-15">Payment
                                                Information
                                            </h2>
                                            <hr>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#paymentDetails">
                                                Click for Bank Details
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="paymentDetails" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Please pay using
                                                                any of the following</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="lead_"><b>Account Name:</b> Maihomm Management
                                                                Limited</div>
                                                            <div class="lead_"><b>Bank Name:</b> Zenith Bank</div>
                                                            <div class="lead_"><b>Naira Account Number:</b>
                                                                <a href="javascript:;;" class="text-primary copy ml-2"
                                                                    data-content="1226902217">
                                                                    1226902217
                                                                    <i class="fa fa-copy"></i>
                                                                </a>
                                                            </div>
                                                            <div class="lead_"><b>GBP Account Number:</b>
                                                                <a href="javascript:;;" class="text-primary copy ml-2"
                                                                    data-content="5061261467">
                                                                    5061261467
                                                                    <i class="fa fa-copy"></i>
                                                                </a>
                                                            </div>
                                                            <div class="lead_"><b>USD Account Number:</b>
                                                                <a href="javascript:;;" class="text-primary copy ml-2"
                                                                    data-content="5073868630">
                                                                    5073868630
                                                                    <i class="fa fa-copy"></i>
                                                                </a>
                                                            </div>
                                                            <div class="lead_ mt-2 mb-2">Or</div>
                                                            <div class="lead_"><b>Bank Name:</b> Wise</div>
                                                            <div class="lead_"><b>GBP Account Number:</b> <a
                                                                    href="javascript:;;" class="text-primary copy ml-2"
                                                                    data-content="78740715">
                                                                    78740715
                                                                    <i class="fa fa-copy"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <ul>
                                                <li>Confirm that all the details are correct, and submit the payment. </li>
                                                <li>Take a screenshot of the payment confirmation page or save the transfer
                                                    receipt as evidence
                                                    of payment. </li>
                                                <li>Return to the platform and upload the screenshot or transfer receipt as
                                                    evidence of payment. </li>
                                            </ul>
                                            <hr>
                                            <p> <span class="text-primary font-weight-bold">Note:</span> Please ensure that
                                                the payment amount
                                                is accurate and that the recipient's account details are entered correctly.
                                                <br> Maihomm
                                                Management Limited will not be held responsible for any errors or delays
                                                caused by incorrect
                                                information. <br> If you have any questions or concerns, please contact our
                                                support team.
                                            </p>
                                        </div>

                                        <!-- Button trigger modal -->
                                        <div class="d-flex ">
                                            <button type="button" class="btn btn-secondary" id="proceed_btn" disabled
                                                data-toggle="modal" data-target="#paymentModal">
                                                I have made this payment
                                            </button>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('dashboards.user.properties.payment.modal.upload_proof')
    </main>
@endsection

@section('script')
    <script>
        const total_slots = parseInt('{{ $property->total_slots }}')
        calculateVals(1);
        $("#slot_selector_input").on("change", function() {
            const slots = parseInt($(this).val());
            calculateVals(slots);
            $("#proceed_btn").removeAttr("disabled");
        });

        function calculateVals(slots) {
            const per_property_cost = parseFloat($("#property_cost").attr("data-per_slot"));
            const total_property_cost = slotAmount(per_property_cost, slots);
            $("#property_cost").html(total_property_cost.toFixed(2));

            const maihomm_fee = parseFloat($("#maihomm_fee").attr("data-per_slot"));
            const total_maihomm_fee = maihomm_fee * slots;
            $("#maihomm_fee").html(total_maihomm_fee.toFixed(2));

            const legal_and_closing_cost = parseFloat($("#legal_and_closing_cost").attr("data-per_slot"));
            const total_legal_and_closing_cost = legal_and_closing_cost * slots;
            $("#legal_and_closing_cost").html(total_legal_and_closing_cost.toFixed(2));

            const total_cost = total_legal_and_closing_cost + total_maihomm_fee + total_property_cost;
            $("#property_acq_cost").html(total_cost.toFixed(2));
            $("#slot_input").val(slots);
        }

        function slotAmount(amount, slots) {
            return (amount / total_slots) * slots;
        }

        $("#slot_selector_input").val(1);
        $("#slot_selector_input").trigger("change");
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
