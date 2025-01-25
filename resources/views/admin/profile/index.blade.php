@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="content">
    <div class="chart-container">
        <h2><i class='bx bxs-user'></i> My Profile</h2>
        
        <div class="profile-content" style="margin-top: 20px;">
            <!-- Profile Image Section -->
            <div class="profile-image-section">
                <div class="current-image">
                    <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('images/default-avatar.png') }}" 
                         alt="Profile Image" 
                         id="preview-image">
                </div>
                <form method="post" action="{{ route('profile.update-image') }}" enctype="multipart/form-data" class="image-form">
                    @csrf
                    @method('patch')
                    <div class="file-input-wrapper">
                        <input type="file" 
                               id="profile_image" 
                               name="profile_image" 
                               accept="image/*"
                               onchange="previewImage(this)">
                        <label for="profile_image" class="file-label">Choose New Image</label>
                    </div>
                    <button type="submit" class="save-button">Update Image</button>
                    @error('profile_image')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </form>
            </div>

            <!-- Profile Information Form -->
            <form method="post" action="{{ route('profile.update') }}" class="profile-form">
                @csrf
                @method('patch')

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $user->name) }}" 
                           required>
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $user->email) }}" 
                           required>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="save-button">Update Profile</button>
                </div>
            </form>

            <!-- Password Update Form -->
            <form method="post" action="{{ route('profile.update-password') }}" class="password-form">
                @csrf
                @method('patch')

                <h3>Update Password</h3>

                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" 
                           id="current_password" 
                           name="current_password" 
                           required>
                    @error('current_password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           required>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm New Password</label>
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="save-button">Update Password</button>
                </div>
            </form>

            <hr style="margin: 30px 0;">

            <!-- Delete Account Section -->
            <div class="delete-account">
                <h3>Delete Account</h3>
                <p>Once your account is deleted, all of its resources and data will be permanently deleted.</p>
                
                <form method="post" action="{{ route('profile.destroy') }}" class="delete-form">
                    @csrf
                    @method('delete')

                    <div class="form-group">
                        <label for="delete_password">Password</label>
                        <input type="password" 
                               id="delete_password" 
                               name="password" 
                               required>
                        @error('password', 'userDeletion')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="delete-button">Delete Account</button>
                </form>
            </div>
        </div>
    </div>
</div>

@if (session('status'))
    <div id="profile-updated" class="alert-success">
        {{ session('status') }}
    </div>
@endif
@endsection

@section('additional_styles')
<style>
    .profile-content {
        max-width: 800px;
        margin: 0 auto;
    }

    .profile-image-section {
        text-align: center;
        margin-bottom: 30px;
    }

    .current-image {
        width: 150px;
        height: 150px;
        margin: 0 auto 15px;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid #ffd700;
    }

    .current-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .file-input-wrapper {
        margin-bottom: 10px;
    }

    .file-input-wrapper input[type="file"] {
        display: none;
    }

    .file-label {
        background-color: #f8f9fa;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
        border: 1px solid #ddd;
        display: inline-block;
    }

    .profile-form,
    .password-form,
    .delete-form {
        background-color: #fff;
        padding: 20px;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }

    .form-group input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .error-message {
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
        display: block;
    }

    .form-actions {
        margin-top: 30px;
    }

    .save-button {
        background-color: #ffd700;
        color: #333;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
        transition: background-color 0.3s;
    }

    .save-button:hover {
        background-color: #e6c200;
    }

    .delete-account {
        background-color: #fff;
        padding: 20px;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .delete-account h3 {
        color: #dc3545;
        margin-bottom: 10px;
    }

    .delete-account p {
        color: #666;
        margin-bottom: 20px;
    }

    .delete-button {
        background-color: #dc3545;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
        transition: background-color 0.3s;
    }

    .delete-button:hover {
        background-color: #c82333;
    }

    .alert-success {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: #28a745;
        color: white;
        padding: 15px 25px;
        border-radius: 4px;
        animation: fadeOut 3s forwards;
        z-index: 1000;
    }

    @keyframes fadeOut {
        0% { opacity: 1; }
        70% { opacity: 1; }
        100% { opacity: 0; }
    }
</style>
@endsection

@section('additional_scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Remove success message after animation
    const profileUpdated = document.getElementById('profile-updated');
    if (profileUpdated) {
        setTimeout(() => {
            profileUpdated.remove();
        }, 3000);
    }
</script>
@endsection