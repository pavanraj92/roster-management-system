(function(window, $) {
    'use strict';

    if (!window || !$) {
        return;
    }

    const cfg = window.rosterPageConfig || {};
    let currentStart = cfg.currentStart || '';
    let currentEnd = cfg.currentEnd || '';
    const isAdminUser = Boolean(cfg.isAdminUser);

    const selectors = {
        weekPicker: '#weekPicker',
        tableContainer: '#roster-table-container',
        assignModal: '#assignModal',
        shiftDetailModal: '#shiftDetailModal',
        shiftForm: '#shiftForm',
        assignTask: '#assign-task',
        userId: '#user_id',
        date: '#date',
        detailShiftName: '#detail-shift-name',
        detailShiftTime: '#detail-shift-time',
        detailTaskTitle: '#detail-task-title',
        detailTaskDescription: '#detail-task-description',
        shiftDetailView: '#shift-detail-view',
        shiftEditFormContainer: '#shift-edit-form-container',
        shiftDetailLabel: '#shiftDetailModalLabel',
        editBtn: '#shift-detail-edit-btn',
        saveEditBtn: '#save-shift-edit-btn',
        editRosterId: '#edit-roster-id',
        editUser: '#edit-user',
        editDate: '#edit-date',
        editShift: '#edit-shift',
        editTask: '#edit-task',
        clockInForm: '#clock-in-form',
        clockOutForm: '#clock-out-form',
        clockInRosterId: '#clock-in-roster-id',
        clockOutAttendanceId: '#clock-out-attendance-id'
    };

    function initTaskSelect2() {
        $('.task-selection').each(function() {
            const $el = $(this);
            if ($el.hasClass('select2-hidden-accessible')) {
                return;
            }

            $el.select2({
                placeholder: 'Select tasks',
                allowClear: true,
                width: '100%',
                dropdownParent: $el.closest('.modal')
            });
        });
    }

    function showTableLoader() {
        $(selectors.tableContainer).html(
            '<div id="table-loader" style="height:150px;align-items:center;display:flex;justify-content:center;border:2px solid gray;"><div class="spinner-border text-primary"></div></div>'
        );
    }

    function loadRoster(startDate) {
        $(selectors.weekPicker).val(startDate);
        currentStart = startDate;

        showTableLoader();

        $.ajax({
            url: cfg.rosterUrl,
            data: {
                start: startDate
            },
            success: function(res) {
                $(selectors.tableContainer).html(res);
                bindShiftDetailClicks();
            }
        });
    }

    function resetClockForms() {
        $(selectors.clockInForm).addClass('d-none');
        $(selectors.clockOutForm).addClass('d-none');
        $(selectors.clockInRosterId).val('');
        $(selectors.clockOutAttendanceId).val('');
    }

    function bindShiftDetailClicks() {
        $(document).off('click.rosterShiftDetail', '.roster-shift-detail-trigger');
        $(document).on('click.rosterShiftDetail', '.roster-shift-detail-trigger', function() {
            const $row = $(this);
            const shiftName = $row.data('shift-name');
            const shiftStart = $row.data('shift-start');
            const shiftEnd = $row.data('shift-end');
            const taskTitle = $row.data('task-title');
            const taskDescription = $row.data('task-description') || '';
            const rosterId = $row.data('roster-id');
            const userId = $row.data('user-id');
            const date = $row.data('date');
            const shiftId = $row.data('shift-id');
            const taskId = $row.data('task-id');
            const attendanceId = $row.data('attendance-id');
            const hasClockIn = Number($row.data('clocked-in')) === 1;
            const hasClockOut = Number($row.data('clocked-out')) === 1;
            const taskIdsRaw = ($row.data('task-ids') || '').toString();
            const taskIds = taskIdsRaw
                .split(',')
                .map(function(id) {
                    return id.trim();
                })
                .filter(Boolean);
            const isTodayShift = window.moment(date).isSame(window.moment(), 'day');

            $(selectors.detailShiftName).text(shiftName);
            $(selectors.detailShiftTime).text(shiftStart + ' - ' + shiftEnd);
            $(selectors.detailTaskTitle).text(taskTitle);
            $(selectors.detailTaskDescription).text(taskDescription || 'No description available.');

            $(selectors.shiftDetailView).removeClass('d-none');
            $(selectors.shiftEditFormContainer).addClass('d-none');
            $(selectors.shiftDetailLabel).text('Shift & Task Details');
            $(selectors.editBtn).removeClass('d-none');
            $(selectors.saveEditBtn).addClass('d-none');

            $(selectors.editRosterId).val(rosterId);
            $(selectors.editUser).val(userId);
            $(selectors.editDate).val(date);
            $(selectors.editShift).val(shiftId);
            $(selectors.editTask).val(taskIds.length ? taskIds : [taskId]).trigger('change');

            resetClockForms();

            if (!isAdminUser && isTodayShift) {
                if (hasClockIn && !hasClockOut && attendanceId) {
                    $(selectors.clockOutForm).removeClass('d-none');
                    $(selectors.clockOutAttendanceId).val(attendanceId);
                } else if (!hasClockIn) {
                    $(selectors.clockInForm).removeClass('d-none');
                    $(selectors.clockInRosterId).val(rosterId);
                }
            }

            $(selectors.shiftDetailModal).modal('show');
        });
    }

    function bindEvents() {
        $('#nextWeek').on('click', function() {
            const start = window.moment(currentStart)
                .add(7, 'days')
                .format('YYYY-MM-DD');
            loadRoster(start);
        });

        $('#prevWeek').on('click', function() {
            const start = window.moment(currentStart)
                .subtract(7, 'days')
                .format('YYYY-MM-DD');
            loadRoster(start);
        });

        $(selectors.shiftForm).on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: cfg.storeUrl,
                type: 'POST',
                data: $(this).serialize(),
                success: function() {
                    $(selectors.assignModal).modal('hide');
                    $(selectors.shiftForm)[0].reset();
                    $(selectors.assignTask).val(null).trigger('change');
                    loadRoster(currentStart, currentEnd);
                }
            });
        });

        $(selectors.editBtn).on('click', function() {
            $(selectors.shiftDetailView).addClass('d-none');
            $(selectors.shiftEditFormContainer).removeClass('d-none');
            $(selectors.shiftDetailLabel).text('Edit Shift & Task Assignment');
            $(selectors.editBtn).addClass('d-none');
            $(selectors.saveEditBtn).removeClass('d-none');

            const editDateEl = document.querySelector(selectors.editDate);
            if (window.flatpickr && editDateEl && !editDateEl.dataset.flatpickrInitialized) {
                window.flatpickr(selectors.editDate, {
                    dateFormat: 'Y-m-d'
                });
                editDateEl.dataset.flatpickrInitialized = '1';
            }
        });

        $(selectors.saveEditBtn).on('click', function() {
            const rosterId = $(selectors.editRosterId).val();
            const payload = {
                _token: cfg.csrfToken,
                user_id: $(selectors.editUser).val(),
                date: $(selectors.editDate).val(),
                shift_id: $(selectors.editShift).val(),
                task_ids: $(selectors.editTask).val()
            };

            const updateUrl = cfg.updateUrlTemplate.replace('ROSTER_ID_PLACEHOLDER', rosterId);

            $.ajax({
                url: updateUrl,
                type: 'PUT',
                data: payload,
                success: function() {
                    $(selectors.shiftDetailModal).modal('hide');
                    loadRoster(currentStart, currentEnd);
                }
            });
        });

        $(selectors.clockOutForm).on('submit', function(e) {
            e.preventDefault();

            const attendanceId = $(selectors.clockOutAttendanceId).val();
            if (!attendanceId) {
                window.Swal.fire('No attendance found for clock out.');
                return;
            }

            const payload = {
                _token: cfg.csrfToken,
                attendance_id: attendanceId
            };

            window.Swal.fire({
                title: 'Clock Out?',
                text: 'Are you sure you want to clock out?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Clock Out'
            }).then(function(result) {
                if (!result.isConfirmed) {
                    return;
                }

                $.ajax({
                    url: cfg.clockOutUrl,
                    type: 'POST',
                    data: payload,
                    success: function(res) {
                        if (res.status) {
                            loadRoster(currentStart, currentEnd);
                        } else {
                            window.Swal.fire(res.message);
                        }
                    }
                });
            });
        });

        $(selectors.clockInForm).on('submit', function(e) {
            e.preventDefault();

            const rosterId = $(selectors.clockInRosterId).val();
            if (!rosterId) {
                window.Swal.fire('Select a valid shift to clock in.');
                return;
            }

            const payload = {
                _token: cfg.csrfToken,
                roster_id: rosterId
            };

            $.ajax({
                url: cfg.clockInUrl,
                type: 'POST',
                data: payload,
                success: function(res) {
                    if (res.status) {
                        loadRoster(currentStart, currentEnd);
                    } else {
                        window.Swal.fire(res.message);
                    }
                }
            });
        });
    }

    function initDatePicker() {
        if (!window.flatpickr) {
            return;
        }

        window.flatpickr(selectors.weekPicker, {
            dateFormat: 'Y-m-d',
            defaultDate: currentStart,
            allowInput: false,
            onChange: function(selectedDates, dateStr) {
                loadRoster(dateStr);
            }
        });
    }

    window.openModal = function(userId, date) {
        $(selectors.userId).val(userId);
        $(selectors.date).val(date);
        $(selectors.assignTask).val(null).trigger('change');
        $(selectors.assignModal).modal('show');
    };

    $(function() {
        if (!cfg.rosterUrl) {
            return;
        }

        initTaskSelect2();
        initDatePicker();
        bindShiftDetailClicks();
        bindEvents();
    });
})(window, window.jQuery);
