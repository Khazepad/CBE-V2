@extends('layouts.app2')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar" id="file-explorer-sidebar">
            <div class="position-sticky">
                <ul class="nav flex-column" id="sidebar-menu">
                    @foreach($menuItems as $item)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs($item['route']) ? 'active' : '' }}" href="{{ $item['route'] }}">
                                <i class="{{ $item['icon'] }}"></i> {{ $item['label'] }}
                            </a>
                            @if (isset($item['submenu']))
                                <ul class="nav flex-column" style="display: none;">
                                    @foreach ($item['submenu'] as $subItem)
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ $subItem['route'] }}">
                                                <i class="{{ $subItem['icon'] }}"></i> {{ $subItem['label'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2>File Explorer</h2>
                <div class="d-flex align-items-center">
                    <div class="input-group me-2">
                        <input type="text" class="form-control" placeholder="Search files or folders">
                        <button class="btn btn-outline-secondary" type="button"><i class="bx bx-search"></i></button>
                    </div>
                    <!-- Toolbar -->
                    <div class="toolbar d-flex">
                        <button class="btn btn-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#uploadModal"><i class="bx bx-upload"></i> Upload</button>
                        <button class="btn btn-secondary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#createFolderModal"><i class="bx bx-folder-plus"></i> New Folder</button>
                        <a href="{{ route('file-explorer.trash') }}" class="btn btn-secondary btn-sm ms-1"><i class="bx bx-trash"></i> Trash</a>
                    </div>
                </div>
            </div>

            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('file-explorer.index') }}">Home</a></li>
                    @foreach($breadcrumbs as $key => $breadcrumb)
                        <li class="breadcrumb-item">
                            <a href="{{ route('file-explorer.index', implode('/', array_slice($breadcrumbs, 0, $key + 1))) }}">
                                {{ $breadcrumb }}
                            </a>
                        </li>
                    @endforeach
                </ol>
            </nav>

            <!-- File Grid -->
            <div class="row" id="file-grid">
                <!-- Directories -->
                @foreach ($directories as $directory)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4 droppable" data-path="{{ $currentPath ? $currentPath . '/' . basename($directory) : basename($directory) }}">
                    <div class="card shadow-sm draggable" data-path="{{ $currentPath ? $currentPath . '/' . basename($directory) : basename($directory) }}">
                        <div class="card-body text-center">
                            <a href="{{ route('file-explorer.index', $currentPath ? $currentPath . '/' . basename($directory) : basename($directory)) }}" class="text-decoration-none">
                                <i class="bx bx-folder" style="font-size: 3rem; color: #f39c12;"></i>
                                <p class="mt-2 text-truncate">{{ basename($directory) }}</p>
                            </a>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="{{ route('file-explorer.delete', $currentPath ? $currentPath . '/' . basename($directory) : basename($directory)) }}">Delete</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Files -->
                @foreach ($files as $file)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4 droppable" data-path="{{ $currentPath ? $currentPath : '' }}">
                    <div class="card shadow-sm draggable" data-path="{{ $currentPath ? $currentPath . '/' . basename($file) : basename($file) }}">
                        <div class="card-body text-center">
                            <a href="{{ route('file-explorer.download', $currentPath ? $currentPath . '/' . basename($file) : basename($file)) }}" class="text-decoration-none">
                                <i class="bx bx-file" style="font-size: 3rem; color: #3498db;"></i>
                                <p class="mt-2 text-truncate">{{ basename($file) }}</p>
                            </a>
                            <p class="text-muted small">
                                {{ round(File::size(storage_path('app/public/' . ($currentPath ? $currentPath . '/' . basename($file) : basename($file)))) / 1024, 2) }} KB
                            </p>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="{{ route('file-explorer.download', $currentPath ? $currentPath . '/' . basename($file) : basename($file)) }}">Download</a></li>
                                    <li><a class="dropdown-item" href="{{ route('file-explorer.delete', $currentPath ? $currentPath . '/' . basename($file) : basename($file)) }}">Delete</a></li>
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

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('file-explorer.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="path" value="{{ $currentPath }}">
                    <div class="mb-3">
                        <label for="file" class="form-label">Select File</label>
                        <input type="file" class="form-control" id="file" name="file" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Create Folder Modal -->
<div class="modal fade" id="createFolderModal" tabindex="-1" aria-labelledby="createFolderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createFolderModalLabel">Create Folder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('file-explorer.create-folder') }}" method="POST">
                    @csrf
                    <input type="hidden" name="path" value="{{ $currentPath }}">
                    <div class="mb-3">
                        <label for="folder_name" class="form-label">Folder Name</label>
                        <input type="text" class="form-control" id="folder_name" name="folder_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Folder</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Create File Modal -->
<div class="modal fade" id="createFileModal" tabindex="-1" aria-labelledby="createFileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createFileModalLabel">Create File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('file-explorer.create-file') }}" method="POST">
                    @csrf
                    <input type="hidden" name="path" value="{{ $currentPath }}">
                    <div class="mb-3">
                        <label for="file_name" class="form-label">File Name</label>
                        <input type="text" class="form-control" id="file_name" name="file_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create File</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
    $(function() {
        $(".draggable").draggable({
            revert: true,
            helper: "clone",
            cursor: "move",
            opacity: 0.7
        });

        $(".droppable").droppable({
            accept: ".draggable",
            drop: function(event, ui) {
                var sourcePath = ui.helper.data('path');
                var destinationPath = $(this).data('path');

                $.ajax({
                    url: "{{ route('file-explorer.move') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        source_path: sourcePath,
                        destination_path: destinationPath
                    },
                    success: function(response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function(xhr) {
                        alert("Error: " + xhr.responseText);
                    }
                });
            }
        });

        // Function to update the sidebar
        function updateSidebar() {
            $.ajax({
                url: "{{ route('file-explorer.index') }}",
                method: "GET",
                success: function(response) {
                    var sidebarMenu = $('#sidebar-menu');
                    sidebarMenu.empty();
                    response.menuItems.forEach(function(item) {
                        var li = $('<li class="nav-item"></li>');
                        var a = $('<a class="nav-link" href="' + item.route + '"><i class="' + item.icon + '"></i> ' + item.label + '</a>');
                        li.append(a);
                        if (item.submenu) {
                            var ul = $('<ul class="nav flex-column" style="display: none;"></ul>');
                            item.submenu.forEach(function(subItem) {
                                var subLi = $('<li class="nav-item"></li>');
                                var subA = $('<a class="nav-link" href="' + subItem.route + '"><i class="' + subItem.icon + '"></i> ' + subItem.label + '</a>');
                                subLi.append(subA);
                                ul.append(subLi);
                            });
                            li.append(ul);
                        }
                        sidebarMenu.append(li);
                    });

                    // Add click event to toggle submenu
                    $('.nav-link').next('ul').hide();
                    $('.nav-link').on('click', function(e) {
                        e.preventDefault();
                        $(this).next('ul').toggle();
                    });
                },
                error: function(xhr) {
                    alert("Error: " + xhr.responseText);
                }
            });
        }

        // Update the sidebar when a folder or file is created
        $('form[action="{{ route('file-explorer.create-folder') }}"]').on('submit', function() {
            setTimeout(updateSidebar, 1000);
        });

        $('form[action="{{ route('file-explorer.create-file') }}"]').on('submit', function() {
            setTimeout(updateSidebar, 1000);
        });
    });
</script>
@endsection
