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
        .dark-mode-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #111;
            color: white;
            border: none;
            padding: 0.75rem 1.2rem;
            border-radius: 25px;
            cursor: pointer;
            z-index: 9999;
            font-size: 1.3rem;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.3);
            user-select: none;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .dark-mode-toggle:hover {
            background-color: #e76767;
            box-shadow: 0 6px 12px rgba(231, 103, 103, 0.7);
        }
    </style>
</head>
<script>
    // On page load, check localStorage for dark mode setting
    document.addEventListener('DOMContentLoaded', function() {
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.body.classList.add('dark-mode');
        }
    });

    // Toggle function
    function toggleDarkMode() {
        const body = document.body;
        body.classList.toggle('dark-mode');

        // Save preference to localStorage
        if (body.classList.contains('dark-mode')) {
            localStorage.setItem('darkMode', 'enabled');
        } else {
            localStorage.setItem('darkMode', 'disabled');
        }
    }
</script>

<body>
    <button class="dark-mode-toggle" aria-label="Toggle dark mode" title="Toggle dark mode">🌙</button>

    @include('include.header')
    <div class="container-fluid" style="min-width:100%; margin:0 auto;">
        @yield('content')
        @yield('scripts')
    </div>
    @include('include.footer')

    <!-- Place the dark mode toggle script here -->
    <script>
      const toggleButton = document.querySelector('.dark-mode-toggle');

      // Load mode from localStorage on page load
      if(localStorage.getItem('darkMode') === 'enabled'){
          document.body.classList.add('dark-mode');
          toggleButton.textContent = '☀️'; // sun icon
      }

      toggleButton.addEventListener('click', () => {
          document.body.classList.toggle('dark-mode');

          if(document.body.classList.contains('dark-mode')){
              localStorage.setItem('darkMode', 'enabled');
              toggleButton.textContent = '☀️';
          } else {
              localStorage.setItem('darkMode', 'disabled');
              toggleButton.textContent = '🌙';
          }
      });
    </script>
</body>


</html>
