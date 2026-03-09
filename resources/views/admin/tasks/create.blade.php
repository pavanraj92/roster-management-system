@extends('admin.layouts.app')

@section('title', 'Create Task')

@section('content')
    <section class="content-main admin-form-page">
        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">Create New Task</h2>
                    <p class="listing-page-subtitle mb-3">
                        Add a new task
                    </p>
                </div>

                <x-admin.breadcrumb :list="[
                    ['label' => 'Tasks Manager', 'url' => route('admin.tasks.index')],
                    ['label' => 'Create Task']
                ]" class="float-end" />
            </div>
        </div>

        <form action="{{ route('admin.tasks.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 admin-form-main-card">
                        <div class="card-header">
                            <h4>Task Information</h4>
                        </div>
                        <div class="card-body">
                            @include('admin.tasks.form')
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
