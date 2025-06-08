@extends('base.base')

@section('content')
<style>
    body {
        background-color: #f9f9f9;
        color: #d4af37;
        transition: background 0.3s ease, color 0.3s ease;
    }
    
    body.dark-mode {
        background-color: #121212;
        color: #d4af37;
    }
    
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap');
    
    .wishlist-header {
        text-align: center;
        padding: 4rem 1rem 3rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        position: relative;
        background: linear-gradient(to bottom, rgba(0,0,0,0.05) 0%, rgba(0,0,0,0) 100%);
    }
    
    .wishlist-header h1 {
        font-size: 3rem;
        letter-spacing: 4px;
        margin-bottom: 0.8rem;
        font-weight: 700;
        position: relative;
        display: inline-block;
        font-family: 'Playfair Display', serif;
        text-transform: uppercase;
    }
    
    .wishlist-header h1::after {
        content: '';
        position: absolute;
        bottom: -12px;
        left: 50%;
        transform: translateX(-50%);
        width: 120px;
        height: 2px;
        background: linear-gradient(90deg, transparent, #d4af37, transparent);
    }
    
    .heart-icon {
        width: 36px;
        height: 46px;
        vertical-align: middle;
        margin-right: 8px;
        padding-bottom: 12px;
        transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        filter: drop-shadow(0 0 3px rgba(212, 175, 55, 0.6));
    }

    .wishlist-header h1:hover .heart-icon {
        transform: scale(1.3) rotate(5deg);
    }
    
    .wishlist-header p {
        color: #888;
        max-width: 480px;
        margin: 1.2rem auto 2rem auto;
        padding-top: 5px;
        font-weight: 400;
        font-style: italic;
        letter-spacing: 1px;
        font-family: 'Montserrat', sans-serif;
    }
    
    body.dark-mode .wishlist-header p {
        color: #bbb;
    }
    
    .wishlist-grid {
        max-width: 1100px;
        margin: auto;
        padding: 0 2rem 5rem;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .wishlist-card {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.5rem;
        gap: 1.5rem;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: 1px solid rgba(0, 0, 0, 0.03);
        position: relative;
        overflow: hidden;
        margin-bottom: 0.5rem;
    }
    
    .wishlist-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(to bottom, #d4af37, transparent);
        opacity: 0;
        transition: opacity 0.4s ease;
    }
    
    .wishlist-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
    }
    
    .wishlist-card:hover::before {
        opacity: 1;
    }

    body.dark-mode .wishlist-card {
        background: #1e1e1e;
        color: #f5f5f5;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        border-color: rgba(212, 175, 55, 0.1);
    }

    .wishlist-card img {
        width: 110px;
        height: 110px;
        border-radius: 0.8rem;
        object-fit: cover;
        flex-shrink: 0;
        border: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease;
    }
    
    .wishlist-card:hover img {
        transform: scale(1.05);
    }

    body.dark-mode .wishlist-card img {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .wishlist-info {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .wishlist-info h4 {
        font-weight: 700;
        font-size: 1.3rem;
        margin-bottom: 0.5rem;
        letter-spacing: 1px;
        transition: color 0.3s ease;
        font-family: 'Playfair Display', serif;
    }
    
    .wishlist-card:hover .wishlist-info h4 {
        color: #d4af37;
    }

    body.dark-mode .wishlist-info h4 {
        color: #ffffff;
    }

    .wishlist-info span {
        font-size: 1.1rem;
        font-weight: 500;
        color: #333;
        margin-bottom: 0.5rem;
        font-family: 'Montserrat', sans-serif;
    }
    
    .wishlist-info span::before {
        content: 'Rp';
        font-size: 0.9rem;
        margin-right: 3px;
        color: #d4af37;
        font-weight: 600;
    }

    .wishlist-meta {
        display: flex;
        gap: 1.8rem;
        margin-top: 0.5rem;
        font-size: 0.95rem;
        color: #777;
        font-family: 'Montserrat', sans-serif;
    }
    
    .wishlist-meta div {
        position: relative;
    }
    
    .wishlist-meta div strong {
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .wishlist-meta div::after {
        content: '';
        position: absolute;
        bottom: -3px;
        left: 0;
        width: 0;
        height: 1px;
        background: #d4af37;
        transition: width 0.3s ease;
    }
    
    .wishlist-card:hover .wishlist-meta div::after {
        width: 100%;
    }

    body.dark-mode .wishlist-info span {
        color: #e0e0e0;
    }
    
    body.dark-mode .wishlist-meta {
        color: #bbb;
    }

    .wishlist-actions {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.8rem;
    }

    .btn-add-cart {
        background: #000;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.6rem 1.2rem;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        letter-spacing: 1px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        font-family: 'Montserrat', sans-serif;
        text-transform: uppercase;
        font-size: 0.85rem;
    }
    
    .btn-add-cart::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn-add-cart:hover {
        background: #d4af37;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(212, 175, 55, 0.3);
    }
    
    .btn-add-cart:hover::before {
        left: 100%;
    }

    .btn-remove {
        background: transparent;
        border: none;
        color: #ccc;
        font-size: 1.4rem;
        cursor: pointer;
        padding: 0;
        transition: all 0.3s ease;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .btn-remove:hover {
        color: #e76767;
        background-color: rgba(231, 103, 103, 0.1);
        transform: rotate(90deg);
    }

    .back-button {
        display: block;
        margin-top: 15px;
        color: #666;
        cursor: pointer;
        text-decoration: none;
        font-weight: 500;
        font-size: 16px;
        padding: 10px 20px;
        position: absolute;
        top: 10px;
        left: 20px;
        transition: all 0.3s ease;
        letter-spacing: 1px;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 4px;
        border: 1px solid rgba(212, 175, 55, 0.2);
    }
    
    body.dark-mode .back-button {
        color: #e0e0e0;
        background-color: rgba(0, 0, 0, 0.3);
        border-color: rgba(212, 175, 55, 0.3);
    }
    
    .back-button b {
        position: relative;
        padding-bottom: 2px;
        font-family: 'Montserrat', sans-serif;
    }
    
    .back-button b::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 1px;
        background: #d4af37;
        transition: width 0.3s ease;
    }
    
    .back-button:hover {
        color: #d4af37;
        background-color: rgba(212, 175, 55, 0.05);
    }
    
    .back-button:hover b::after {
        width: 100%;
    }
</style>

<div class="wishlist-header">
    <div class="back-button" onclick="window.location.href='{{ route('store.show') }}'">
        <b>← Back To Store</b>
    </div>
    <h1>
        Your Wishlist
        <img src="{{ asset('heartIcon.webp') }}" alt="heart" class="heart-icon">
    </h1>
    <p>Add products to your Wishlist to keep track of what you love !</p>
</div>


<div class="wishlist-grid">
    @forelse($wishlistItems as $index => $item)
        @php $product = $item->product; @endphp

        @if ($product)
            <div class="wishlist-card" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <a href="{{ route('product.show', ['id' => $product->product_id]) }}">
                    @php
                        $imageDir = public_path("images/products/{$item->product->product_id}");
                        $imageUrl = asset('fotoBaju.jpg'); // fallback

                        if (File::exists($imageDir)) {
                            $files = File::files($imageDir);
                            $image = collect($files)->first(function ($file) {
                                return in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp']);
                            });

                            if ($image) {
                                $imageUrl = asset("images/products/{$item->product->product_id}/" . $image->getFilename());
                            }
                        }
                    @endphp
                    <img src="{{ $imageUrl }}" alt="{{ $item->product->name }}" style="width: 100px;">
                </a>

                <div class="wishlist-info">
                    <a href="{{ route('product.show', ['id' => $product->product_id]) }}" class="text-decoration-none text-dark">
                        <h4>{{ $product->name ?? 'Unnamed Product' }}</h4>
                    </a>
                    <span>Rp{{ number_format($product->price, 0, ',', '.') }}</span>

                    
                </div>

                <div class="wishlist-actions">
                    <a href="{{ route('product.show', ['id' => $product->product_id]) }}" class="text-decoration-none text-dark">
                        <button class="btn-add-cart" >Add to Cart</button>
                    </a>
                    <form action="{{ route('wishlist.remove') }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                        <button type="submit" class="btn-remove">&times;</button>
                    </form>
                </div>
            </div>
        @endif
    @empty
        <p class="text-center w-100">Your wishlist is empty.</p>
    @endforelse
</div>


<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        easing: 'ease-out',
        once: true
    });
    
    function addToCart(id, name) {
        // Add elegant animation
        const btn = event.target;
        btn.innerHTML = "Added ✓";
        btn.style.background = "#d4af37";
        
        setTimeout(() => {
            btn.innerHTML = "Add to Cart";
            btn.style.background = "#000";
            alert('Added to cart: ' + name);
        }, 1000);
    }
    
    function removeFromWishlist(id, name) {
        // Add elegant fade out animation
        const card = event.target.closest('.wishlist-card');
        card.style.opacity = '0';
        card.style.transform = 'translateX(30px)';
        
        setTimeout(() => {
            alert('Removed ' + name + ' from wishlist');
            card.style.display = 'none';
        }, 500);
    }
</script>
@endsection