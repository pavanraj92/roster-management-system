@extends('admin.layouts.app')

@section('title', 'Create User')

@section('content')
    <section class="content-main admin-form-page">
        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">Create User</h2>
                    <p class="listing-page-subtitle mb-3">Add a new user</p>
                </div>

                <!-- Right side: Breadcrumb -->
                <x-admin.breadcrumb :list="[
            ['label' => 'User Manager', 'url' => route('admin.user.index')],
            ['label' => 'Create User']
        ]" class="float-end" />
            </div>
        </div>

        <div class="content-header listing-page-header">
            <div>
            </div>
        </div>
        <form action="{{ route('admin.user.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 admin-form-main-card">
                        <div class="card-header">
                            <h4>User Information</h4>
                        </div>
                        <div class="card-body">
                            @include('admin.user.form')
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection