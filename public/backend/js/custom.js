$(document).ready(function () {
    // ensure any lingering offcanvas overlay is removed on load (prevents blocking inputs)
    if ($('.screen-overlay').hasClass('show')) {
        $('.screen-overlay').removeClass('show');
        $('body').removeClass('offcanvas-active');
        $('.mobile-offcanvas, .navbar-aside').removeClass('show');
    }

    // also clear overlay if the user clicks anywhere; this guards against
    // stray overlays that show up unexpectedly and cover form buttons
    $(document).on('click', function () {
        if ($('.screen-overlay').hasClass('show')) {
            $('.screen-overlay').removeClass('show');
            $('body').removeClass('offcanvas-active');
            $('.mobile-offcanvas, .navbar-aside').removeClass('show');
        }
    });

    // Common Status Toggle with SweetAlert Confirmation
    $(document).on('change', '.toggle-status', function () {
        var $this = $(this);
        var url = $this.data('url');
        var isChecked = $this.prop('checked');
        var statusText = isChecked ? 'active' : 'inactive';

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you really want to " + statusText + " this?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3b95b7',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!',
            cancelButtonText: 'No, cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (response) {
                        if (response.success) {
                            if (window.adminToast) {
                                window.adminToast('success', 'Status updated successfully');
                            }
                        } else {
                            $this.prop('checked', !isChecked);
                            if (window.adminToast) {
                                window.adminToast('error', response.message || 'Something went wrong');
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: response.message || 'Something went wrong',
                                });
                            }
                        }
                    },
                    error: function (xhr) {
                        $this.prop('checked', !isChecked);
                        if (window.adminToast) {
                            window.adminToast('error', 'Something went wrong while updating status.');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Something went wrong while updating status.',
                            });
                        }
                    }
                });
            } else {
                // Revert the checkbox state if canceled
                $this.prop('checked', !isChecked);
            }
        });
    });

    // Common Delete Confirmation with AJAX
    $(document).on('submit', '.delete-form', function (e) {
        e.preventDefault();
        var $form = $(this);
        var url = $form.attr('action');
        var moduleName = $form.data('module') || 'Item';

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3b95b7',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: $form.serialize(),
                    success: function (response) {
                        if (response.success) {
                            // Find the datatable and redraw
                            var tableId = $form.closest('table').attr('id');
                            if (tableId) {
                                $('#' + tableId).DataTable().ajax.reload(null, false);
                            } else {
                                // Fallback: find any datatable on the page
                                $('.dataTable').DataTable().ajax.reload(null, false);
                            }

                            if (window.adminToast) {
                                window.adminToast('success', moduleName + ' deleted successfully');
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message || 'Something went wrong while deleting.',
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Something went wrong while deleting.',
                        });
                    }
                });
            }
        });
    });
});
