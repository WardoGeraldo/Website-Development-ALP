<style>
    :root {
        --footer-bg: #f8f9fa;
        --footer-text: #1f2937;
        --footer-link: #1f2937;
        --footer-link-hover: #4f46e5;
        --footer-border: #e5e7eb;
    }

    body.dark-mode {
        --footer-bg: #1e1e1e;
        --footer-text: #f3f4f6;
        --footer-link: #f3f4f6;
        --footer-link-hover: #a5b4fc;
        --footer-border: #2d2d2d;
    }

    footer {
        background-color: var(--footer-bg) !important;
        color: var(--footer-text) !important;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    footer a {
        color: var(--footer-link) !important;
        transition: color 0.3s ease;
    }

    footer a:hover {
        color: var(--footer-link-hover) !important;
    }

    footer .border-top {
        border-color: var(--footer-border) !important;
    }
</style>

<footer class="pt-5 border-top">
    <div class="container">
        <div class="row">

            <!-- Quote -->
            <div class="col-md-3 mb-4">
                <h5 class="fw-bold mb-3">Veravia.<br>The agency for<br>impatient brands<sup>®</sup></h5>
            </div>

            <!-- Tentang Kami -->
            <div class="col-md-3 mb-4">
                <h5 class="fw-bold mb-3">Tentang Kami</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-decoration-none">Profil Perusahaan</a></li>
                    <li><a href="#" class="text-decoration-none">Karier</a></li>
                    <li><a href="#" class="text-decoration-none">Blog</a></li>
                </ul>
            </div>

            <!-- Bantuan -->
            <div class="col-md-3 mb-4">
                <h5 class="fw-bold mb-3">Bantuan</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-decoration-none">Hubungi Kami</a></li>
                    <li><a href="#" class="text-decoration-none">Cara Pengembalian</a></li>
                    <li><a href="#" class="text-decoration-none">FAQ</a></li>
                </ul>
            </div>

            <!-- Ikuti Kami -->
            <div class="col-md-3 mb-4">
                <h5 class="fw-bold mb-3">Ikuti Kami</h5>
                <div class="d-flex gap-3">
                    <a href="#"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#"><i class="fab fa-twitter fa-lg"></i></a>
                    <a href="#"><i class="fab fa-youtube fa-lg"></i></a>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="text-center py-4 border-top mt-3">
            <small>&copy; {{ date('Y') }} Veravia Fashion Store. All rights reserved.</small>
        </div>
    </div>
</footer>
