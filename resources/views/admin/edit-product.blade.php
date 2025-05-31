@extends('base.base')

@section('content')
    <style>
        .edit-product-container {
            max-width: 600px;
            margin: 3rem auto;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            font-family: 'Inter', sans-serif;
            color: #333;
        }

        .edit-product-container.dark-mode {
            background-color: #1c1c1c;
            color: #f5f5f5;
            box-shadow: 0 8px 24px rgba(255, 255, 255, 0.1);
        }

        .edit-product-container h1 {
            font-weight: 600;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        form label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            font-size: 1rem;
        }

        form input[type="text"],
        form input[type="number"],
        form input[type="file"],
        form textarea {
            width: 100%;
            padding: 0.6rem 1rem;
            margin-bottom: 1.5rem;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        form input[type="text"]:focus,
        form input[type="number"]:focus,
        form input[type="file"]:focus,
        form textarea:focus {
            border-color: #000;
            outline: none;
        }

        form textarea {
            min-height: 100px;
            resize: vertical;
        }

        .btn-save {
            display: block;
            width: 100%;
            padding: 0.75rem 1rem;
            background-color: #000;
            color: white;
            font-weight: 700;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1.1rem;
            transition: background-color 0.3s ease;
        }

        .btn-save:hover {
            background-color: #e76767;
        }

        .back-link {
            display: block;
            margin-top: 1.5rem;
            text-align: center;
            color: #444;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.3s;
        }

        .back-link:hover {
            color: #000;
        }

        /* Dark mode styles */
        body.dark-mode .edit-product-container {
            background-color: #1c1c1c;
            color: #ddd;
            box-shadow: 0 8px 24px rgba(255, 255, 255, 0.1);
        }

        body.dark-mode form input,
        body.dark-mode form textarea {
            background-color: #333;
            border-color: #555;
            color: #ddd;
        }

        body.dark-mode form input:focus,
        body.dark-mode form textarea:focus {
            border-color: #e76767;
        }

        body.dark-mode .back-link {
            color: #bbb;
        }

        body.dark-mode .back-link:hover {
            color: #fff;
        }

        /* Image preview styling */
        .current-image,
        .image-preview {
            display: block;
            max-width: 250px;
            max-height: 250px;
            margin: 0 auto 1.5rem auto;
            border-radius: 12px;
            object-fit: contain;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>

    <div class="edit-product-container" id="editProductContainer">
        <h1>Edit Product: {{ $product['name'] }}</h1>

        <!-- Current product image -->
        <div style="display: flex; flex-wrap: wrap; gap: 10px; justify-content: center;">
            @foreach ($product['images'] as $image)
                <div style="position: relative; width: 100px; text-align: center;">
                    <img src="{{ asset($image['url']) }}" alt="Current Image" class="current-image"
                        style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px;">

                    <div style="margin-top: 5px;">
                        <input type="radio" name="primary_image" value="{{ $image['id'] }}"
                            {{ $image['is_primary'] ? 'checked' : '' }}> Primary
                    </div>

                    <form action="{{ route('admin.product.image.delete', ['id' => $product['id']]) }}" method="POST"
                        style="position: absolute; top: -10px; right: -10px;">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="image_url" value="{{ $image['url'] }}">
                        <button type="submit"
                            style="background: red; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; font-size: 14px;">&times;</button>
                    </form>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 20px; text-align: center;">
            <label for="images" style="display: block; margin-bottom: 5px;">Change Image:</label>
            <input type="file" id="images" name="images[]" accept="image/*" multiple>
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

        <form action="{{ route('admin.product.update', ['id' => $product['id']]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @csrf
            @method('PUT')

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ $product['name'] }}" required>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="{{ $product['price'] }}" required>

            <label for="category">Category:</label>
            <input type="text" id="category" name="category" value="{{ $product['category'] }}" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4">{{ $product['description'] ?? '' }}</textarea>

            <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem;">
                @php
                    $sizes = ['one_size', 'xs', 's', 'm', 'l', 'xxl'];
                @endphp

                @foreach ($sizes as $size)
                    <div style="flex: 1;">
                        <label for="stock_{{ $size }}"
                            style="text-transform: uppercase;">{{ str_replace('_', ' ', $size) }}</label>
                        <input type="number" id="stock_{{ $size }}" name="stock[{{ $size }}]"
                            min="0" value="{{ $product['stock'][$size] ?? 0 }}" required>
                    </div>
                @endforeach

            </div>


            <button type="submit" class="btn-save">Save Changes</button>
        </form>

        <a href="{{ route('admin.dashboard') }}" class="back-link">← Back to Dashboard</a>
    </div>

    @if (session('success'))
        <script>
            alert('{{ session('success') }}');
            window.location.href = "{{ route('admin.dashboard') }}";
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
