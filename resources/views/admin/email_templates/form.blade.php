<div class="row g-4 page-form-grid">

    <div class="col-lg-8">

        {{-- Template Name --}}
        <div class="mb-4">
            <label class="form-label">Template Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter template name"
                value="{{ old('name', $email_template->name ?? '') }}">
            @error('name')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>

        {{-- Subject --}}
        <div class="mb-4">
            <label class="form-label">Email Subject <span class="text-danger">*</span></label>
            <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" placeholder="Enter email subject"
                value="{{ old('subject', $email_template->subject ?? '') }}">
            @error('subject')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>


        {{-- Status --}}
        <div class="mb-4">
            <label class="form-check">
                <input type="checkbox" name="status" value="1" class="form-check-input"
                    {{ old('status', $email_template->status ?? 1) ? 'checked' : '' }}>
                <span class="form-check-label">Active Status</span>
            </label>
        </div>

    </div>

    <div class="col-lg-4">

        {{-- Help Card --}}
        <div class="card p-3 mb-4">
            <h5 class="mb-3">Available Variables</h5>

            <p class="small text-muted mb-2">
                You can use these dynamic variables in email body:
            </p>

            <ul class="small mb-0">
                <li><code>@{{name}}</code></li>
                <li><code>@{{email}}</code></li>
                <li><code>@{{password}}</code></li>
                <li><code>@{{otp}}</code></li>
                <li><code>@{{date}}</code></li>
                <li><code>@{{company}}</code></li>
            </ul>
        </div>
    </div>

    <div class="col-lg-12">
        {{-- Email Body --}}
        <div class="mb-4">
            <label class="form-label">Email Body <span class="text-danger">*</span></label>
            <textarea name="description" id="description" rows="8" class="form-control @error('description') is-invalid @enderror"
                placeholder="Write email template...">{{ old('description', $email_template->description ?? '') }}</textarea>
            @error('description')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>
    </div>

    {{-- Buttons --}}
    <div class="col-12 border-top pt-4 mt-4">
        <button type="submit" class="btn btn-primary">
            {{ isset($email_template) ? 'Update' : 'Save' }}
        </button>
        <a href="{{ route('admin.email-templates.index') }}" class="btn btn-light">Cancel</a>
    </div>

</div>

@push('scripts')
<script>
    $(document).ready(function() {
        initAdminCkEditors('#description');
    });
</script>
@endpush