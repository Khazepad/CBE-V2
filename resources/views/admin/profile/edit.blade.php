@extends('layouts.admin')

@section('title', 'Edit Profile')

@section('content_header')
    <h1>Edit Profile</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center"> <!-- Added justify-content-center -->
        <div class="col-md-6">
            <!-- Profile Image Card -->
            <div class="card card-primary card-outline mb-4"> <!-- Added margin bottom -->
                <div class="card-body box-profile">
                    <div class="text-center">
                        @if(Auth::user()->profile_image)
                            <img class="profile-user-img img-fluid img-circle"
                                 src="{{ asset('storage/' . Auth::user()->profile_image) }}"
                                 alt="User profile picture">
                        @else
                            <img class="profile-user-img img-fluid img-circle"
                                 src="{{ asset('default-profile.png') }}"
                                 alt="Default profile picture">
                        @endif
                    </div>
                    <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>
                    <p class="text-muted text-center">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <!-- Profile Edit Form Card -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Profile Information</h3>
                </div>
                <form role="form" method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>

                        <div class="form-group">
                            <label for="profile_image">Profile Image</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('profile_image') is-invalid @enderror" id="profile_image" name="profile_image">
                                    <label class="custom-file-label" for="profile_image">Choose file</label>
                                </div>
                            </div>
                            @error('profile_image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        .profile-user-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function () {
            bsCustomFileInput.init();
        });
    </script>
@stop