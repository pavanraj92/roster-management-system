@extends('admin.layouts.app')

@section('title', 'Create Email Template')

@section('content')
    <section class="content-main admin-form-page">

        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">Create Email Template</h2>
                    <p class="listing-page-subtitle mb-3">
                        Add a new email template
                    </p>
                </div>

                <!-- Breadcrumb -->
                <x-admin.breadcrumb :list="[
                    ['label' => 'Email Templates Manager', 'url' => route('admin.email-templates.index')],
                    ['label' => 'Create Email Template']
                ]" class="float-end" />
            </div>
        </div>

        <form action="{{ route('admin.email-templates.store') }}" method="POST">
            @csrf

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