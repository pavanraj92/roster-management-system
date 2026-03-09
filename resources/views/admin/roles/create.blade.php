@extends('admin.layouts.app')

@section('title', 'Create Role')

@section('content')
<section class="content-main admin-form-page">
    <div class="row">
        <div class="clearfix">
            <div class="float-start">
                <h2 class="content-title card-title mb-0">Create New Role</h2>
                <p class="listing-page-subtitle mb-3">
                    Add a new role
                </p>
            </div>

            <!-- Right side: Breadcrumb -->
            <x-admin.breadcrumb :list="[
            ['label' => 'Roles Manager', 'url' => route('admin.roles.index')],
            ['label' => 'Create Role']
            ]" class="float-end" />
        </div>
    </div>

    <form action="{{ route('admin.roles.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 admin-form-main-card">
                    <div class="card-header">
                        <h4>Role Information</h4>
                    </div>
                    <div class="card-body">
                        @include('admin.roles.form')
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection