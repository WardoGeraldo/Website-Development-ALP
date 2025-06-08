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
        font-size: 0.95rem;
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

    footer h5 {
        font-size: 1.1rem;
    }

    footer ul {
        padding-left: 0;
    }

    footer ul li {
        margin-bottom: 0.5rem;
    }

    footer .fab {
        transition: transform 0.2s ease;
    }

    footer .fab:hover {
        transform: scale(1.15);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        footer .row {
            flex-direction: column;
        }

        footer .col-md-3 {
            width: 100%;
            text-align: center;
        }

        footer .col-md-3 h5 {
            margin-top: 1.5rem;
        }

        footer .col-md-3 ul {
            margin-bottom: 1rem;
        }

        footer .d-flex.gap-3 {
            justify-content: center;
        }

        footer .text-center {
            padding-top: 1rem;
        }
    }
</style>


<footer class="pt-5 border-top">
    <div class="container">
        <div class="row">

            <!-- Quote -->
            <div class="col-md-3 mb-4">
                <h5 class="fw-bold mb-3">Veravia.<br>The fashion for<br>classy woman<sup>®</sup></h5>
            </div>

            <!-- Tentang Kami -->
            <div class="col-md-3 mb-4">
                <h5 class="fw-bold mb-3">Tentang Kami</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ url('/#about-image') }}" rel="noopener" class="text-decoration-none">Profil Perusahaan</a></li>
                    <li><a href="https://forms.gle/9nFUCtjPS9NkYZVD6" target="_blank" rel="noopener" class="text-decoration-none">Job Recruitment</a></li>
                </ul>
            </div>

            <!-- Bantuan -->
            <div class="col-md-3 mb-4">
                <h5 class="fw-bold mb-3">Bantuan</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('contact.show') }}" class="text-decoration-none">Hubungi Kami</a></li>
                    <li><a href="{{ route('support.show') }}" class="text-decoration-none">FAQ</a></li>
                </ul>
            </div>


            <!-- Ikuti Kami -->
            <div class="col-md-3 mb-4">
                <h5 class="fw-bold mb-3">Ikuti Kami</h5>
                <div class="d-flex gap-3">
                    <a href="https://www.facebook.com/lilianlamano" target="_blank" rel="noopener"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="https://www.instagram.com/veravia.id?utm_source=ig_web_button_share_sheet&igsh=MW1qM3Q1NW1iNzExdw==" target="_blank" rel="noopener"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="https://www.youtube.com/watch?v=xvFZjo5PgG0" target="_blank" rel="noopener"><i class="fab fa-youtube fa-lg"></i></a>
                </div>
            </div>

        </div>

        <!-- Copyright -->
        <div class="text-center py-4 border-top mt-3">
            <small>&copy; {{ date('Y') }} Veravia Fashion Store. All rights reserved.</small>
        </div>
    </div>
</footer>