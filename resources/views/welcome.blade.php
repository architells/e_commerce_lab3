@extends('customer.layouts.app')


@section('content')
<div class="content">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <button id="openFilterBtn" class="btn btn-primary bg-transparent text-secondary border-0 ml-2">
                        <i class="bi bi-filter"></i> Filter
                    </button>
                    @if(isset($filteredProductCount) && isset($selectedFilters))
                    <button id="cancelFilterBtn" class="btn btn-secondary bg-transparent text-secondary border-0">
                        <i class="bi bi-x-circle"></i> Cancel Filters
                    </button>
                    @endif
                </div>
                @if(isset($filteredProductCount) && isset($selectedFilters))
                <div class="col-sm-12 mt-2">
                    <span>{{ $filteredProductCount }} Products Found |</span>
                    @if($selectedFilters['category'])
                    <span> in Category | {{ $selectedFilters['category']->pluck('category_name')->implode(', ') }}</span>
                    @endif
                    @if($selectedFilters['sub_category'])
                    <span> in Sub Category | {{ $selectedFilters['sub_category']->pluck('sub_category_name')->implode(', ') }}</span>
                    @endif
                    @if($selectedFilters['sub_sub_category'])
                    <span> in Sub Sub Category | {{ $selectedFilters['sub_sub_category']->pluck('sub_sub_category_name')->implode(', ') }}</span>
                    @endif
                    @if($selectedFilters['brand'])
                    <span> in Brand | {{ $selectedFilters['brand']->pluck('brand_name')->implode(', ') }}</span>
                    @endif
                    @if($selectedFilters['price'])
                    <span> with Price up to ${{ $selectedFilters['price'] }}</span>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row product-container">
                @foreach($products as $product)
                <div class="col-md-2 mb-4 ml-4">
                    <div class="card product-card h-100 position-relative">
                        @php
                        $hasDiscount = $product->discounts()->exists();
                        $currentDate = \Carbon\Carbon::now(); // Get the current date and time
                        $discountedPrice = $product->price;
                        $discount = null;

                        if ($hasDiscount) {
                        $discount = $product->discounts()->first();
                        $startDate = \Carbon\Carbon::parse($discount->start_date)->startOfDay(); // Normalize to the start of the day
                        $endDate = \Carbon\Carbon::parse($discount->end_date)->endOfDay(); // Normalize to the end of the day

                        // Apply discount if it's ongoing
                        if ($currentDate->gte($startDate) && $currentDate->lte($endDate)) {
                        $discountedPrice = $product->price * (1 - $discount->discount_amount / 100);
                        }
                        }
                        @endphp

                        <!-- Discount Banners -->
                        @if($hasDiscount)
                        @if($product->discount_status == 'Ongoing')
                        <!-- Ongoing Discount Banner with Timer -->
                        <div class="ribbon ribbon-top-right"><span>{{ $discount->event_name }}</span></div>
                        <div class="discount-timer position-absolute" id="countdown-{{ $product->product_id }}">
                            <span class="countdown badge badge-dark"
                                data-start-date="{{ $startDate->toDateTimeString() }}"
                                data-end-date="{{ $endDate->toDateTimeString() }}">
                            </span>
                        </div>
                        @elseif($product->discount_status == 'Upcoming')
                        <!-- Upcoming Discount Banner -->
                        <div class="discount-banner upcoming-banner">
                            <span>Coming Soon: {{ $discount->event_name }}</span>
                        </div>
                        @elseif($product->discount_status == 'Expired')
                        <!-- Expired Discount Banner -->
                        <div class="discount-banner expired-banner">
                            <span>Discount Expired</span>
                        </div>
                        @endif
                        @endif

                        <!-- Product Image -->
                        <a href="{{ route('description', $product->product_id) }}" class="text-decoration-none card-link">
                            <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->product_name }}">
                        </a>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title flex-grow-1">{{ $product->product_name }}</h5>

                            <!-- Product Price -->
                            <p class="price-range mb-2">
                                @if($hasDiscount && $currentDate->gte($startDate) && $currentDate->lte($endDate))
                                <span class="original-price text-muted"><s>₱{{ number_format($product->price, 2) }}</s></span>
                                <span class="discounted-price text-danger">₱{{ number_format($discountedPrice, 2) }}</span>
                                <span class="discount-percentage text-danger">({{ $discount->discount_amount }}% off)</span>
                                @else
                                ₱{{ number_format($product->price, 2) }}
                                @endif
                            </p>

                            <!-- Quick Shop Button -->
                            <button class="btn btn-dark quick-shop-btn mt-auto w-100"
                                data-toggle="modal"
                                data-target="#quickShopModal"
                                onclick="openModal('{{ $product->product_name }}', '{{ $discountedPrice }}', event)">
                                Quick Shop
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>





    <div id="filterModal" class="modal fade left-modal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="filterForm" action="{{ route('products.filter') }}" method="GET">
                        <div class="filter-section">
                            <h5>Primary Category</h5>
                            @foreach($categories as $category)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="category_id[]" value="{{ $category->category_id }}" id="category{{ $category->category_id }}">
                                <label class="form-check-label" for="category{{ $category->category_id }}">
                                    {{ $category->category_name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                        <div class="filter-section">
                            <h5>Secondary Category</h5>
                            @foreach($subCategories as $subCategory)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sub_category_id[]" value="{{ $subCategory->sub_category_id }}" id="subCategory{{ $subCategory->sub_category_id }}">
                                <label class="form-check-label" for="subCategory{{ $subCategory->sub_category_id }}">
                                    {{ $subCategory->sub_category_name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                        <div class="filter-section">
                            <h5>Tertiary Category</h5>
                            @foreach($subSubCategories as $subSubCategory)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sub_sub_category_id[]" value="{{ $subSubCategory->sub_sub_category_id }}" id="subSubCategory{{ $subSubCategory->sub_sub_category_id }}">
                                <label class="form-check-label" for="subSubCategory{{ $subSubCategory->sub_sub_category_id }}">
                                    {{ $subSubCategory->sub_sub_category_name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                        <div class="filter-section">
                            <h5>Brand</h5>
                            @foreach($brands as $brand)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="brand_id[]" value="{{ $brand->brand_id }}" id="brand{{ $brand->brand_id }}">
                                <label class="form-check-label" for="brand{{ $brand->brand_id }}">
                                    {{ $brand->brand_name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                        <div class="filter-section">
                            <h5>Price</h5>
                            <input type="range" class="form-control-range" id="priceRange" name="price" min="0" max="{{ $maxPrice }}" value="{{ $maxPrice }}">
                            <p id="priceRangeDisplay">Price: ₱0.00 – ₱{{ $maxPrice }}</p>
                        </div>
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="quickShopModal" tabindex="-1" role="dialog" aria-labelledby="quickShopModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalProductName">Product Name</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="modalProductPrice">Price: ₱0</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addToCart()">Add to Cart</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const countdownElements = document.querySelectorAll('.countdown');

        document.addEventListener('DOMContentLoaded', function() {
            const countdownElements = document.querySelectorAll('.countdown');

            countdownElements.forEach(function(countdownElement) {
                const startDate = new Date(countdownElement.getAttribute('data-start-date'));
                const endDate = new Date(countdownElement.getAttribute('data-end-date'));

                function updateCountdown() {
                    const now = new Date();
                    let distance = endDate - now;

                    if (now < startDate) {
                        distance = startDate - now;
                        countdownElement.innerHTML = 'Starts in: ' + formatCountdown(distance);
                        countdownElement.classList.add('discount-upcoming');
                        countdownElement.classList.remove('discount-ongoing');
                    } else if (now >= startDate && now <= endDate) {
                        countdownElement.innerHTML = formatCountdown(distance);
                        countdownElement.classList.add('discount-ongoing');
                        countdownElement.classList.remove('discount-upcoming');
                    }
                }

                function formatCountdown(distance) {
                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    return `${days}d ${hours}h ${minutes}m ${seconds}s`;
                }

                // Initial countdown update and setup interval
                updateCountdown(); // Update immediately
                const x = setInterval(updateCountdown, 1000); // Update every second
            });
        });

        const filterModal = new bootstrap.Modal(document.getElementById('filterModal'));
        const openFilterBtn = document.getElementById('openFilterBtn');
        const cancelFilterBtn = document.getElementById('cancelFilterBtn');

        openFilterBtn.onclick = function() {
            filterModal.show();
            resetPriceRange();
        }

        cancelFilterBtn.onclick = function() {
            window.location.href = "{{ route('products.cancelFilters') }}";
        }
    });

    function openModal(productName, productPrice, event) {
        event.stopPropagation();
        document.getElementById('modalProductName').innerText = productName;
        document.getElementById('modalProductPrice').innerText = 'Price: ₱' + productPrice;
        $('#quickShopModal').modal('show');
    }

    function addToCart() {
        alert('Product added to cart!');
        $('#quickShopModal').modal('hide');
    }

    function applyFilters() {
        // Implement filter logic here
        alert('Filters applied!');
        $('#filterModal').modal('hide');
    }
</script>