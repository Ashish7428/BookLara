@extends('layouts.author')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Edit Profile</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('author.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                                   id="full_name" name="full_name" value="{{ old('full_name', $author->full_name) }}">
                            @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $author->email) }}">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone', $author->phone) }}">
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Username field removed -->

                        <div class="mb-3">
                            <label for="bio" class="form-label">Biography <small class="text-muted">(<span id="bio-counter">0</span>/1000)</small></label>
                            <textarea class="form-control @error('bio') is-invalid @enderror" 
                                      id="bio" name="bio" rows="4">{{ old('bio', $author->bio) }}</textarea>
                            @error('bio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Rest of the form fields remain the same -->
                        <div class="mb-3">
                            <label for="profile_image" class="form-label">Profile Image</label>
                            <input type="file" class="form-control @error('profile_image') is-invalid @enderror" 
                                   id="profile_image" name="profile_image">
                            @error('profile_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="facebook_url" class="form-label">Facebook URL</label>
                            <input type="url" class="form-control @error('facebook_url') is-invalid @enderror" 
                                   id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $author->facebook_url) }}">
                            @error('facebook_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="twitter_url" class="form-label">Twitter URL</label>
                            <input type="url" class="form-control @error('twitter_url') is-invalid @enderror" 
                                   id="twitter_url" name="twitter_url" value="{{ old('twitter_url', $author->twitter_url) }}">
                            @error('twitter_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="instagram_url" class="form-label">Instagram URL</label>
                            <input type="url" class="form-control @error('instagram_url') is-invalid @enderror" 
                                   id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $author->instagram_url) }}">
                            @error('instagram_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="linkedin_url" class="form-label">LinkedIn URL</label>
                            <input type="url" class="form-control @error('linkedin_url') is-invalid @enderror" 
                                   id="linkedin_url" name="linkedin_url" value="{{ old('linkedin_url', $author->linkedin_url) }}">
                            @error('linkedin_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="text-end">
                            <a href="{{ route('author.profile') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const bioTextarea = document.getElementById('bio');
    const bioCounter = document.getElementById('bio-counter');

    const updateCharacterCount = () => {
        const currentLength = bioTextarea.value.length;
        bioCounter.textContent = currentLength;
    };

    // Update on input
    bioTextarea.addEventListener('input', updateCharacterCount);
    bioTextarea.addEventListener('keyup', updateCharacterCount);
    bioTextarea.addEventListener('paste', updateCharacterCount);

    // Initial count on page load
    updateCharacterCount();
});
</script>
@endsection