@extends('layouts.app')

@push('styles')
<style>
.business-logo {
    width: 60px !important;
}

i{
    font-size: 2.2rem;
    color:#f2b7a8;
}

.gradient-bg{
    background: linear-gradient(-145deg, rgba(219, 138, 222, 1) 0%, rgba(246, 191, 159, 1) 100%);
}
</style>
@endpush

@section('content')
<section class="dashboard">
    <div class="container px-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="row">
                    <div class="col-1">
                        <span class="badge rounded-pill gradient-bg">
                            1
                        </span>
                    </div>
                    <div class="col-11">
                        <div class="fw-bold fs-5">
                            Customer asks
                            Can i get an Invoice
                        </div>
                    </div>
                </div>

                <div class="row d-flex justify-content-center my-3 text-center">
                    <i class="bi bi-arrow-down"></i>
                </div>

                <div class="row">
                    <div class="col-1">
                        <span class="badge rounded-pill gradient-bg">
                            2
                        </span>
                    </div>

                    <div class="col-11">
                        @foreach(auth()->user()->businesses as $business)
                        <a href="{{ route('business.show', $business->id) }}" class="text-decoration-none">
                            <div class="card mb-2 border-0 rounded shadow-sm">
                                <div class="card-body p-0">
                                    <div class="row d-flex align-items-center justify-content-between p-0">
                                        <div class="col-3">
                                            <img class="img-fluid rounded-circle business-logo"
                                                src="{{ $business->logo }}"
                                                alt="">
                                        </div>
                                        <div class="col-9 text-dark">
                                            {{ $business->name }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

                <div class="row d-flex justify-content-center my-3 text-center">
                    <i class="bi bi-arrow-down"></i>
                </div>

                <div class="row">
                    <div class="col-1">
                        <span class="badge rounded-pill gradient-bg">
                            3
                        </span>
                    </div>
                    <div class="col-11">
                        <div class=" fw-bold fs-5">
                            Customer asks
                            Can i get an Invoice
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0">

                    <div class="card-body">
                       <div class="fw-bold fs-5">Add Business</div>
                       
                       <p class="my-3">Your customers will be able to search, edit and download their invoices from here</p>

                        <p class="my-3">
                            <ol class="list-group list-group-numbered">
                                <li class="mb-2">Create your Stripe restricted API Key</li>
                                <li class="mb-2">Customers can edit their invoices</li>
                                <li class="mb-2">Copy your API Key and paste it here</li>
                            </ol>

                            <div class="form-container my-5">
                                <form action="{{ route('get.details') }}" method="POST" id="invoiceForm">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" name="api_key" class="form-control" placeholder="" required>
                                    </div>

                                    <span class="invalid-feedback fw-bold" role="alert"></span>
                                        
                                    <div class="form-group my-3 main-button-gradient">
                                        <button href="#" type="submit" class="">Add Business</button>
                                    </div>

                                    <div class="align-items-center loader my-3 text-secondary" style="display: none;">
                                        <strong class="">Loading...</strong>
                                        <div class="spinner-border ms-auto float-end" role="status" aria-hidden="true"></div>
                                    </div>
                                </form>
                            </div>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
// when the documents is ready
$(document).ready(function() {  
    $('#invoiceForm').on('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Get the form data
        var formData = $(this).serialize();
        $('.invalid-feedback').hide();
        $('.loader').show();
        $('.main-button-gradient').prop('disabled', true);
        $('.main-button-gradient').hide();

        // Send the AJAX request
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            success: function(response) {
                // Handle the successful response here
                // alert('Form submitted successfully!');
                $('.loader').hide();
                $('.main-button-gradient').prop('disabled', false);
                $('.main-button-gradient').show();
            },
            error: function(xhr, status, error) {
                let errorMessage = xhr.responseJSON.message ? xhr.responseJSON.message : xhr.responseJSON.error;
                console.error('An error occurred:', xhr);
                $('.invalid-feedback').show();
                $('.invalid-feedback').text(errorMessage);
                $('.loader').hide();
                $('.main-button-gradient').prop('disabled', false);
                $('.main-button-gradient').show();
            }
        });
    });
});
</script>
@endpush