@extends("layouts.default")
@section("title", "Ecom-Home")

@section("content")
<main class="container py-5">
    <section class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="row g-0">
                    <!-- Product Image -->
                    <div class="col-md-6">
                        <img src="{{ $product->image }}" class="img-fluid h-100 w-100 object-fit-cover" alt="{{ $product->title }}">
                    </div>

                    <!-- Product Info -->
                    <div class="col-md-6 p-4 d-flex flex-column justify-content-between">
                        <div>
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

                            <h2 class="mb-3">{{ $product->title }}</h2>
                            <h4 class="text-success mb-3">$ {{ number_format($product->price, 2) }}</h4>
                            <p class="text-muted">{{ $product->description }}</p>
                        </div>

                        <a href="{{ route('cart.add', $product->id) }}" class="btn btn-success mt-3 w-100 fw-bold">
                            🛒 Add to Cart
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
