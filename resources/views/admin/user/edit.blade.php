@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')
    <section class="content-main admin-form-page">
        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">Edit User</h2>
                    <p class="listing-page-subtitle mb-3">Modify user details</p>
                </div>

                <!-- Right side: Breadcrumb -->
                <x-admin.breadcrumb :list="[
            ['label' => 'User Manager', 'url' => route('admin.user.index')],
            ['label' => 'Edit User']
        ]" class="float-end" />
            </div>
        </div>

        <div class="content-header listing-page-header">
            <div>
            </div>
        </div>
        <form action="{{ route('admin.user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
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