@push('styles')
    <style>
        .user-form-grid .select2-container--default .select2-selection--multiple {
            min-height: 44px;
            border: 1px solid #e1e7f0;
            border-radius: 8px;
            background-color: #f9fafb;
            padding: 4px 8px;
        }

        .user-form-grid .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #3b95b7;
            background-color: #fff;
        }

        .user-form-grid .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            padding: 0;
        }

        .user-form-grid .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #3b95b7;
            border: none;
            color: #fff;
            border-radius: 4px;
            padding: 2px 8px;
            margin-top: 4px;
        }

        .user-form-grid .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: rgba(255, 255, 255, 0.7);
            margin-right: 5px;
            border: none;
        }

        .user-form-grid .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #fff;
            background: transparent;
        }

        .user-form-grid .select2-container--default .select2-search--inline .select2-search__field {
            margin-top: 7px;
            font-family: inherit;
            font-size: 0.9rem;
        }
    </style>
@endpush

<div class="row g-4 user-form-grid">
    <div class="mb-4 col-lg-6">
        <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
        <input type="text" name="first_name" placeholder="First Name" class="form-control @error('first_name') is-invalid @enderror" id="first_name"
            value="{{ old('first_name', isset($user) ? $user->first_name : '') }}">
        @error('first_name') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>
    <div class="mb-4 col-lg-6">
        <label for="last_name" class="form-label">Last Name</label>
        <input type="text" name="last_name" placeholder="Last Name" class="form-control @error('last_name') is-invalid @enderror" id="last_name"
            value="{{ old('last_name', isset($user) ? $user->last_name : '') }}">
        @error('last_name') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>
    <div class="mb-4 col-lg-6">
        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
        <input type="email" name="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" id="email"
            value="{{ old('email', isset($user) ? $user->email : '') }}" {{ isset($user->email) ? 'readonly' : '' }}>
        @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>
    <div class="mb-4 col-lg-6">
        <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
        <input type="text" name="phone" placeholder="Phone" class="form-control @error('phone') is-invalid @enderror" id="phone"
            value="{{ old('phone', isset($user) ? $user->phone : '') }}" {{ isset($user->phone) ? 'readonly' : '' }}>
        @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4 col-lg-6">
        <label for="roles" class="form-label">Assign Roles <span class="text-danger">*</span></label>
        <select name="roles[]" id="roles" class="form-select select2 @error('roles') is-invalid @enderror" multiple>
            @foreach($roles as $role)
                <option value="{{ $role->name }}" {{ (is_array(old('roles')) && in_array($role->name, old('roles'))) || (isset($user) && $user->hasRole($role->name) && !old('_token')) ? 'selected' : '' }}>
                    {{ ucfirst($role->name) }}
                </option>
            @endforeach
        </select>
        @error('roles')
            <span class="text-danger small">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-4 col-lg-6">
        <label for="designation" class="form-label">Designation <span class="text-danger">*</span></label>
        <input type="text" name="designation" placeholder="Designation" class="form-control @error('designation') is-invalid @enderror" id="designation"
            value="{{ old('designation', isset($user) ? $user->designation : '') }}">
        @error('designation') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>
    <div class="mb-4 col-lg-6">
        <label for="joining_date" class="form-label">Joining Date <span class="text-danger">*</span></label>
        <input type="text" placeholder="Select joining date" name="joining_date" class="form-control datepicker @error('joining_date') is-invalid @enderror"
            id="joining_date" value="{{ old('joining_date', isset($user) ? $user->joining_date : '') }}"
            autocomplete="off">
        @error('joining_date') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4 col-12">
        <label for="avatar" class="form-label">User Avatar</label>
        <div class="row align-items-center">
            <div class="col-auto">
                <img id="avatar-preview"
                    src="{{ isset($user) ? $user->avatar_url : asset('backend/imgs/theme/avatar-1.png') }}"
                    alt="Avatar Preview" class="rounded-circle border"
                    style="width: 80px; height: 80px; object-fit: cover;">
            </div>
            <div class="col">
                <input type="file" name="avatar" id="avatar" class="form-control @error('avatar') is-invalid @enderror" accept="image/*"
                    onchange="previewImage(this)">
                <p class="text-muted small mt-1 mb-0">Accepted: JPG, PNG, GIF (Max 2MB)</p>
            </div>
        </div>
        @error('avatar') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4 col-12">
        <label class="form-check admin-form-status-toggle mb-0">
            <input class="form-check-input" type="checkbox" name="status" value="1" {{ old('status', isset($user) ? (int) $user->status : 1) ? 'checked' : '' }} style="margin-right: 10px;">
            <span class="form-check-label"> Active Status</span>
        </label>
        <p class="text-muted small mt-2">Activate or deactivate this user account.</p>
    </div>

    @if(!isset($user))
        <div class="col-12">
            <div class="alert alert-info mt-4">
                <i class="material-icons md-info mr-5"></i>
                An autogenerated password will be sent to the user's email address upon creation.
            </div>
        </div>
    @endif

    <div class="col-12 border-top pt-4 mt-4">
        <button type="submit" class="btn btn-primary">
            {{ isset($user) ? 'Update' : 'Save' }}
        </button>
        <a href="{{ route('admin.user.index') }}" class="btn btn-light-secondary ms-2">Cancel</a>
    </div>
</div>

@push('scripts')
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#avatar-preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush