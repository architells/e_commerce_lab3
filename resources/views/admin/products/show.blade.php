@extends('Admin.layouts.header')

<style>
    .product-container {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        padding: 10px 0;
    }

    .product-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
        text-align: left;
        margin-right: 20px;
        flex: 0 0 auto;
        width: 300px;
        background-color: #fff;
        position: relative;
        overflow: hidden;
        /* Ensure the ribbon doesn't overflow */
    }

    .product-card:hover {
        transform: translateY(-10px);
    }

    .product-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-bottom: 1px solid #e0e0e0;
    }

    .product-card .card-body {
        padding: 1rem;
    }

    .product-card .card-title {
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }

    .product-card .price-range {
        font-size: 1rem;
        color: #555;
        margin-bottom: 0.5rem;
    }

    .product-card .original-price {
        text-decoration: line-through;
        color: #ccc;
        margin-right: 10px;
    }

    .product-card .discounted-price {
        color: #e60000;
        font-weight: bold;
    }

    .product-card .discount-percentage {
        color: #e60000;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .product-card .card-text {
        font-size: 0.9rem;
        color: #555;
        margin-bottom: 1rem;
    }

    .product-card .quick-shop-btn {
        background-color: #000;
        color: #fff;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .product-card .quick-shop-btn:hover {
        background-color: #555;
    }

    .filter-sort-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .filter-sort-container select,
    .filter-sort-container .filter-icon {
        margin-right: 1rem;
    }

    .see-more {
        color: #007bff;
        cursor: pointer;
        text-decoration: underline;
    }

    .discount-timer {
        position: absolute;
        top: 40px;
        left: 10px;
        background-color: rgba(0, 0, 0, 0.7);
        color: #fff;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 0.9rem;
    }

    .countdown {
        font-size: 1rem;
        color: white;
        font-weight: bold;
    }

    .discount-banner {
        position: absolute;
        top: 0;
        right: 0;
        width: 50px;
        /* Adjust the width as needed */
        height: 100%;
        /* Extend from top to bottom */
        background-color: #e60000;
        color: #fff;
        padding: 5px;
        text-align: center;
        font-size: 0.8rem;
        font-weight: bold;
        writing-mode: vertical-rl;
        transform: rotate(180deg);
        /* Rotate the text */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 10;
        /* Ensure the ribbon is above other elements */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .discount-banner::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 0;
        width: 0;
        height: 0;
        border-left: 15px solid transparent;
        border-right: 15px solid transparent;
        border-top: 15px solid #e60000;
    }
</style>

@section('content')
<div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Products List</h1>
                </div>
                <!-- <div class="col-sm-6">
                    <div class="filter-sort-container">
                        <select class="form-control" id="sort">
                            <option value="best-selling">Best Selling</option>
                            <option value="newest">Newest</option>
                            <option value="price-low-high">Price: Low to High</option>
                            <option value="price-high-low">Price: High to Low</option>
                        </select>
                        <span class="filter-icon">Filter</span>
                    </div>
                </div> -->
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="product-container">
                @foreach($products as $product)
                <div class="product-card">
                    @if($product->discounts()->exists())
                    @php
                    $discount = $product->discounts()->first();
                    $startDate = \Carbon\Carbon::parse($discount->start_date);
                    $endDate = \Carbon\Carbon::parse($discount->end_date);
                    @endphp
                    <div class="discount-banner">
                        {{ $discount->event_name }}
                    </div>
                    <div class="discount-timer" id="countdown-{{ $product->product_id }}">
                        <span class="countdown" data-start-date="{{ $startDate->toDateTimeString() }}" data-end-date="{{ $endDate->toDateTimeString() }}"></span>
                    </div>
                    @endif
                    <img src="{{ $product->image_url }}" alt="{{ $product->product_name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->product_name }}</h5>
                        <p class="price-range">
                            @if($product->discounts()->exists())
                            @php
                            $discount = $product->discounts()->first();
                            $discountedPrice = $product->price * (1 - $discount->discount_amount / 100);
                            @endphp
                            <span class="original-price">₱{{ $product->price }}</span>
                            <span class="discounted-price">₱{{ $discountedPrice }}</span>
                            <span class="discount-percentage">({{ $discount->discount_amount }}% off)</span>
                            @else
                            ₱{{ $product->price }}
                            @endif
                        </p>
                        <p class="card-text">
                            @if(strlen($product->description) > 100)
                            {{ substr($product->description, 0, 100) }}...
                            <span class="see-more" onclick="toggleDescription(this, '{{ $product->description }}')">See More</span>
                            @else
                            {{ $product->description }}
                            @endif
                        </p>
                        <button class="quick-shop-btn">Description</button>
                        <!-- <div class="mt-2">
                        <a href="{{ route('admin.products.edit', $product->product_id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product->product_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                        </form>
                    </div> -->
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection

<script>
    function toggleDescription(element, fullDescription) {
        if (element.innerText === 'See More') {
            element.innerText = 'See Less';
            element.previousSibling.nodeValue = fullDescription;
        } else {
            element.innerText = 'See More';
            element.previousSibling.nodeValue = fullDescription.substring(0, 100) + '...';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const countdownElements = document.querySelectorAll('.countdown');

        countdownElements.forEach(function(countdownElement) {
            const startDate = new Date(countdownElement.getAttribute('data-start-date'));
            const endDate = new Date(countdownElement.getAttribute('data-end-date'));
            console.log("Start Date:", startDate); // Debugging statement
            console.log("End Date:", endDate); // Debugging statement

            function updateCountdown() {
                const now = new Date();
                let distance = endDate - now;

                // If the current date is before the start date, calculate the distance to the start date
                if (now < startDate) {
                    distance = startDate - now;
                }

                console.log("Distance:", distance); // Debugging statement

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                countdownElement.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;

                if (distance < 0) {
                    clearInterval(x);
                    countdownElement.innerHTML = 'EXPIRED';
                }
            }

            const x = setInterval(updateCountdown, 1000);
            updateCountdown(); // Initial call to display the countdown immediately
        });
    });
</script>