@extends('base.base')

@section('content')
    <!-- Required CSS Libraries -->
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <style>
        :root {
            --primary: #ffffff;
            --secondary: #000000;
            --accent: #D4AF37;
            --accent-light: #F8F1D5;
            --accent-dark: #9E7C1F;
            --light-gray: #f9f9f9;
            --medium-gray: #e0e0e0;
            --text-primary: #000000;
            --text-secondary: #505050;
            --text-accent: #D4AF37;
            --success: #4CAF50;
            --transition: cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        /* Dark mode variable overrides */
        body.dark-mode {
            --primary: #121212;
            --secondary: #f5f5f5;
            --light-gray: #1e1e1e;
            --medium-gray: #333333;
            --text-primary: #f5f5f5;
            --text-secondary: #aaaaaa;
        }

        body,
        html {
            background-color: var(--primary);
            color: var(--text-primary);
            font-family: 'Montserrat', sans-serif;
            overflow-x: hidden;
            cursor: default;
            transition: background 0.3s ease, color 0.3s ease;
        }

        /* Pattern Overlay */
        .pattern-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23D4AF37' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
            opacity: 1;
        }

        /* Gold accents */
        .gold-accent {
            position: absolute;
            width: 30%;
            height: 30%;
            background: linear-gradient(45deg, rgba(212, 175, 55, 0.1), rgba(212, 175, 55, 0.02));
            filter: blur(20px);
            border-radius: 50%;
            z-index: 0;
            pointer-events: none;
        }

        .gold-accent-1 {
            top: -10%;
            right: 5%;
            animation: float 20s infinite alternate;
        }

        .gold-accent-2 {
            bottom: 10%;
            left: 5%;
            animation: float 25s infinite alternate-reverse;
        }

        @keyframes float {
            0% {
                transform: translate(0, 0) rotate(0deg);
            }

            50% {
                transform: translate(10px, 15px) rotate(3deg);
            }

            100% {
                transform: translate(-10px, 5px) rotate(-3deg);
            }
        }

        .shipment-wrapper {
            position: relative;
            min-height: 100vh;
            padding: 0;
            z-index: 1;
        }

        .shipment-container {
            max-width: 900px;
            margin: 5rem auto 2rem;
            padding: 3rem;
            background: var(--primary);
            border-radius: 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            font-family: 'Montserrat', sans-serif;
            position: relative;
            z-index: 2;
            border: 1px solid var(--medium-gray);
            transition: all 0.3s ease;
        }

        .dark-mode .shipment-container {
            background: #1c1c1c;
            color: #fff;
            border-color: #333;
        }

        .shipment-container::before {
            content: '';
            position: absolute;
            top: 10px;
            right: 10px;
            bottom: 10px;
            left: 10px;
            border: 1px solid rgba(212, 175, 55, 0.1);
            transition: all 0.4s var(--transition);
            pointer-events: none;
            z-index: 1;
        }

        .shipment-header {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 2rem;
            color: var(--accent);
            text-align: center;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .shipment-progress {
            margin: 3rem 0;
            position: relative;
        }

        .shipment-progress h4 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            font-weight: 500;
            margin-bottom: 2rem;
            color: var(--text-primary);
            text-align: center;
            letter-spacing: 1px;
        }

        .progress-track {
            position: relative;
            height: 8px;
            background-color: var(--medium-gray);
            border-radius: 4px;
            overflow: hidden;
            margin: 2rem 0;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--accent), var(--accent-dark));
            transition: width 0.6s var(--transition);
            position: relative;
        }

        .progress-fill::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            50% { transform: translateX(100%); }
            100% { transform: translateX(100%); }
        }

        .progress-labels {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
            font-size: 0.9rem;
            color: var(--text-secondary);
            padding: 0 10px;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .progress-labels span.fw-bold {
            color: var(--accent);
            font-weight: 600;
        }

        .shipment-details {
            background: var(--light-gray);
            padding: 2rem;
            border-radius: 0;
            margin: 2rem 0;
            border-left: 4px solid var(--accent);
            transition: all 0.3s ease;
        }

        .dark-mode .shipment-details {
            background: #222;
            color: #fff;
        }

        .shipment-details strong {
            color: var(--accent);
            font-weight: 600;
            letter-spacing: 0.5px;
            font-size: 0.95rem;
        }

        .shipment-details br {
            margin-bottom: 0.5rem;
        }

        .product-summary {
            margin-top: 3rem;
            border-top: 2px solid var(--accent);
            padding-top: 2rem;
        }

        .product-summary h4 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--accent);
            text-align: center;
            letter-spacing: 1px;
        }

        .product-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid var(--medium-gray);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .dark-mode .product-item {
            border-bottom-color: #333;
        }

        .product-item:hover {
            background: var(--light-gray);
            padding: 1rem;
            margin: 0 -1rem 1rem;
        }

        .dark-mode .product-item:hover {
            background: #222;
        }

        .product-item:last-child {
            border-bottom: none;
        }

        .total {
            text-align: right;
            font-weight: 600;
            margin: 0.5rem 0;
            font-size: 1.1rem;
            color: var(--text-primary);
            letter-spacing: 0.5px;
        }

        .total:last-child {
            font-size: 1.3rem;
            color: var(--accent);
            font-weight: 700;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 2px solid var(--accent);
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: var(--accent);
            color: var(--secondary);
            border-radius: 0;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-size: 0.85rem;
            margin-left: 1rem;
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .shipment-container {
                margin: 2rem 1rem;
                padding: 2rem 1.5rem;
            }

            .shipment-header {
                font-size: 2rem;
            }

            .progress-labels {
                font-size: 0.8rem;
            }

            .product-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
        }

        @media (max-width: 576px) {
            .shipment-header {
                font-size: 1.5rem;
            }

            .shipment-container {
                padding: 1.5rem 1rem;
            }

            .progress-labels span {
                font-size: 0.7rem;
            }
        }
    </style>

    <div class="shipment-wrapper">
        <div class="pattern-overlay"></div>
        <div class="gold-accent gold-accent-1"></div>
        <div class="gold-accent gold-accent-2"></div>

        <div class="shipment-container fade-in" data-aos="fade-up" data-aos-duration="1000">
            <div class="shipment-header" data-aos="fade-down" data-aos-duration="800">
                Order Tracking
            </div>

            @php
                $shipment = $order->shipment;
                $status = strtolower($shipment->delivery_status);

                // Set progress value based on actual status
                $progress = match ($status) {
                    'ordered' => 25,
                    'processing' => 50,
                    'shipped' => 75,
                    'delivered' => 100,
                    default => 0,
                };
            @endphp

            <div class="shipment-progress" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                <h4>Order #{{ $order->order_id }} 
                    <span class="status-badge">{{ ucfirst($shipment->delivery_status) }}</span>
                </h4>
                
                <div class="progress-track">
                    <div class="progress-fill" style="width: {{ $progress }}%;"></div>
                </div>

                <div class="progress-labels">
                    <span class="{{ $progress >= 25 ? 'fw-bold text-success' : '' }}">Ordered</span>
                    <span class="{{ $progress >= 50 ? 'fw-bold text-success' : '' }}">Processing</span>
                    <span class="{{ $progress >= 75 ? 'fw-bold text-success' : '' }}">Shipped</span>
                    <span class="{{ $progress == 100 ? 'fw-bold text-success' : '' }}">Delivered</span>
                </div>
            </div>

            {{-- Shipment Info --}}
            <div class="shipment-details" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                <strong>Recipient:</strong> {{ $shipment->first_name }} {{ $shipment->last_name }}<br><br>
                <strong>Phone:</strong> {{ $shipment->phone }}<br><br>
                <strong>Address:</strong>
                {{ $shipment->address_line1 }},
                {{ $shipment->address_line2 ?? '' }},
                {{ $shipment->city }},
                {{ $shipment->zip_code }}<br><br>
                <strong>Shipment Date:</strong> {{ \Carbon\Carbon::parse($shipment->shipment_date)->format('d M Y') }}<br><br>
                <strong>Estimated Delivery Date:</strong> {{ \Carbon\Carbon::parse($shipment->delivery_date)->format('d M Y') }}<br>
            </div>

            {{-- Product Summary --}}
            <div class="product-summary" data-aos="fade-up" data-aos-duration="800" data-aos-delay="600">
                <h4>Order Summary</h4>
                @foreach($order->orderDetails as $item)
                <div class="product-item">
                    <div>{{ $item->product->name }} (×{{ $item->quantity }})</div>
                    <div>Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
                </div>
                @endforeach

                <div class="total">Subtotal: Rp{{ number_format($order->total_price, 0, ',', '.') }}</div>
                <div class="total">Shipping: Rp{{ number_format($shipment->shipping_cost ?? 0, 0, ',', '.') }}</div>
                <div class="total">
                    Total: Rp{{ number_format($order->total_price + ($shipment->shipping_cost ?? 0), 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: false,
            mirror: true
        });

        // Check for saved dark mode preference
        document.addEventListener('DOMContentLoaded', function() {
            const savedDarkMode = localStorage.getItem('darkMode');
            if (savedDarkMode === 'true') {
                document.body.classList.add('dark-mode');
            }
        });

        function toggleDarkMode() {
            const body = document.body;
            const isDark = body.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', isDark);
        }

        // Apply saved mode on load
        document.addEventListener('DOMContentLoaded', () => {
            const saved = localStorage.getItem('darkMode') === 'true';
            if (saved) {
                document.body.classList.add('dark-mode');
            }
        });
    </script>
@endsection