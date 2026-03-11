{{-- common form fields for create/edit shift --}}

@php
$startTime = old('start_time', isset($shift) ? \Carbon\Carbon::parse($shift->start_time)->format('H:i') : '');
$endTime = old('end_time', isset($shift) ? \Carbon\Carbon::parse($shift->end_time)->format('H:i') : '');
$name = old('name', isset($shift) ? $shift->name : '');
$color = old('color', isset($shift) ? $shift->color : '');
@endphp

<div class="row g-4 page-form-grid">
    <div class="mb-4 col-lg-6">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" placeholder="Name" class="form-control" id="name"
            value="{{ old('name', isset($shift) ? $shift->name : '') }}">
        @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>
    <div class="mb-4 col-lg-6">
        <label for="start_time" class="form-label">Start Time</label>
        <input type="text" name="start_time" placeholder="Start Time"
            class="form-control timepicker" id="start_time" value="{{ $startTime }}">
        @error('start_time') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>
    <div class="mb-4 col-lg-6">
        <label for="end_time" class="form-label">End Time</label>
        <input type="text" name="end_time" placeholder="End Time"
            class="form-control timepicker" id="end_time" value="{{ $endTime }}">
        @error('end_time') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>
    <div class="col-12 border-top pt-4 mt-4">
        <button type="submit" class="btn btn-primary">
            {{ isset($shift) ? 'Update' : 'Save' }}
        </button>
        <a href="{{ route('admin.shifts.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </div>
</div>