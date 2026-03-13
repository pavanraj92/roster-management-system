@extends('admin.layouts.app')

@section('title', 'Edit Role')

@section('content')
    <section class="content-main admin-form-page">

        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">Edit Role</h2>
                    <p class="listing-page-subtitle mb-3">
                        Update role: {{ ucfirst($role->name) }}
                    </p>
                </div>

                <!-- Right side: Breadcrumb -->
                <x-admin.breadcrumb :list="[
            ['label' => 'Roles Manager', 'url' => route('admin.roles.index')],
            ['label' => 'Edit Role']]" class="float-end" />
            </div>
        </div>

        <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')
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


