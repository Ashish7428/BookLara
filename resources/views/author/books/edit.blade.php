@extends('layouts.author')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Book</h4>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('author.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Book Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                id="title" name="title" value="{{ old('title', $book->title) }}" required>
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Book Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                id="description" name="description" rows="4">{{ old('description', $book->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Replace the single category dropdown with multiple categories checkboxes --}}
                        <div class="mb-3">
                            <label class="form-label">Categories</label>
                            <div class="row g-3 border p-3">
                                @foreach(\App\Models\Category::orderBy('name')->get() as $category)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                name="categories[]" 
                                                value="{{ $category->id }}" 
                                                id="category{{ $category->id }}"
                                                {{ in_array($category->id, old('categories', $book->categories->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}>
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
                                value="{{ old('publication_year', $book->publication_year) }}" 
                                min="1900" max="{{ date('Y') }}">
                            @error('publication_year')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="cover_image" class="form-label">Cover Image</label>
                            @if($book->cover_image)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($book->cover_image) }}" 
                                        alt="Current cover" class="img-thumbnail" style="height: 200px;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('cover_image') is-invalid @enderror" 
                                id="cover_image" name="cover_image" accept="image/jpeg,image/png">
                            <div class="form-text">Max size: 2MB. Formats: JPEG, PNG</div>
                            @error('cover_image')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Remove the duplicate book_file field --}}
                        <div class="mb-3">
                            <label for="pdf_file" class="form-label">Book File (PDF)</label>
                            <input type="file" class="form-control @error('pdf_file') is-invalid @enderror" 
                                id="pdf_file" name="pdf_file" accept=".pdf">
                            @if($book->pdf_path)
                                <small class="text-muted">Current file: {{ basename($book->pdf_path) }}</small>
                            @endif
                            @error('pdf_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Remove this duplicate section --}}
                        {{-- <div class="mb-4">
                            <p class="mb-1">Current PDF: {{ basename($book->pdf_path) }}</p>
                            <div class="form-text mb-3">To change the PDF file, please upload a new book.</div>
                        </div> --}}

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Changes
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