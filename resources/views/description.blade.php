@extends('customer.layouts.app')

<title>{{ config('app.name', 'Product Description') }}</title>

@section('content')
<div class="content">
    <section class="content-header">
        <div class="container-fluid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->product_name }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ $product->image_url }}" class="img-fluid" alt="{{ $product->product_name }}">
                </div>
                <div class="col-md-8">
                    <div class="product-info">
                        <h1 class="brand-name">{{ $product->brand->brand_name }}</h1>
                        <h4>{{ $product->product_name }}</h4>
                        <p class="category-name">{{ $product->category->category_name }}</p>
                        <p class="price-range">
                            @if($product->discounts()->exists())
                            @php
                            $discount = $product->discounts()->first();
                            $status = $discount->discount_status;
                            @endphp
                            @if($status === 'Ongoing')
                            @php
                            $discountedPrice = $product->price * (1 - $discount->discount_amount / 100);
                            @endphp
                            <span class="original-price text-muted"><s>₱{{ number_format($product->price, 2) }}</s></span>
                            <span class="discounted-price text-danger">₱{{ number_format($discountedPrice, 2) }}</span>
                            <span class="discount-percentage text-danger">({{ $discount->discount_amount }}% off)</span>
                            @elseif($status === 'Upcoming')
                            <span class="badge badge-info mb-2">Upcoming Discount: {{ $discount->discount_amount }}% off starts on {{ $discount->start_date->format('Y-m-d') }}</span><br>
                            ₱{{ number_format($product->price, 2) }}
                            @elseif($status === 'Expired')
                            <span class="badge badge-danger">Discount Expired</span>
                            ₱{{ number_format($product->price, 2) }}
                            @endif
                            @else
                            ₱{{ number_format($product->price, 2) }}
                            @endif
                        </p>


                        <div class="rating">
                            <span class="rating-value">4.7</span>
                            <span class="rating-count">(805 reviews)</span>
                        </div>
                        <div class="quantity-info">
                            <span class="quantity-label">Quantity:</span>
                            <input type="number" class="quantity-input" value="1" min="1">
                            <button class="btn btn-primary add-to-cart-btn">ADD TO CART</button>
                        </div>
                        <div class="payment-info">
                            <span class="payment-label">Buy with Shop Pay</span>
                            <span class="payment-info-text">More payment options</span>
                        </div>
                        <div class="benefits">
                            <span class="benefit-item">Free Shipping</span>
                            <span class="benefit-item">1 Year Warranty</span>
                            <span class="benefit-item">30 Days Return</span>
                            <span class="benefit-item">Secure Payment</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="product-description">
                <h2>Product Description</h2>
                <p>{{ $product->description }}</p>
            </div>
        </div>
    </section>
</div>
@endsection