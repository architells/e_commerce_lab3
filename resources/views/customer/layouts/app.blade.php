<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cozy Ran | Official Page</title>

    <link rel="icon" href="{{ asset('assests/photos/BrandLogo.ico') }}" type="Brand Logo">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
    <link href="{{ asset('../dist/css/adminlte.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .navbar {
            min-height: 60px;
            /* Set a fixed height for the navbar */
        }

        .dropdown-menu {
            margin-top: 0;
            /* Remove the default margin */
            padding-top: 0;
            /* Remove the default padding */
        }

        .dropdown-menu .dropdown-item {
            padding: 0.5rem 1.5rem;
            /* Adjust padding for dropdown items */
        }

        .modal-right .modal-dialog {
            position: fixed;
            margin: auto;
            width: 400px;
            max-width: 100%;
            top: 0;
            right: 0;
            transform: translate(0, 0);
            height: 100vh;
            /* Use viewport height to ensure full height */
            border-radius: 0;
            display: flex;
            flex-direction: column;
        }

        .modal-right .modal-content {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .modal-right .modal-header,
        .modal-right .modal-footer {
            flex: 0 1 auto;
            /* Prevent header and footer from growing */
        }

        .modal-right .modal-body {
            flex: 1 1 auto;
            /* Allow body to grow and take available space */
            overflow-y: auto;
            padding: 20px;
        }

        .modal-right .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .modal-right .modal-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }

        .modal-right .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .modal-right .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .modal-right .btn-link {
            color: #007bff;
        }

        .modal-right .btn-link:hover {
            text-decoration: underline;
        }

        /* Product Card */

        .product-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            /* Adjust the gap between cards */
        }

        .product-card {
            width: 200px;
            /* Reduced width */
            transition: transform 0.2s;
            flex: 1 1 calc(25% - 20px);
            /* Adjust the flex basis to fit more cards per row */
            box-sizing: border-box;
            /* Ensure padding and border are included in the width */
        }

        .product-card:hover {
            transform: translateY(-10px);
        }

        .product-card img {
            height: 200px;
            /* Adjusted height */
            object-fit: cover;
        }

        .ribbon {
            position: absolute;
            top: -5px;
            right: -5px;
            z-index: 1;
            overflow: hidden;
            width: 75px;
            /* Reduced width */
            height: 75px;
            /* Reduced height */
            text-align: right;
        }

        .ribbon span {
            font-size: 10px;
            font-weight: bold;
            color: #fff;
            text-transform: uppercase;
            text-align: center;
            width: 110px;
            /* Reduced width */
            display: block;
            background: #e60000;
            transform: rotate(-45deg);
            position: absolute;
            top: 10px;
            /* Adjusted top */
            right: -20px;
            /* Adjusted right */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .discount-timer {
            top: 10px;
            left: 10px;
        }

        .countdown {
            font-size: 1rem;
            font-weight: bold;
        }

        .original-price {
            margin-right: 10px;
        }

        .discounted-price {
            font-weight: bold;
        }

        .discount-percentage {
            font-weight: bold;
        }

        .card-link {
            display: block;
            text-decoration: none;
            color: inherit;
        }

        .quick-shop-btn {
            position: relative;
            width: 100%;
            /* Adjusted width */
        }

        .card-body {
            padding: 0.5rem;
        }

        .card-title {
            font-size: 1rem;
        }

        .price-range {
            font-size: 0.9rem;
            color: #555;
        }

        .quick-shop-btn {
            margin-top: 0.5rem;
        }

        .product-info {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        .product-info h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .brand-name,
        .category-name {
            font-size: 1rem;
            color: #555;
            margin-bottom: 10px;
        }

        .price-range {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .original-price {
            text-decoration: line-through;
            color: #ccc;
            margin-right: 10px;
        }

        .discounted-price {
            color: #e60000;
            font-weight: bold;
        }

        .discount-percentage {
            color: #e60000;
            font-weight: bold;
        }

        .rating {
            margin-bottom: 20px;
        }

        .rating-value {
            font-size: 1.2rem;
            color: #ff9500;
            margin-right: 10px;
        }

        .rating-count {
            font-size: 1rem;
            color: #555;
        }

        .discount-info {
            background-color: #fff3cd;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .discount-label {
            font-weight: bold;
            color: #e60000;
        }

        .discount-code {
            color: #e60000;
        }

        .material-info,
        .color-info {
            margin-bottom: 20px;
        }

        .material-label,
        .color-label {
            font-weight: bold;
            margin-right: 10px;
        }

        .material-value,
        .color-value {
            background-color: #f0f0f0;
            padding: 5px 10px;
            border-radius: 4px;
            margin-right: 10px;
        }

        .quantity-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .quantity-label {
            margin-right: 10px;
        }

        .quantity-input {
            width: 50px;
            margin-right: 10px;
        }

        .add-to-cart-btn {
            background-color: #ff9500;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .add-to-cart-btn:hover {
            background-color: #e68600;
        }

        .payment-info {
            margin-bottom: 20px;
        }

        .payment-label {
            background-color: #6c757d;
            color: #fff;
            padding: 5px 10px;
            border-radius: 4px;
            margin-right: 10px;
        }

        .payment-info-text {
            color: #6c757d;
        }

        .benefits {
            display: flex;
            justify-content: space-between;
        }

        .benefit-item {
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            flex: 1;
            margin-right: 10px;
        }

        .benefit-item:last-child {
            margin-right: 0;
        }

        .discount-banner {
            top: 10px;
            /* Adjust top positioning as necessary */
            left: 10px;
            /* Adjust left positioning as necessary */
            z-index: 10;
        }

        .ongoing-banner {
            background-color: rgba(0, 128, 0, 0.7);
            /* Green for ongoing */
            color: white;
        }

        .upcoming-banner {
            background-color: rgba(0, 123, 255, 0.7);
            /* Blue for upcoming */
            color: white;
        }

        .expired-banner {
            background-color: rgba(255, 0, 0, 0.7);
            /* Red for expired */
            color: white;
        }


        /* filter */

        .left-modal .modal-dialog {
            position: fixed;
            left: 0;
            top: 0;
            height: 100%;
            width: 300px;
            margin: 0;
            padding: 0;
            overflow-y: auto;
            background-color: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .left-modal .modal-content {
            height: 100%;
            border: none;
            border-radius: 0;
        }

        .left-modal .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .left-modal .modal-body {
            padding: 20px;
        }

        .filter-section {
            margin-bottom: 20px;
        }

        .filter-section h5 {
            margin-bottom: 10px;
        }

        .filter-section label {
            display: block;
            margin-bottom: 5px;
        }
    </style>

</head>

<body>
    @include('customer.layouts.header')

    <div class="content">
        @yield('content')
    </div>

    @include('customer.layouts.auth_modal')

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>

    <script>
        $('#authModal').on('show.bs.modal', function(event) {
            var modal = $(this);
            modal.addClass('modal-right');
        });

        // Ensure the modal takes the full height of the viewport
        $(window).on('resize', function() {
            $('.modal-right .modal-dialog').css('height', $(window).height());
        }).trigger('resize');
    </script>
</body>

</html>