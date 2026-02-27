{{-- common form fields for create/edit role --}}

<div class="row g-4 page-form-grid">
    <div class="col-lg-12">
        <div class="card mb-4 admin-form-main-card">
            <div class="card-header">
                <h4>Role Information</h4>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Role Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                        name="name" value="{{ old('name', $role->name ?? '') }}" placeholder="e.g., Manager">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="card-body">
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
                @error('permissions')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                {{ isset($role) ? 'Update' : 'Save' }}
            </button>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </div>
</div>