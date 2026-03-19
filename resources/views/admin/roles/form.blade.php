<div class="row g-4 page-form-grid">

    <div class="mb-4 col-lg-6">
        <label class="form-label">Role Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
            value="{{ old('name', $role->name ?? '') }}" placeholder="e.g., Manager" {{isset($role->name) ? 'readonly' : '-'}}>
        @error('name')
            <span class="text-danger small">{{ $message }}</span>
        @enderror
    </div>


    <div class="pb-3">
        <h5>Assign Permissions</h5>
    </div>
    @php
        $permissionsByGroup = $permissions->groupBy(function ($p) {
            return $p->group_name ?: 'other';
        });
    @endphp

    <div class="row">
        @foreach($permissionsByGroup as $groupName => $groupPermissions)
            @php
                $groupKey = \Illuminate\Support\Str::slug($groupName, '_');
                $groupLabel = ucfirst(str_replace('_', ' ', $groupName));
            @endphp

            <div class="col-12 mb-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="mb-0">{{ $groupLabel }}</h6>
                    <div class="form-check mb-0">
                        <input class="form-check-input role-group-toggle" type="checkbox" id="perm_group_{{ $groupKey }}"
                            data-group="{{ $groupKey }}">
                        <label class="form-check-label" for="perm_group_{{ $groupKey }}">Select All</label>
                    </div>
                </div>
                <hr class="mt-2 mb-3" />

                <div class="row">
                    @foreach($groupPermissions as $permission)
                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                @if($permission->name === 'dashboard_access')
                                    {{-- always grant dashboard access, cannot be unchecked --}}
                                    <input class="form-check-input role-permission-checkbox" type="checkbox" name="permissions[]"
                                        value="{{ $permission->id }}" id="permission_{{ $permission->id }}"
                                        data-group="{{ $groupKey }}" checked disabled>
                                    <input type="hidden" name="permissions[]" value="{{ $permission->id }}">
                                @else
                                    <input class="form-check-input role-permission-checkbox" type="checkbox" name="permissions[]"
                                        value="{{ $permission->id }}" id="permission_{{ $permission->id }}"
                                        data-group="{{ $groupKey }}" {{ isset($rolePermissions) && in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                @endif

                                <label class="form-check-label" for="permission_{{ $permission->id }}">
                                    {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
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

@include('admin.roles.partials.script')