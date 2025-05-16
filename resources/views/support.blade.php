@extends('base.base')
@section('content')

<!-- AOS CSS -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

<style>
    .glass-hero {
        height: 60vh;
        background: url('backgroundWeb.jpg') center/cover no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .glass-hero::before {
        content: "";
        position: absolute;
        inset: 0;
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.1);
        z-index: 1;
    }

    .hero-text {
        position: relative;
        z-index: 2;
        text-align: center;
        color: black;
    }

    .hero-text h1 {
        font-size: 3rem;
        font-weight: 700;
    }

    .hero-text p {
        font-size: 1.1rem;
        margin-top: 0.5rem;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #000;
    }

    .accordion-button {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    .accordion-button:focus {
        box-shadow: none;
    }

    .glass-form {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(12px);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }
</style>

<!-- Hero Section -->
<div class="glass-hero">
    <div class="hero-text" data-aos="fade-down">
        <h1>Butuh Bantuan?</h1>
        <p>Kami di sini untuk membantu Anda kapan saja</p>
    </div>
</div>

<!-- Support Content -->
<div class="container py-5">
    <div class="row g-5">
        <!-- FAQ -->
        <div class="col-md-6" data-aos="fade-right">
            <h3 class="fw-bold mb-4">Pertanyaan yang Sering Diajukan</h3>
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            Bagaimana cara melacak pesanan saya?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            Setelah pembayaran berhasil, Anda akan menerima email dengan nomor pelacakan.
                        </div>
                    </div>
                </div>
                <div class="accordion-item mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            Apakah saya bisa mengembalikan produk?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            Ya, Anda dapat melakukan pengembalian dalam 7 hari setelah menerima barang.
                        </div>
                    </div>
                </div>
                <div class="accordion-item mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                            Bagaimana cara menghubungi tim customer service?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            Anda dapat menghubungi kami melalui formulir di samping atau email ke support@veravia.id.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-md-6" data-aos="fade-left">
            <h3 class="fw-bold mb-4">Hubungi Kami</h3>
            <form class="glass-form shadow-sm">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" placeholder="Nama lengkap Anda">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input type="email" class="form-control" id="email" placeholder="you@example.com">
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Pesan</label>
                    <textarea class="form-control" id="message" rows="4" placeholder="Tulis pertanyaan atau kendala Anda di sini"></textarea>
                </div>
                <button type="submit" class="btn btn-dark rounded-pill px-4">Kirim</button>
            </form>
        </div>
    </div>
</div>

<!-- AOS JS -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1200,
        once: true
    });
</script>

@endsection