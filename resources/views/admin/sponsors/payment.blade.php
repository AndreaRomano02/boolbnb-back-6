@extends('layouts.dashboard')

@section('content')
    <form id="payment-form" action="{{ route('admin.sponsors.update', $request->apartment_id) }}" method="POST">
        @method('PUT')
        @csrf
        <label for="card-name">Card Name</label>
        <div id="card-name"></div>

        <label for="card-number">Card Number</label>
        <div id="card-number"></div>

        <label for="cvv">CVV</label>
        <div id="cvv"></div>

        <label for="expiration-date">Expiration Date</label>
        <div id="expiration-date"></div>

        <input type="hidden" id="nonce" name="payment_method_nonce">
        <input type="hidden" value="{{ $request->apartment_id }}" name="apartment_id">
        <input type="hidden" value="{{ $request->sponsor_id }}" name="sponsor_id">

        <input type="submit" value="Pay" />
    </form>
@endsection

@section('scripts')
    <script src="https://js.braintreegateway.com/web/3.97.2/js/client.min.js"></script>
    <script src="https://js.braintreegateway.com/web/3.97.2/js/hosted-fields.min.js"></script>
    @Vite('resources/js/payment.js')
@endsection
