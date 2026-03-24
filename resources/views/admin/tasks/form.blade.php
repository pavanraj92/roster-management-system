{{-- common form fields for create/edit task --}}

@php
    $title = old('title', isset($task) ? $task->title : '');
    $description = old('description', isset($task) ? $task->description : '');
@endphp

<div class="row g-4 page-form-grid">
    <div class="mb-4 col-lg-6">
        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
        <input type="text" name="title" placeholder="Title" class="form-control @error('title') is-invalid @enderror" id="title"
            value="{{ old('title', isset($task) ? $task->title : '') }}">
        @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>
    <div class="mb-4 col-lg-12">
        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
        <textarea name="description" placeholder="Description" class="form-control @error('description') is-invalid @enderror" id="description" rows="30" cols="12">
            {{ old('description', isset($task) ? $task->description : '') }} </textarea>
        @error('description') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>

    <div class="col-12 border-top pt-4 mt-4">
        <button type="submit" class="btn btn-primary">
            {{ isset($task) ? 'Update' : 'Save' }}
        </button>
        <a href="{{ route('admin.tasks.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </div>
</div>

@include('admin.tasks.partials.script')