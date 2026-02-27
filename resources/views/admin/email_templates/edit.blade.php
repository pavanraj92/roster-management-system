@extends('admin.layouts.app')

@section('title', 'Edit Email Template')

@section('content')
    <section class="content-main admin-form-page">

        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">Edit Email Template</h2>
                    <p class="listing-page-subtitle mb-3">
                        Edit existing template: {{ $email_template->name }}
                    </p>
                </div>

                <!-- Breadcrumb -->
                <x-admin.breadcrumb :list="[
                    ['label' => 'Email Templates Manager', 'url' => route('admin.email-templates.index')],
                    ['label' => 'Edit Email Template']
                ]" class="float-end" />
            </div>
        </div>

        <form action="{{ route('admin.email-templates.update', $email_template->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 admin-form-main-card">
                        <div class="card-header">
                            <h4>Basic Information</h4>
                        </div>

                        <div class="card-body">
                            @include('admin.email_templates.form')
                        </div>
                    </div>
                </div>
            </div>

        </form>

    </section>
@endsection