<!-- employees/index.blade.php -->
@extends('dashboard.layouts.app')


@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="pull-right  mt-3">
                <a class="btn btn-success" href="{{ route('employees.create') }}" id="createNewEmployee"> Add New Employee</a>
            </div>

            <table class="table table-bordered data-table mt-2" id="employee-table">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Salary</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection

