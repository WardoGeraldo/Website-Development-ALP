<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>My Store</title>
    <style>
        body {
            background-color: #fff;
            color: #333;
            font-family: 'Inter', sans-serif;
            transition: background-color 0.5s ease, color 0.5s ease;
        }

        body.dark-mode {
            background-color: #121212;
            color: #f5f5f5;
        }

        /* Dark Mode Toggle Button Styles */
        /* Base styling */
        .dark-mode-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #111;
            color: white;
            border: none;
            padding: 0.75rem 1.2rem;
            border-radius: 25px;
            cursor: grab;
            z-index: 9999;
            font-size: 1.3rem;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.3);
            user-select: none;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        /* Hover */
        .dark-mode-toggle:hover {
            background-color: #e76767;
            box-shadow: 0 6px 12px rgba(231, 103, 103, 0.7);
        }

        /* Responsive adjustment */
        @media (max-width: 768px) {
            .dark-mode-toggle {
                top: auto;
                bottom: 20px;
                right: 20px;
                left: auto;
                padding: 0.6rem 1rem;
                font-size: 1.1rem;
            }
        }

        @media (max-width: 480px) {
            .dark-mode-toggle {
                bottom: 15px;
                right: 15px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const savedMode = localStorage.getItem('darkMode');

        // Kalau belum pernah disimpan, tetap dark mode
        if (!savedMode || savedMode === 'enabled') {
            document.body.classList.add('dark-mode');
            document.querySelector('.dark-mode-toggle').textContent = '☀️';
        } else {
            document.body.classList.remove('dark-mode');
            document.querySelector('.dark-mode-toggle').textContent = '🌙';
        }
    });
</script>

<body>
    @if (!isset($__env->getSections()['hide_header_footer']))
        <button class="dark-mode-toggle" aria-label="Toggle dark mode" title="Toggle dark mode">🌙</button>
    @endif

    @if (!isset($__env->getSections()['hide_header_footer']))
        @include('include.header')
    @endif

    <div class="container-fluid" style="min-width:100%; margin:0 auto;">
        @yield('content')
        @yield('scripts')
    </div>

    @if (!isset($__env->getSections()['hide_header_footer']))
        @include('include.footer')
    @endif

    <!-- Place the dark mode toggle script here -->
    <script>
        const toggleButton = document.querySelector('.dark-mode-toggle');

        if (toggleButton) {
            // Dark mode load state
            if (localStorage.getItem('darkMode') === 'enabled') {
                document.body.classList.add('dark-mode');
                toggleButton.textContent = '☀️';
            }

            let isDragging = false;
            let offsetX, offsetY;

            toggleButton.addEventListener('mousedown', function(e) {
                isDragging = false; // reset on down
                offsetX = e.clientX - toggleButton.getBoundingClientRect().left;
                offsetY = e.clientY - toggleButton.getBoundingClientRect().top;

                const onMouseMove = function(e) {
                    isDragging = true;
                    const maxX = window.innerWidth - toggleButton.offsetWidth;
                    const maxY = window.innerHeight - toggleButton.offsetHeight;

                    let newX = e.clientX - offsetX;
                    let newY = e.clientY - offsetY;

                    // Constrain within window
                    newX = Math.max(0, Math.min(newX, maxX));
                    newY = Math.max(0, Math.min(newY, maxY));

                    toggleButton.style.left = `${newX}px`;
                    toggleButton.style.top = `${newY}px`;
                    toggleButton.style.right = 'auto';
                    toggleButton.style.cursor = 'grabbing';
                };


                const onMouseUp = function() {
                    document.removeEventListener('mousemove', onMouseMove);
                    document.removeEventListener('mouseup', onMouseUp);
                    toggleButton.style.cursor = 'grab';
                };

                document.addEventListener('mousemove', onMouseMove);
                document.addEventListener('mouseup', onMouseUp);
            });

            toggleButton.addEventListener('click', function(e) {
                if (isDragging) {
                    // Prevent toggling if it was a drag
                    isDragging = false;
                    return;
                }
                // Toggle dark mode
                document.body.classList.toggle('dark-mode');
                const isDark = document.body.classList.contains('dark-mode');
                localStorage.setItem('darkMode', isDark ? 'enabled' : 'disabled');
                toggleButton.textContent = isDark ? '☀️' : '🌙';
            });
        }
    </script>


</body>

</html>
