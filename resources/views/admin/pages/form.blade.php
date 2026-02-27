<div class="row g-4 page-form-grid">

    <div class="col-lg-8">

        {{-- Title --}}
        <div class="mb-4">
            <label class="form-label">Page Title</label>
            <input type="text" name="title" class="form-control" placeholder="Enter page title"
                value="{{ old('title', $page->title ?? '') }}">
            @error('title')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>

        {{-- Subtitle --}}
        <div class="mb-4">
            <label class="form-label">Subtitle</label>
            <input type="text" name="subtitle" class="form-control" placeholder="Enter subtitle"
                value="{{ old('subtitle', $page->subtitle ?? '') }}">
            @error('subtitle')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>

        {{-- Short Description --}}
        <div class="mb-4">
            <label class="form-label">Short Description</label>
            <textarea name="short_description" rows="3" class="form-control" placeholder="Enter short description">{{ old('short_description', $page->short_description ?? '') }}</textarea>
            @error('short_description')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>

        {{-- Status --}}
        <div class="mb-4">
            <label class="form-check">
                <input type="checkbox" name="status" value="1" class="form-check-input"
                    {{ old('status', $page->status ?? 1) ? 'checked' : '' }}>
                <span class="form-check-label">Active Status</span>
            </label>
        </div>
    </div>

    <div class="col-lg-4">

        {{-- SEO Section --}}
        <div class="card p-3 mb-4">
            <h5 class="mb-3">SEO Settings</h5>

            <div class="mb-3">
                <label class="form-label">Meta Title</label>
                <input type="text" name="meta_title" class="form-control"
                    value="{{ old('meta_title', $page->meta_title ?? '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Meta Keyword</label>
                <input type="text" name="meta_keyword" class="form-control"
                    value="{{ old('meta_keyword', $page->meta_keyword ?? '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Meta Description</label>
                <textarea name="meta_description" rows="3" class="form-control">{{ old('meta_description', $page->meta_description ?? '') }}</textarea>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        {{-- Full Description (CKEditor) --}}
        <div class="mb-4">
            <label class="form-label">Full Description</label>
            <textarea name="description" id="description" rows="6" class="form-control" placeholder="Enter full description">{{ old('description', $page->description ?? '') }}</textarea>
            @error('description')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>
    </div>

    {{-- Buttons --}}
    <div class="col-12 border-top pt-4 mt-4">
        <button type="submit" class="btn btn-primary">
            {{ isset($page) ? 'Update Page' : 'Create Page' }}
        </button>
        <a href="{{ route('admin.pages.index') }}" class="btn btn-light">Cancel</a>
    </div>

</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            initAdminCkEditors('#description');
        });
    </script>
@endpush
