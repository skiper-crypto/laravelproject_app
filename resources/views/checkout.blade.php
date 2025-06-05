@extends('layouts.default')
@section('title', 'Checkout')

@section('content')
<main class="container py-5">
    <section class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card shadow-lg border-0 rounded-4 p-4">
                <h2 class="mb-4 text-center">🧾 Checkout</h2>

                @if (session()->has("success"))
                    <div class="alert alert-success">
                        {{ session()->get("success") }}
                    </div>
                @endif
                @if (session()->has("error"))
                    <div class="alert alert-danger">
                        {{ session()->get("error") }}
                    </div>
                @endif

                <form action="{{ route('checkout.post') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    <div class="mb-3">
                        <label for="address" class="form-label">Shipping Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                        <div class="invalid-feedback">Please enter your address.</div>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required pattern="[0-9]{10}">
                        <div class="invalid-feedback">Enter a valid 10-digit phone number.</div>
                    </div>

                    <div class="mb-3">
                        <label for="pincode" class="form-label">Pincode</label>
                        <input type="text" class="form-control" id="pincode" name="pincode" required pattern="[0-9]{5,6}">
                        <div class="invalid-feedback">Enter a valid pincode.</div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">💳 Proceed to Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

{{-- Optional client-side validation --}}
<script>
    (() => {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>
@endsection
