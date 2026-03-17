<table class="table table-bordered roster-table" id="roster-table">
    <thead>
        <tr>
            <th class="roster-table__header roster-table__header--members">Members</th>
            @foreach ($dates as $date)
                <th class="roster-table__header roster-date-header text-center">
                    <span class="roster-date-header__day">{{ $date->format('l') }}</span>
                    <span class="roster-date-header__date">{{ $date->format('d') }}</span>
                </th>
            @endforeach
        </tr>
    </thead>

    <tbody>
        @foreach ($users as $user)
            <tr>
                <td class="staffname">{{ $user->name }}</td>
                @php
                    $canAssign = auth()->user()->can('assign_roster');
                @endphp
                @foreach ($dates as $date)
                    <td>
                        @if (isset($rosters[$user->id][$date->toDateString()]))
                            @php
                                $shiftGroups = $rosters[$user->id][$date->toDateString()]->groupBy('shift_id');
                            @endphp
                            @foreach ($shiftGroups as $shiftItems)
                                @php
                                    $item = $shiftItems->first();
                                    $attendance = $attendancesByRoster[$item->id] ?? null;
                                    $groupTaskIds = $shiftItems->pluck('task_id')->unique()->values()->implode(',');
                                    $groupTaskTitles = $shiftItems
                                        ->pluck('task.title')
                                        ->filter()
                                        ->unique()
                                        ->values()
                                        ->implode(', ');
                                    $groupTaskDescriptions = $shiftItems
                                        ->filter(fn($row) => !empty($row->task?->description))
                                        ->map(fn($row) => $row->task->title . ': ' . $row->task->description)
                                        ->unique()
                                        ->values()
                                        ->implode(' | ');
                                @endphp

                                <div class="roster-text roster-shift-detail-trigger"
                                    style="background: {{ $item->shift->color }}; cursor: pointer;"
                                    data-roster-id="{{ $item->id }}" data-user-id="{{ $item->user_id }}"
                                    data-date="{{ $date->toDateString() }}" data-shift-id="{{ $item->shift_id }}"
                                    data-shift-name="{{ $item->shift->name }}"
                                    data-shift-start="{{ \Carbon\Carbon::parse($item->shift->start_time)->format('H:i') }}"
                                    data-shift-end="{{ \Carbon\Carbon::parse($item->shift->end_time)->format('H:i') }}"
                                    data-task-id="{{ $item->task_id }}" data-task-ids="{{ $groupTaskIds }}"
                                    data-attendance-id="{{ $attendance?->id }}"
                                    data-clocked-in="{{ $attendance && $attendance->clock_in ? 1 : 0 }}"
                                    data-clocked-out="{{ $attendance && $attendance->clock_out ? 1 : 0 }}"
                                    data-task-title="{{ $groupTaskTitles }}"
                                    data-task-description="{{ $groupTaskDescriptions }}"  
                                    data-auth-id = "{{ auth()->id() }}">
                                    <span>Shift:</span> {{ $item->shift->name }} <br>
                                    <span>Task:</span> {{ $groupTaskTitles }}
                                    <br>
                                    <div style="display: flex; margin-top: 5px; align-items: center;">
                                        @if($attendance && $attendance->shift_status === 'running')
                                            <div class="shift-indication running"></div>
                                            <small>Running</small>
                                        @elseif($attendance && $attendance->shift_status === 'completed')
                                            <div class="shift-indication completed"></div>
                                            <small>Completed</small>
                                        @else
                                            <div class="shift-indication not-started"></div>
                                            <small>Pending</small>
                                        @endif
                                    </div>
                                    <br>
                                </div>
                            @endforeach
                        @else
                            @if (today()->lte($date) && $canAssign)
                            <div>
                                <button type="button" class="btn btn-sm assign-shift-btn"
                                    onclick="openModal({{ $user->id }},'{{ $date->toDateString() }}')"
                                    aria-label="Assign shift for {{ $user->name }} on {{ $date->toFormattedDateString() }}">
                                    <span class="material-icons md-add"></span>
                                    <span class="assign-shift-btn__label">Assign</span>
                                </button>
                            </div>
                            @else
                                <p style="text-align: center">-</p>
                            @endif
                        @endif
                </td>
            @endforeach
        </tr>
    @endforeach
</tbody>
</table>
