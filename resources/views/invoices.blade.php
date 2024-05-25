@extends('layouts.app')

@push('styles')
<style>
.business-logo {
    width: 60px !important;
}

i {
    font-size: 2.2rem;
    color: #f2b7a8;
}

.gradient-bg {
    background: linear-gradient(-145deg, rgba(219, 138, 222, 1) 0%, rgba(246, 191, 159, 1) 100%);
}
</style>
@endpush

@section('content')
<section class="dashboard">
    <div class="container ">
        <div class="row">
            <div class="table-responsive">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Business</th>
                            <th>Amount</th>
                            <th>Number</th>
                            <th>Customer Email</th>
                            <th>Customer Name</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice['account_name'] }}</td>
                            <td>{{ number_format($invoice['amount_paid'] / 100, 2) }}
                                {{ strtoupper($invoice['currency']) }}</td>
                            <td>{{ strtoupper($invoice['currency']) }}</td>
                            <td>{{ $invoice['customer_email'] }}</td>
                            <td>{{ $invoice['customer_name'] }}</td>
                            <td>{{ ucfirst($invoice['status']) }}</td>
                            <td>
                                <a href="{{ route('invoice.show', $invoice['id']) }}" class="btn btn-primary">View</a>
                                <button type="button" class="btn btn-primary open-modal" data-invoice="{{ json_encode($invoice) }}">
                                    Launch demo modal
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            @foreach($invoices as $invoice)
            <div class="col-12">
                <div class="card shadow mb-2">
                    <div class="card-body">
                        <div class="invoice-item d-flex justify-content-between">
                            <div>{{ $invoice['id'] }}</div>
                            <div>{{ $invoice['account_country'] }}</div>
                            <div>{{ $invoice['account_name'] }}</div>
                            <div>{{ number_format($invoice['amount_due'] / 100, 2) }}</div>
                            <div>{{ number_format($invoice['amount_paid'] / 100, 2) }}</div>
                            <div>{{ number_format($invoice['amount_remaining'] / 100, 2) }}</div>
                            <div>{{ strtoupper($invoice['currency']) }}</div>
                            <div>{{ $invoice['customer_email'] }}</div>
                            <div>{{ $invoice['customer_name'] }}</div>
                            <div>{{ ucfirst($invoice['status']) }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="header d-flex justify-content-between">
                                    <div class="fw-bold fs-7">Invoice</div>
                                    <div class=""><img src="assets/images/business-logo.png" alt="" class="business-logo"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-4">
                                <div class="invoice">
                                    <div class="row">
                                        <div class="col-6 fw-bold">Invoice Number</div>
                                        <div class="col-6 fw-bold invoice-number">BD56545454sx84</div>

                                        <div class="col-6">Date if issue</div>
                                        <div class="col-6 invoice-date">21 mai 2021</div>

                                        <div class="col-6">Date due</div>
                                        <div class="col-6 invoice-expire">21 mai 2021</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-4">
                                <div class="invoice-from">
                                    <div class="row">
                                        <div class="col-12 fw-bold invoice-from-name">Eddallal Noureddine</div>
                                        <div class="col-12 invoice-from-address">Addresse</div>
                                        <div class="col-12 invoice-from-postal">Postal</div>
                                        <div class="col-12 invoice-from-city">CIty</div>
                                        <div class="col-12 invoice-from-country">Country</div>
                                        <div class="col-12 invoice-from-email">eddallal.noureddine@gmail.com</div>
                                        <div class="col-12 invoice-from-phone">+212528212031</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="invoice-to">
                                    <div class="row">
                                        <div class="col-12 fw-bold">Bill to</div>
                                        <div class="col-12 invoice-to-name">Eddallal Noureddine</div>
                                        <div class="col-12 invoice-to-address">Country</div>
                                        <div class="col-12 invoice-to-email">eddallal.noureddine@gmail.com</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
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

    // when the button is clicked
    $('.open-modal').click(function() {

        // get the data from the button 
        var invoice = $(this).data('invoice');
        // convert the data to array

        console.log(invoice);   

        // set the data in the modal
        $('.invoice-number').text(invoice.number);
        $('.invoice-date').text(invoice.number);
        $('.invoice-expire').text(invoice.number);

        $('.invoice-from-name').text(invoice.account_name);
        $('.invoice-from-address').text(invoice.number);
        $('.invoice-from-postal').text(invoice.number);
        $('.invoice-from-city').text(invoice.number);
        $('.invoice-from-country').text(invoice.account_country);
        $('.invoice-from-email').text(invoice.email ? invoice.email : '');

        $('.invoice-to-name').text(invoice.customer_name);
        $('.invoice-to-address').text(invoice.customer_address.country);
        $('.invoice-to-email').text(invoice.customer_email);

        // show the modal
        $('#exampleModal').modal('show');

    });

    
});
</script>
@endpush