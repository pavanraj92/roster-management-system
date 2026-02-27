@extends('admin.layouts.app')

@section('title', 'Edit Banner')

@section('content')
    <section class="content-main admin-form-page">
        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">Edit Banner</h2>
                    <p class="listing-page-subtitle mb-3">Update banner details</p>
                </div>

                <!-- Right side: Breadcrumb -->
                <x-admin.breadcrumb :list="[
            ['label' => 'Banners', 'url' => route('admin.settings.banners.index')],
            ['label' => 'Edit Banner']
        ]" class="float-end" />
            </div>
        </div>

        <div class="content-header listing-page-header">
            <div>
            </div>
        </div>
        <form action="{{ route('admin.settings.banners.update', $banner->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 admin-form-main-card">
                        <div class="card-header">
                            <h4>Basic Information</h4>
                        </div>
                        <div class="card-body">
                            @include('admin.settings.banners.form')
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection