@extends('admin.layouts.app')

@section('title', 'Edit Page')

@section('content')
    <section class="content-main admin-form-page">

        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">Edit Page</h2>
                    <p class="listing-page-subtitle mb-3">
                        Edit existing page: {{ $page->title }}
                    </p>
                </div>

                <!-- Right side: Breadcrumb -->
                <x-admin.breadcrumb :list="[
            ['label' => 'Pages Manager', 'url' => route('admin.pages.index')],
            ['label' => 'Edit Page']
        ]" class="float-end" />
            </div>
        </div>

        <form action="{{ route('admin.pages.update', $page->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 admin-form-main-card">
                        <div class="card-header">
                            <h4>Basic Information</h4>
                        </div>

                        <div class="card-body">
                            @include('admin.pages.form')
                        </div>
                    </div>
                </div>
            </div>

        </form>

    </section>
@endsection