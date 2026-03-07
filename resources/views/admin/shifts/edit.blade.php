@extends('admin.layouts.app')

@section('title', 'Edit Shift')

@section('content')
<section class="content-main admin-form-page">

    <div class="row">
        <div class="clearfix">
            <div class="float-start">
                <h2 class="content-title card-title mb-0">Edit Shift</h2>
                <p class="listing-page-subtitle mb-3">
                    Update shift: {{ $shift->name }}
                </p>
            </div>

            <x-admin.breadcrumb :list="[
                    ['label' => 'Shifts Manager', 'url' => route('admin.shifts.index')],
                    ['label' => 'Edit Shift']
                ]" class="float-end" />
        </div>
    </div>

    <form action="{{ route('admin.shifts.update', $shift->id) }}" method="POST">
        @csrf
        @method('PUT')
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
@endsection