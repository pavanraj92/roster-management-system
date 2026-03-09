@extends('admin.layouts.app')

@section('title', 'Create Permission')

@section('content')
<section class="content-main admin-form-page">

    <div class="row">
        <div class="clearfix">
            <div class="float-start">
                <h2 class="content-title card-title mb-0">Create New Permission</h2>
                <p class="listing-page-subtitle mb-3">
                    Add a new system permission
                </p>
            </div>

            <!-- Right side: Breadcrumb -->
            <x-admin.breadcrumb :list="[
            ['label' => 'Permissions Manager', 'url' => route('admin.permissions.index')],
            ['label' => 'Create Permission']
        ]" class="float-end" />
        </div>
    </div>

    <form action="{{ route('admin.permissions.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 admin-form-main-card">
                    <div class="card-header">
                        <h4>Permission Information</h4>
                    </div>
                    <div class="card-body">
                        @include('admin.permissions.form')
                    </div>
                </div>
            </div>
        </div>
    </form>

</section>
@endsection