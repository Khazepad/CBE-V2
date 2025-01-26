@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Academic Settings</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Academic Settings</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Set Default School Year</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="year">Select School Year</label>
                                <select class="form-control" id="year" name="year">
                                    @foreach ($schoolYears as $schoolYear)
                                        <option value="{{ $schoolYear->year }}" {{ $settings['defaultSchoolYear'] && $settings['defaultSchoolYear']->year === $schoolYear->year ? 'selected' : '' }}>
                                            {{ $schoolYear->year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Set to Default</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Set Default Semester</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="semester">Select Semester</label>
                                <select class="form-control" id="semester" name="semester">
                                    @foreach ($semesters as $semester)
                                        <option value="{{ $semester->semester }}" {{ $settings['defaultSemester'] && $settings['defaultSemester']->semester === $semester->semester ? 'selected' : '' }}>
                                            {{ $semester->semester }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Set to Default</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">School Years</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>School Year</th>
                                    <th style="width: 40px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schoolYears as $schoolYear)
                                    <tr>
                                        <td>{{ $schoolYear->year }}</td>
                                        <td><a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Semesters</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Semester</th>
                                    <th style="width: 40px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($semesters as $semester)
                                    <tr>
                                        <td>{{ $semester->semester }}</td>
                                        <td><a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection

@push('styles')
<!-- Add any additional styles here -->
@endpush

@push('scripts')
<!-- Add any additional scripts here -->
<script>
$(function () {
    // Add any necessary JavaScript here
});
</script>
@endpush
