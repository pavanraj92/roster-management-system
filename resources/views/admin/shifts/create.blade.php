@extends('admin.layouts.app')

@section('title', 'Create Shift')

@section('content')
    <section class="content-main admin-form-page">
        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">Create New Shift</h2>
                    <p class="listing-page-subtitle mb-3">
                        Add a new shift
                    </p>
                </div>

                <x-admin.breadcrumb :list="[
                    ['label' => 'Shifts Manager', 'url' => route('admin.shifts.index')],
                    ['label' => 'Create Shift']
                ]" class="float-end" />
            </div>
        </div>

        <form action="{{ route('admin.shifts.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 admin-form-main-card">
                        <div class="card-header">
                            <h4>Shift Information</h4>
                        </div>
                        <div class="card-body">
                            @include('admin.shifts.form')
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    @include('admin.shifts.partials.timepicker-script')
@endsection
