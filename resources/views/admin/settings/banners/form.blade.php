<div class="row g-4 banner-form-grid">
    <div class="col-lg-7">
        <div class="mb-4">
            <label for="title" class="form-label">Banner Title</label>
            <input type="text" name="title" placeholder="Type here" class="form-control" id="title"
                value="{{ old('title', isset($banner) ? $banner->title : '') }}">
            @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label for="sub_title" class="form-label">Banner Sub Title</label>
            <input type="text" name="sub_title" placeholder="Type sub title here" class="form-control" id="sub_title"
                value="{{ old('sub_title', isset($banner) ? $banner->sub_title : '') }}">
            @error('sub_title') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

    </div>
    <div class="col-lg-5">
        <div class="mb-3">
            <label class="form-label">Image</label>
            <div class="input-upload">
                <img src="{{ isset($banner) && $banner->image ? asset('storage/' . $banner->image) : asset('backend/imgs/theme/upload.svg') }}"
                    alt="Banner image preview" id="image-preview" class="admin-form-image-preview">
                <input class="form-control" type="file" name="image" id="image-input">
            </div>
            @error('image') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4 d-flex">
            <label class="form-check admin-form-status-toggle mb-0 me-4">
                <input class="form-check-input" type="checkbox" name="status" value="1" {{ old('status', isset($banner) ? (int) $banner->status : 1) ? 'checked' : '' }}>
                <span class="form-check-label">Active Status</span>
            </label>
            <label class="form-check admin-form-status-toggle mb-0 me-4">
                <input class="form-check-input" type="checkbox" name="is_sub_banner" value="1" {{ old('is_sub_banner', isset($banner) ? (int) $banner->is_sub_banner : 0) ? 'checked' : '' }}>
                <span class="form-check-label">Sub Banner</span>
            </label>
            <label class="form-check admin-form-status-toggle mb-0">
                <input class="form-check-input" type="checkbox" name="is_single_banner" value="1" {{ old('is_single_banner', isset($banner) ? (int) $banner->is_single_banner : 0) ? 'checked' : '' }}>
                <span class="form-check-label">Single Banner</span>
            </label>
        </div>
    </div>

    <div class="col-12 border-top pt-4 mt-4">
        <button type="submit" class="btn btn-primary">
            {{ isset($banner) ? 'Update Banner' : 'Create Banner' }}
        </button>
        <a href="{{ route('admin.settings.banners.index') }}" class="btn btn-light-secondary ms-2">Cancel</a>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#image-input').on('change', function (evt) {
                const [file] = evt.target.files
                if (file) {
                    $('#image-preview').attr('src', URL.createObjectURL(file))
                }
            });


        });
    </script>
@endpush