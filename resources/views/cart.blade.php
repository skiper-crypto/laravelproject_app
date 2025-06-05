@extends("layouts.default")
@section("title", "Ecom-Home")

@section("content")
<main class="container py-5">
    <section>
        <div class="row justify-content-center mb-4">
            <div class="col-12 col-md-10">
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

                @forelse ($cartItems as $cart)
                    <div class="card mb-3 shadow-sm border-0 rounded-4">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-4">
                                <img src="{{ $cart->image }}" class="img-fluid rounded-start" alt="{{ $cart->title }}">
                            </div>
                            <div class="col-md-8 p-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="mb-1">
                                            <a href="{{ route('products.details', $cart->slug) }}" class="text-decoration-none text-dark">
                                                {{ $cart->title }}
                                            </a>
                                        </h5>
                                        <p class="mb-1">Price: <strong>$ {{ number_format($cart->price, 2) }}</strong></p>
                                        <p class="mb-2">Quantity: {{ $cart->quantity }}</p>
                                    </div>
                                    <div>
                                        <a href="{{ route('cart.delete', $cart->cart_id) }}" class="btn btn-outline-danger btn-sm">
                                            🗑 Delete
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info text-center">
                        Your cart is currently empty.
                    </div>
                @endforelse

                <div class="mt-4 d-flex justify-content-between align-items-center">
                    <div>
                        {{ $cartItems->links() }}
                    </div>
                    @if ($cartItems->count())
                        <a class="btn btn-success btn-lg px-4" href="{{ route('checkout.show') }}">
                            Proceed to Checkout
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
