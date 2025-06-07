@extends('base.base')

@section('content')
    <style>
        :root {
            --bg: #f8f9fa;
            --card: #ffffff;
            --text: #212529;
            --text-light: #6c757d;
            --border: #dee2e6;
            --accent: #6366f1;
            --accent-hover: #4f46e5;
            --hover-bg: rgba(0, 0, 0, 0.05);
        }

        body.dark-mode {
            --bg: #121212;
            --card: #1e1e1e;
            --text: #f3f4f6;
            --text-light: #9ca3af;
            --border: #2d2d2d;
            --accent: #818cf8;
            --accent-hover: #6366f1;
            --hover-bg: rgba(255, 255, 255, 0.05);
        }

        /* Container */
        .edit-product-container {
            max-width: 1100px;
            margin: 3rem auto;
            padding: 2rem;
            background-color: var(--card);
            color: var(--text);
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, color 0.3s;
        }

        /* Heading */
        .edit-product-container h1 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 2rem;
            border-bottom: 1px solid var(--border);
            padding-bottom: 1rem;
        }

        /* Form Label */
        form label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 1rem;
            color: var(--text-light);
        }

        /* Form Inputs */
        form input[type="text"],
        form input[type="number"],
        form input[type="file"],
        form textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            background-color: var(--bg);
            color: var(--text);
            transition: border-color 0.3s;
        }

        form input:focus,
        form textarea:focus {
            border-color: var(--accent);
            outline: none;
        }

        form textarea {
            min-height: 120px;
            resize: vertical;
        }

        /* Button Save */
        .btn-save {
            display: block;
            width: 100%;
            padding: 1rem;
            background-color: var(--accent);
            color: #fff;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 1.1rem;
        }

        .btn-save:hover {
            background-color: var(--accent-hover);
        }

        /* Back Link */
        .back-link {
            display: block;
            margin-top: 1.5rem;
            text-align: center;
            color: var(--accent);
            font-weight: 600;
            text-decoration: none;
        }

        .back-link:hover {
            color: var(--accent-hover);
        }

        /* Image Grid Container */
        .image-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin: 2rem 0;
        }

        /* Card for each image */
        .image-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            text-align: center;
            transition: transform 0.3s;
            padding: 10px;
        }

        /* IMG Styling */
        .image-card img {
            width: 100%;
            aspect-ratio: 1 / 1;
            /* <-- THIS makes it square */
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        /* Replace Button */
        .replace-btn {
            background-color: var(--accent);
            color: #fff;
            border: none;
            padding: 10px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .replace-btn:hover {
            background-color: var(--accent-hover);


        }

        .stock-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin: 2rem 0;
        }

        .stock-grid div {
            display: flex;
            flex-direction: column;
        }

        .stock-grid label {
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.9rem;
            color: var(--text-light);
            text-transform: uppercase;
        }

        .stock-grid input {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            border: 1px solid var(--border);
            background-color: var(--bg);
            color: var(--text);
            transition: border-color 0.3s;
        }

        .stock-grid input:focus {
            border-color: var(--accent);
            outline: none;
        }

        select {
            width: 100%;
            padding: 0.75rem 1rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            background-color: var(--bg);
            color: var(--text);
            transition: border-color 0.3s;
        }

        select:focus {
            border-color: var(--accent);
            outline: none;
        }

        @media (max-width: 600px) {
            .stock-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>

    <div class="edit-product-container">
        <h1>Edit Product</h1>

        <div class="image-grid">
            @foreach ($product['images'] as $image)
                <div class="image-card">
                    <img src="{{ asset($image['url']) }}" alt="Product Image">

                    <form
                        action="{{ route('admin.product.image.replace', ['id' => $product['id'], 'image_id' => $image['product_image_id']]) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="file" name="new_image" accept="image/*" style="display: none;"
                            onchange="this.form.submit()">
                        <button type="button" class="replace-btn" onclick="this.previousElementSibling.click()">
                            Replace Image
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        <form action="{{ route('admin.product.update', ['id' => $product['id']]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ $product['name'] }}" required>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="{{ $product['price'] }}" required>

            <label for="category_id">Category:</label>
            <select id="category_id" name="category_id" required>
                <option value="">-- Select Category --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->category_id }}"
                        {{ $category->category_id == $product['category_id'] ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>


            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4">{{ $product['description'] ?? '' }}</textarea>

            <div class="stock-grid">
                @php
                    $sizes = ['one_size', 'xs', 's', 'm', 'l', 'xxl'];
                @endphp
                @foreach ($sizes as $size)
                    <div>
                        <label for="stock_{{ $size }}">{{ strtoupper(str_replace('_', ' ', $size)) }}</label>
                        <input type="number" id="stock_{{ $size }}" name="stock[{{ $size }}]"
                            min="0" value="{{ $product['stock'][$size] ?? 0 }}" required>
                    </div>
                @endforeach
            </div>


            <button type="submit" class="btn-save">Save Changes</button>
        </form>

        <a href="{{ route('admin.dashboard') }}" class="back-link">← Back to Product List</a>
    </div>


    <script>
        document.getElementById('images').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const currentImage = document.getElementById('currentImage');
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    currentImage.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

    @if (session('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location.href = "{{ route('admin.dashboard') }}";
            });
        </script>
    @endif






    <script>
        // Preview new image when selected
        document.getElementById('image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('imagePreview');
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
                preview.src = '#';
            }
        });
    </script>
@endsection
