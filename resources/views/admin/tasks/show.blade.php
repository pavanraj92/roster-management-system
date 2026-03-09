@extends('admin.layouts.app')

@section('title', 'View Task')

@section('content')
    <section class="content-main">

        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">Task Details</h2>
                    <p class="listing-page-subtitle mb-3">
                        {{ $task->title }}
                    </p>
                </div>

                <x-admin.breadcrumb :list="[
                    ['label' => 'Tasks Manager', 'url' => route('admin.tasks.index')],
                    ['label' => 'View Task']
                ]" class="float-end" />
            </div>
        </div>

        <div class="card mb-4 details-card">
            <div class="card-body">
                <div class="details-info-group">
                    <div class="details-item">
                        <span class="details-label">Title</span>
                        <span class="details-value"><strong>{{ $task->title }}</strong></span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">Description</span>
                        <span class="details-value">
                            @if($task->description)
                                <div class="task-description-content">{!! $task->description !!}</div>
                            @else
                                —
                            @endif
                        </span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">Created By</span>
                        <span class="details-value">{{ $task->creator ? $task->creator->name : '—' }}</span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">Created At</span>
                        <span class="details-value">{{ $task->created_at->format('M d, Y h:i A') }}</span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">Updated At</span>
                        <span class="details-value">{{ $task->updated_at->format('M d, Y h:i A') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.tasks.edit', $task->id) }}" class="btn btn-primary">
                <i class="material-icons md-edit"></i> Edit
            </a>
            <a href="{{ route('admin.tasks.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>

    </section>
@endsection
