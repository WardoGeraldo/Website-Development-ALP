@extends('base.base')

@section('content')
    <!-- AOS Animation and Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fd;
            min-height: 100vh;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 10px;
        }

        .form-control {
            padding: 14px;
            border-radius: 10px;
        }

        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            border: 2px dashed #ccc;
            padding: 30px;
            text-align: center;
            border-radius: 12px;
        }

        .file-input-wrapper input[type="file"] {
            opacity: 0;
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            cursor: pointer;
        }

        .file-input-wrapper:hover {
            border-color: #896cff;
            background-color: #f3f0ff;
        }

        #imagePreviewContainer img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-submit {
            padding: 14px 28px;
            border: none;
            border-radius: 50px;
            background: linear-gradient(135deg, #896cff 0%, #5a3fd9 100%);
            color: white;
            font-weight: 600;
            margin-top: 20px;
            width: 100%;
            transition: 0.3s;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #5a3fd9 0%, #896cff 100%);
        }
    </style>

    <div class="container" data-aos="fade-up">
        <h2 class="text-center mb-4">Add New Product</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf

            <div class="form-group mb-3">
                <label for="name">Product Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter product name..."
                    required>
            </div>

            <div class="form-group mb-3">
                <label for="price">Price</label>
                <input type="number" name="price" id="price" class="form-control" placeholder="Enter price..."
                    required>
            </div>

            <div class="form-group mb-3">
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="" disabled selected>-- Select Category --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" placeholder="Enter product description..."
                    rows="4"></textarea>
            </div>

            <!-- Upload multiple images -->
            <div class="form-group mb-3">
                <label for="images">Product Images (Max 4)</label>
                <div class="file-input-wrapper">
                    <span>Click here to upload images (PNG, JPG, JPEG) Max 4</span>
                    <input type="file" name="images[]" id="images" accept="image/*" multiple required>
                </div>
                <div id="imagePreviewContainer" class="d-flex flex-wrap justify-content-center"></div>
            </div>

            <button type="submit" class="btn btn-submit">Add Product</button>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true
        });

        const fileInput = document.getElementById('images');
        const previewContainer = document.getElementById('imagePreviewContainer');
        const fileInputWrapper = document.querySelector('.file-input-wrapper');
        const maxFiles = 4;

        function showPreviews(files) {
            previewContainer.innerHTML = ''; // Clear previews

            if (files.length > maxFiles) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: `You can only upload up to ${maxFiles} images.`,
                    confirmButtonColor: '#5a3fd9',
                    backdrop: `
                    rgba(0,0,123,0.4)
                    left top
                    no-repeat
                `
                });
                fileInput.value = ''; // Clear file input
                return;
            }

            Array.from(files).forEach(file => {
                if (!file.type.startsWith('image/')) {
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '100px';
                    img.style.height = '100px';
                    img.style.objectFit = 'cover';
                    img.style.margin = '10px';
                    img.style.borderRadius = '10px';
                    img.style.boxShadow = '0 4px 10px rgba(0, 0, 0, 0.1)';
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        }

        fileInput.addEventListener('change', function(event) {
            showPreviews(event.target.files);
        });

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            fileInputWrapper.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        fileInputWrapper.addEventListener('dragenter', () => {
            fileInputWrapper.style.borderColor = '#896cff';
            fileInputWrapper.style.backgroundColor = '#f3f0ff';
        });
        fileInputWrapper.addEventListener('dragleave', () => {
            fileInputWrapper.style.borderColor = '#ccc';
            fileInputWrapper.style.backgroundColor = 'white';
        });
        fileInputWrapper.addEventListener('dragover', () => {
            fileInputWrapper.style.borderColor = '#896cff';
            fileInputWrapper.style.backgroundColor = '#f3f0ff';
        });

        fileInputWrapper.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;

            showPreviews(files);
        });
    </script>
@endsection
