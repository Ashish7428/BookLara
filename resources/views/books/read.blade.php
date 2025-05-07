{{-- @extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Add Book Card at the top -->
    <div class="row mb-4">
        <div class="col-md-4">
            <x-book-card :book="$book" />
        </div>
        <div class="col-md-8">
            <div class="alert alert-info">
                <h4>Currently Reading: {{ $book->title }}</h4>
                <p class="mb-0">By {{ $book->author->full_name }}</p>
            </div>
        </div>
    </div>

    <!-- Existing PDF Reader Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $book->title }}</h4>
                    <div class="page-info">
                        Page {{ $currentPage }} of {{ $pageCount }}
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="pdf-container" style="height: 800px;">
                        <iframe src="{{ route('books.page', ['book' => $book, 'page' => $currentPage]) }}" 
                                frameborder="0" 
                                width="100%" 
                                height="100%">
                        </iframe>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-secondary {{ $currentPage <= 1 ? 'disabled' : '' }}"
                                onclick="changePage({{ $currentPage - 1 }})"
                                {{ $currentPage <= 1 ? 'disabled' : '' }}>
                            <i class="fas fa-chevron-left"></i> Previous
                        </button>
                        <button class="btn btn-primary {{ $currentPage >= $pageCount ? 'disabled' : '' }}"
                                onclick="changePage({{ $currentPage + 1 }})"
                                {{ $currentPage >= $pageCount ? 'disabled' : '' }}>
                            Next <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function changePage(page) {
    if (page < 1 || page > {{ $pageCount }}) return;
    window.location.href = "{{ route('books.read', ['book' => $book]) }}?page=" + page;
}
</script>
@endpush

@push('styles')
<style>
.pdf-container {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
}
.page-info {
    font-size: 1rem;
    font-weight: normal;
}
</style>
@endpush
@endsection --}}