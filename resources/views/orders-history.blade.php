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

    .history-wrapper {
        position: relative;
        min-height: 100vh;
        padding: 0;
        z-index: 1;
    }

    .history-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 120px 2rem 80px;
        position: relative;
        z-index: 2;
    }

    .history-container h2 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 3.5rem;
        letter-spacing: 4px;
        font-weight: 600;
        margin-bottom: 3rem;
        color: var(--accent);
        text-align: center;
        position: relative;
    }

    .history-container h2::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        width: 80px;
        height: 2px;
        background: var(--accent);
        transform: translateX(-50%);
    }

    .no-orders {
        text-align: center;
        font-family: 'Montserrat', sans-serif;
        font-size: 1.2rem;
        color: var(--text-secondary);
        padding: 4rem 0;
        letter-spacing: 0.5px;
    }

    .history-entry {
        margin-bottom: 3rem;
        padding: 2rem;
        background: var(--primary);
        border-radius: 0;
        border: 1px solid var(--medium-gray);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: all 0.4s var(--transition);
        position: relative;
        overflow: hidden;
    }

    .history-entry::before {
        content: '';
        position: absolute;
        top: 15px;
        right: 15px;
        bottom: 15px;
        left: 15px;
        border: 1px solid rgba(212, 175, 55, 0);
        transition: all 0.4s var(--transition);
        pointer-events: none;
        z-index: 1;
    }

    .history-entry:hover::before {
        border-color: rgba(212, 175, 55, 0.3);
    }

    .history-entry:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }

    .dark-mode .history-entry {
        background: #1c1c1c;
        border-color: #333;
        box-shadow: 0 10px 30px rgba(255, 255, 255, 0.05);
    }

    .dark-mode .history-entry:hover {
        box-shadow: 0 15px 35px rgba(255, 255, 255, 0.08);
    }

    .history-entry h4 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.8rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 1.5rem;
        letter-spacing: 1px;
        border-bottom: 1px solid var(--medium-gray);
        padding-bottom: 0.5rem;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid var(--medium-gray);
        font-family: 'Montserrat', sans-serif;
        transition: all 0.3s var(--transition);
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .order-item:hover {
        background: var(--light-gray);
        margin: 0 -1rem;
        padding: 1rem;
        border-radius: 4px;
    }

    .order-item .item-name {
        font-weight: 500;
        color: var(--text-primary);
        letter-spacing: 0.5px;
    }

    .order-item .item-price {
        font-weight: 600;
        color: var(--text-secondary);
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem;
    }

    .total {
        text-align: right;
        font-weight: 600;
        margin-top: 1.5rem;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem;
        color: var(--text-secondary);
        letter-spacing: 0.5px;
    }

    .promo-discount {
        color: #28a745 !important;
        font-weight: 600;
        letter-spacing: 1px;
    }

    .final-total {
        font-size: 1.4rem !important;
        color: var(--accent) !important;
        font-weight: 700;
        border-top: 2px solid var(--medium-gray);
        padding-top: 1rem;
        margin-top: 1rem;
    }

    .shipment-detail {
        text-align: left;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--medium-gray);
    }

    .btn-shipment {
        padding: 0.8rem 1.5rem;
        background: var(--secondary);
        color: var(--primary);
        border: none;
        cursor: pointer;
        font-size: 0.85rem;
        letter-spacing: 2px;
        text-transform: uppercase;
        font-family: 'Montserrat', sans-serif;
        font-weight: 500;
        transition: all 0.4s var(--transition);
        position: relative;
        overflow: hidden;
        z-index: 1;
        text-decoration: none;
        display: inline-block;
    }

    .btn-shipment::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: var(--accent);
        transition: all 0.4s var(--transition);
        z-index: -1;
    }

    .btn-shipment:hover::before {
        left: 0;
    }

    .btn-shipment:hover {
        color: var(--secondary);
        text-decoration: none;
    }

    .dark-mode .btn-shipment {
        background: var(--primary);
        color: var(--secondary);
    }

    .dark-mode .btn-shipment:hover {
        color: var(--primary);
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .history-container {
            padding: 100px 1rem 60px;
        }
        
        .history-container h2 {
            font-size: 2.5rem;
            margin-bottom: 2rem;
        }
        
        .history-entry {
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .history-entry h4 {
            font-size: 1.5rem;
        }
        
        .order-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .order-item .item-price {
            align-self: flex-end;
        }
        
        .total {
            font-size: 1rem;
        }
        
        .final-total {
            font-size: 1.2rem !important;
        }
    }

    @media (max-width: 576px) {
        .history-container {
            padding: 80px 1rem 40px;
        }
        
        .history-container h2 {
            font-size: 2rem;
            letter-spacing: 2px;
        }
        
        .history-entry {
            padding: 1rem;
        }
        
        .btn-shipment {
            padding: 0.6rem 1.2rem;
            font-size: 0.8rem;
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="history-wrapper">
    <div class="pattern-overlay"></div>
    
    <div class="gold-accent gold-accent-1"></div>
    <div class="gold-accent gold-accent-2"></div>

    <div class="history-container">
        <h2 data-aos="fade-down" data-aos-duration="1000">ORDER HISTORY</h2>

        @if($orders->isEmpty())
            <div class="no-orders" data-aos="fade-up" data-aos-duration="800">
                You have no order history yet.
            </div>
        @else
            @foreach($orders as $order)
                <div class="history-entry" data-aos="fade-up" data-aos-duration="800" data-aos-delay="{{ $loop->index * 100 }}">
                    <h4>Order on {{ $order->created_at->format('F j, Y H:i') }}</h4>

                    @foreach($order->orderDetails as $item)
                        <div class="order-item">
                            <div class="item-name">{{ $item->product->name ?? 'Unknown Product' }} (x{{ $item->quantity }})</div>
                            <div class="item-price">Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
                        </div>
                    @endforeach

                    <div class="total">Subtotal: Rp{{ number_format($order->total_price + optional($order->promo)->discount * ($order->total_price), 0, ',', '.') }}</div>

                    @if($order->promo)
                        <div class="total promo-discount">
                            Promo ({{ $order->promo->code }})
                        </div>
                    @endif

                    <div class="total final-total">
                        Final Total: Rp{{ number_format($order->total_price, 0, ',', '.') }}
                    </div>
                    
                    <div class="shipment-detail">
                        <a href="{{ route('shipment.show', ['order_id' => $order->order_id]) }}" class="btn-shipment">
                            View Shipment Details
                        </a>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

<script>
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
</script>
@endsection