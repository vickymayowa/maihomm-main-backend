@extends('auth.layouts.app', [
    'page_title' => 'KYC page',
])

@section('content')
    <main id="content">
        <section class="py-5">
            <div class="container">
                @include('layout.notifications.flash_messages')
                <div class="row login-register justify-content-center">
                    <div class="col-lg-5">
                        <div class="card border-0 shadow-xxs-2 mb-6">
                            <div class="card-body px-8 py-6">
                                <h2 class="card-title fs-30 font-weight-600 text-dark lh-16 mb-2">KYC Verification</h2>
                                @if (!$show_document_form && !$show_nin_form)
                                    <p class="mb-4">Your KYC is under verification. Please check back later.</p>
                                @else
                                    {{-- <p class="mb-4">Provide your valid ID to complete you registration.</p> --}}
                                    <form id="kycForm"action="{{ route('dashboard.user.upload-kyc') }}" method="POST" class="form pb-3" enctype="multipart/form-data">@csrf

                                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                        <input type="hidden" name="redirect_url" value="{{ $redirect_url ?? null }}">

                                        @if ($show_document_form)
                                            <div class="form-group mb-4 mb-2">
                                                <label for="">Document Type</label>
                                                <select class="form-control form-control-lg border-0" name="id_type" required>
                                                    @foreach ($id_options as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group mb-4 mb-2">
                                                <label for="">Valid ID</label>
                                                <input type="file" class="form-control form-control-lg border-0" name="id_card" required>
                                            </div>
                                        @elseif ($show_nin_form)
                                            <input type="hidden" name="id_type" value="NIN">
                                            <div class="form-group mb-4 mb-2">
                                                <label for="">Enter NIN</label>
                                                <input type="text" class="form-control form-control-lg border-0" name="nin" required>
                                            </div>
                                        @endif

                                        <button type="submit" class="btn btn-outline-primary btn-lg btn-block rounded">Validate</button>
                                    </form>
                                @endif
                                <a href="{{ route('dashboard.user.portfolio.index') }}" class="btn btn-primary btn-lg btn-block rounded">I will do this later</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
