@extends('layouts.app2')

@section('content')
<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2>Trash</h2>
            </div>

            <!-- File Grid -->
            <div class="row" id="file-grid">
                <!-- Files -->
                @foreach ($files as $file)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <i class="bx bx-file" style="font-size: 3rem; color: #3498db;"></i>
                            <p class="mt-2 text-truncate">{{ basename($file) }}</p>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="{{ route('file-explorer.restore', basename($file)) }}">Restore</a></li>
                                    <li><a class="dropdown-item" href="{{ route('file-explorer.delete-permanently', basename($file)) }}">Delete Permanently</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </main>
    </div>
</div>
@endsection
