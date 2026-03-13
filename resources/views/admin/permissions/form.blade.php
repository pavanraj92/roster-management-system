<div class="row g-4 page-form-grid">
    <div class="mb-4 col-lg-6">
        <label class="form-label">Display Name</label>
        <input type="text" class="form-control @error('display_name') is-invalid @enderror" name="display_name"
            value="{{ old('display_name', $permission->display_name) }}" placeholder="Enter display name" required>
        @error('display_name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4 col-lg-6">
        <label class="form-label">Group Name</label>
        <input type="text" class="form-control" value="{{ $permission->group_name }}" disabled>
    </div>

    <div class="col-12 border-top pt-4 mt-4">
        <button type="submit" class="btn btn-primary">
            {{ isset($permission) ? 'Update' : 'Save' }}
        </button>
        <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </div>
</div>