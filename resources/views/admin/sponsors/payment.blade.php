@extends('layouts.dashboard')

@section('content')
    <div class="container">

        <h3 class="text-start my-5">Inserisci i dati nei campi per effettuare il pagamento :</h3>

        <div>
            <h4>Sponsor <strong>{{ $sponsor->plan }}</strong></h4>
            <span>Price: € {{ $sponsor->price }}</span>
            <span>Duration: h{{ $sponsor->duration }}</span>
        </div>

        <form id="payment-form" action="{{ route('admin.sponsors.update', $request->apartment_id) }}" method="POST">
            @method('PUT')
            @csrf

            <div class="row">
                <div class="col-6 mb-2">
                    <label class="label" for="card-name">Card Name* :</label>
                    <div class="input" id="card-name"></div>
                </div>
                <div class="col-6 mb-2">
                    <label class="label" for="card-number">Card Number* :</label>
                    <div class="input" id="card-number"></div>
                </div>
                <div class="col-6 mb-2">
                    <label class="label" for="cvv">CVV* :</label>
                    <div class="input" id="cvv"></div>
                </div>
                <div class="col-6 mb-2">
                    <label class="label" for="expiration-date">Expiration Date* :</label>
                    <div class="input" id="expiration-date"></div>
                </div>
                <div class="col-12">
                    <input type="hidden" id="nonce" name="payment_method_nonce">
                    <input type="hidden" value="{{ $request->apartment_id }}" name="apartment_id">
                    <input type="hidden" value="{{ $request->sponsor_id }}" name="sponsor_id">
                </div>
            </div>

            <input class="btn btn-success mt-4" type="submit" value="Pay" />

        </form>
        <h6 class="text-end mt-1">Powered by BrainTree</h6>
    </div>
@endsection

@section('scripts')
    <script src="https://js.braintreegateway.com/web/3.97.2/js/client.min.js"></script>
    <script src="https://js.braintreegateway.com/web/3.97.2/js/hosted-fields.min.js"></script>
    @Vite('resources/js/payment.js')
@endsection
