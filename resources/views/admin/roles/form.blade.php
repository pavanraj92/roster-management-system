<div class="row g-4 page-form-grid">

    <div class="mb-4 col-lg-6">
        <label class="form-label">Role Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror"
            name="name" value="{{ old('name', $role->name ?? '') }}" placeholder="e.g., Manager">
        @error('name')
        <span class="text-danger small">{{ $message }}</span>
        @enderror
    </div>


    <div class="pb-3">
        <h5>Assign Permissions</h5>
    </div>
    <div class="row">
        @foreach($permissions->chunk(2) as $chunk)
        @foreach($chunk as $permission)
        <div class="col-md-6 mb-3">
            <div class="form-check">
                @if($permission->name === 'dashboard_access')
                {{-- always grant dashboard access, cannot be unchecked --}}
                <input class="form-check-input" type="checkbox" name="permissions[]"
                    value="{{ $permission->id }}" id="permission_{{ $permission->id }}"
                    checked disabled>
                <input type="hidden" name="permissions[]" value="{{ $permission->id }}">
                @else
                <input class="form-check-input" type="checkbox" name="permissions[]"
                    value="{{ $permission->id }}" id="permission_{{ $permission->id }}"
                    {{ isset($rolePermissions) && in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                @endif

                <label class="form-check-label" for="permission_{{ $permission->id }}">
                    {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                </label>
            </div>
        </div>
        @endforeach
        @endforeach
    </div>
    @error('permissions') <span class="text-danger small">{{ $message }}</span> @enderror
    <div class="col-12 border-top pt-4 mt-4">
        <button type="submit" class="btn btn-primary">
            {{ isset($role) ? 'Update' : 'Save' }}
        </button>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </div>
</div>