@extends('layouts.admin')

@section('title', 'Appointment')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Appointment</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Added margin-top to container -->
    <div class="container-fluid mt-4">
        <!-- Appointment Form -->
        <div class="card">
            <!-- Modified header with yellow background -->
            <div class="card-header" style="background-color: #FFEB3B;">
                <h3 class="card-title text-dark">Request an Appointment</h3>
            </div>
            <form id="appointmentForm" action="{{ route('student.appointment-calendar.store-step1') }}" method="POST">
                @csrf
                <!-- Added padding to card body -->
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="teacher_search">Search Admin</label>
                                <div class="input-group">
                                    <input type="text" class="form-control wide-search" id="teacher_search" name="teacher_search" placeholder="Search by name..." required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                                <input type="hidden" id="teacher_id" name="teacher_id">
                                <div id="adminList" class="list-group mt-2" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Added margin to form group -->
                    <div class="form-group mt-4">
                        <label for="comments">Purpose <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="comments" name="comments" rows="3" maxlength="100" required></textarea>
                        <small id="charCount" class="form-text text-muted">0/100 characters</small>
                    </div>
                </div>
                <!-- Modified footer with better spacing -->
                <div class="card-footer bg-light">
                    <button type="submit" class="btn btn-primary float-right">Next</button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <style>
        .wide-search {
            width: 100%;
        }
    </style>
@stop

