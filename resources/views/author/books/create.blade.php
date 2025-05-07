@extends('layouts.author')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Upload New Book</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('author.books.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Book Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Book Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                id="description" name="description" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Categories</label>
                            <div class="row g-3 border p-3">
                                @foreach($categories as $category)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                name="categories[]" 
                                                value="{{ $category->id }}" 
                                                id="category{{ $category->id }}"
                                                {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="category{{ $category->id }}">
                                                {{ $category->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('categories')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="publication_year" class="form-label">Publication Year</label>
                            <input type="number" class="form-control @error('publication_year') is-invalid @enderror" 
                                id="publication_year" name="publication_year" 
                                value="{{ old('publication_year') }}" 
                                min="1900" max="{{ date('Y') }}">
                            @error('publication_year')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="cover_image" class="form-label">Cover Image</label>
                            <input type="file" class="form-control @error('cover_image') is-invalid @enderror" 
                                id="cover_image" name="cover_image" accept="image/jpeg,image/png">
                            <div class="form-text">Max size: 2MB. Formats: JPEG, PNG</div>
                            @error('cover_image')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pdf_file" class="form-label">PDF File</label>
                            <input type="file" class="form-control @error('pdf_file') is-invalid @enderror" 
                                id="pdf_file" name="pdf_file" accept="application/pdf" required>
                            <div class="form-text">Max size: 20MB. Format: PDF</div>
                            @error('pdf_file')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-dark">
                                <i class="fas fa-upload me-2"></i>Upload Book
                            </button>
                            <a href="{{ route('author.books.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Books
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
