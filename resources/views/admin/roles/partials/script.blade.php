@push('scripts')
    <script>
        $(document).ready(function () {
            if ($('#roles-table').length) {
                var table = $('#roles-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.roles.index') }}",
                    columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'permissions_count',
                        name: 'permissions_count',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                    ],
                    dom: 'lrtip',
                    language: {
                        search: "",
                        searchPlaceholder: "Search role...",
                    }
                });

                $('#custom-search').on('keyup', function () {
                    table.search(this.value).draw();
                });
            }

            // Role form: group permission select-all toggles
            if ($('.role-group-toggle').length && $('.role-permission-checkbox').length) {
                function refreshGroupToggle(groupKey) {
                    var $children = $('.role-permission-checkbox[data-group=\"' + groupKey + '\"]');
                    var $enabledChildren = $children.filter(':not(:disabled)');
                    var enabledTotal = $enabledChildren.length;
                    var enabledChecked = $enabledChildren.filter(':checked').length;

                    // For display state, also consider disabled permissions (e.g. dashboard_access is always checked+disabled).
                    var totalAll = $children.length;
                    var checkedAll = $children.filter(':checked').length;

                    var $toggle = $('.role-group-toggle[data-group=\"' + groupKey + '\"]');
                    if (!$toggle.length) return;

                    // If there's nothing selectable in this group, disable the group toggle,
                    // but still reflect the group's checked state (useful for Dashboard group).
                    if (enabledTotal === 0) {
                        $toggle.prop('disabled', true);
                        $toggle.prop('checked', totalAll > 0 && checkedAll === totalAll);
                        $toggle.prop('indeterminate', checkedAll > 0 && checkedAll < totalAll);
                        return;
                    }

                    $toggle.prop('disabled', false);
                    $toggle.prop('checked', enabledChecked === enabledTotal);
                    $toggle.prop('indeterminate', enabledChecked > 0 && enabledChecked < enabledTotal);
                }

                // initial state
                $('.role-group-toggle').each(function () {
                    refreshGroupToggle($(this).data('group'));
                });

                // toggle children when group checkbox changes
                $(document).on('change', '.role-group-toggle', function () {
                    if ($(this).is(':disabled')) return;
                    var groupKey = $(this).data('group');
                    var isChecked = $(this).is(':checked');

                    $('.role-permission-checkbox[data-group=\"' + groupKey + '\"]')
                        .filter(':not(:disabled)')
                        .prop('checked', isChecked)
                        .trigger('change');
                });

                // update group checkbox when any permission changes
                $(document).on('change', '.role-permission-checkbox', function () {
                    refreshGroupToggle($(this).data('group'));
                });
            }
        });
    </script>
@endpush