@extends("layouts.default")
@section("title", "Ecom-Home")

@section("content")
    <main class="container py-5">
        <section>
            <div class="row g-4">
                @foreach ($products as $product)
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card h-100 shadow-sm border-0 rounded-4">
                            <img src="{{ $product->image }}" class="card-img-top rounded-top-4" alt="{{ $product->title }}">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <h5 class="card-title mb-2" style="font-size: 1rem;">
                                    <a href="{{ route('products.details', $product->slug) }}" class="text-decoration-none text-dark ">
                                        {{ Str::limit($product->title, 50) }}
                                    </a>
                                </h5>
                                <p class="text-success fw-semibold mb-0">$ {{ number_format($product->price, 2) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        </section>
    </main>
@endsection
