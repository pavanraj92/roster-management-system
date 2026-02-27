@extends('admin.layouts.app')

@section('title', 'Edit Staff')

@section('content')
<section class="content-main admin-form-page">
    <div class="row">
        <div class="clearfix">
            <div class="float-start">
                <h2 class="content-title card-title mb-0">Edit Staff</h2>
                <p class="listing-page-subtitle mb-3">Modify staff details</p>
            </div>

            <!-- Right side: Breadcrumb -->
            <x-admin.breadcrumb :list="[
            ['label' => 'Staff Manager', 'url' => route('admin.staff.index')],
            ['label' => 'Edit Staff']
        ]" class="float-end" />
        </div>
    </div>

    <div class="content-header listing-page-header">
        <div>
        </div>
    </div>
    <form action="{{ route('admin.staff.update', $staff->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 admin-form-main-card">
                    <div class="card-header">
                        <h4>Staff Information</h4>
                    </div>
                    <div class="card-body">
                        @include('admin.staff.form')
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection