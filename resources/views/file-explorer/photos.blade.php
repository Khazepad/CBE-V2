@extends('layouts.app2')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        @include('file-explorer.sidebar')

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2>Photos</h2>
                <div class="input-group w-25">
                    <input type="text" class="form-control" placeholder="Search photos">
                    <button class="btn btn-outline-secondary" type="button"><i class="bx bx-search"></i></button>
                </div>
            </div>

            <!-- Breadcrumb -->
            @include('file-explorer.breadcrumb', ['breadcrumbs' => ['Photos']])

            <!-- Toolbar -->
            @include('file-explorer.toolbar')

            <!-- File Grid -->
            @include('file-explorer.file-grid', ['directories' => $directories, 'files' => $files, 'currentPath' => 'photos'])
        </main>
    </div>
</div>
@endsection
