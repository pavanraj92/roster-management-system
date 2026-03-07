<div class="row g-4 page-form-grid">
    <div class="mb-4 col-lg-6">
        <label class="form-label">Permission Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
            value="{{ old('name') }}" placeholder="e.g., view_users" required>
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4 col-lg-6">
        <label class="form-label">Description</label>
        <textarea class="form-control @error('description') is-invalid @enderror" name="description"
            rows="3" placeholder="Enter permission description...">{{ old('description') }}</textarea>
        @error('description')
        <span class="text-danger small">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-12 border-top pt-4 mt-4">
        <button type="submit" class="btn btn-primary">
            {{ isset($permission) ? 'Update' : 'Save' }}
        </button>
        <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </div>
</div>