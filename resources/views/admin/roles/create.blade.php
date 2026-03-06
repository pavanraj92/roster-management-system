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
            @include('admin.roles.form')
        </form>
    </section>
@endsection