

<div class="card h-100 book-card">
    <img src="{{ asset($book->cover_image ?? 'images/default-book-cover.jpeg') }}" 
         class="card-img-top"
         alt="{{ $book->title }}"
         style="height: 350px; object-fit: cover;">
    <div class="card-body">
        <h5 class="card-title">{{ $book->title }}</h5>
        <p class="card-text text-muted mb-2">
            @forelse($book->categories as $category)
                <span class="badge bg-secondary me-1">{{ $category->name }}</span>
            @empty
                <span class="badge bg-warning text-dark">
                    <i class="fas fa-exclamation-circle me-1"></i>No Category
                </span>
            @endforelse
        </p>
        <div class="description-container">
            <p class="card-text description-text mb-1">{{ Str::limit($book->description, 100) }}</p>
            @if(strlen($book->description) > 100)
                <a href="#" class="text-primary see-more" data-bs-toggle="modal" data-bs-target="#description-{{ $book->id }}">
                    See more....
                </a>
            @endif
        </div>
        <p class="card-text">
            <small class="text-muted">By {{ $book->author_name ?? ($book->author->full_name ?? 'Unknown Author') }}</small>
        </p>
    </div>
    <div class="card-footer d-flex gap-2">
        @auth
            <a href="{{ route('books.show', $book) }}" class="btn btn-outline-light flex-grow-1 anchor-custom">
                Read Now
            </a>
        @else
            <button type="button" class="btn btn-outline-light flex-grow-1 anchor-custom" data-bs-toggle="modal" data-bs-target="#loginPromptModal-{{ $book->id }}">
                Read Now
            </button>
        @endauth
        <button class="btn btn-outline-dark bookmark-btn {{ Auth::check() && $book->bookmarks->where('user_id', auth()->id())->count() ? 'active' : '' }}" 
            @guest data-bs-toggle="modal" data-bs-target="#loginPromptModal-{{ $book->id }}" @endguest
            onclick="handleBookmark(event, {{ $book->id }}, this)">
            <i class="bookmark-icon {{ Auth::check() && $book->bookmarks->where('user_id', auth()->id())->count() ? 'fas' : 'far' }} fa-bookmark"></i>
        </button>
    </div>
</div>

@push('styles')
<style>
    .description-container {
        min-height: 60px;
    }
    .description-text {
        margin-bottom: 0.25rem;
    }
    .see-more {
        font-size: 0.875rem;
        text-decoration: none;
    }
    .see-more:hover {
        text-decoration: underline;
    }

    .anchor-custom {
           background-color: #000000; 
    }
    .anchor-custom:hover {
        color: rgb(0, 0, 0);
        background-color: #ffffff;
        outline:2px double #2c3e50;
   }
    .bookmark-btn {
        border-color: #000;
        color: #000;
        transition: all 0.3s ease;
    }
    
    .bookmark-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
    
    .bookmark-toggled {
        transform: scale(1.1);
    }
    
    .bookmark-btn.active .bookmark-icon {
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
    }
</style>
@endpush



<!-- Login Prompt Modal -->
<div class="modal fade" id="loginPromptModal-{{ $book->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Login Required</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Please login to access this feature.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
            </div>
        </div>
    </div>
</div>

<!-- Description Modal -->
@if(strlen($book->description) > 100)
    <div class="modal fade" id="description-{{ $book->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $book->title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ $book->description }}</p>
                </div>
            </div>
        </div>
    </div>
@endif

<script>
   

   function handleBookmark(event, bookId, button) {
    event.preventDefault();

    // For guest users, we don't need to proceed with AJAX
    @guest
        return;
    @endguest

    // Add loading state
    button.disabled = true;

    $.ajax({
        url: '/bookmark/' + bookId,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        success: function(response) {
            if (response.success) {
                const icon = button.querySelector('.bookmark-icon');
                
                // Toggle the icon classes
                icon.classList.toggle('far');
                icon.classList.toggle('fas');
                
                // Toggle the active state
                button.classList.toggle('active');

                // Add animation
                button.classList.add('bookmark-toggled');
                setTimeout(() => {
                    button.classList.remove('bookmark-toggled');
                }, 300);

                // Visual feedback
                button.style.borderColor = icon.classList.contains('fas') ? '#198754' : '#000';
                setTimeout(() => {
                    button.style.borderColor = '#000';
                }, 500);
            }
        },
        error: function(xhr) {
            console.error('Error:', xhr);
            // Error feedback
            button.style.borderColor = '#dc3545';
            setTimeout(() => {
                button.style.borderColor = '#000';
            }, 500);
        },
        complete: function() {
            button.disabled = false;
        }
    });
}

</script>
 