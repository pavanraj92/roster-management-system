<table class="table table-bordered" id="roster-table">
    <thead>
        <tr>
            <th>Members</th>
            @foreach ($dates as $date)
                <th>{{ $date->format('D d') }}</th>
            @endforeach
        </tr>
    </thead>

    <tbody>
        @foreach ($users as $user)
            <tr>
                <td class="staffname">{{ $user->name }}</td>
                @foreach ($dates as $date)
                    <td>
                        @if (isset($rosters[$user->id][$date->toDateString()]))
                            @foreach ($rosters[$user->id][$date->toDateString()] as $item)
                                <div class="roster-text"
                                    style="background: {{ $item->shift->color }}">
                                    <span>Shift:</span> {{ $item->shift->name }} <br>
                                    <span>Task:</span> {{ $item->task->title }}
                                </div>
                            @endforeach
                        @else
                            @if(auth()->user()->hasRole(['Admin']))
                                <button
                                    class="btn btn-sm btn-primary assign-shift-btn"
                                    onclick="openModal({{ $user->id }},'{{ $date->toDateString() }}')"
                                > + </button>
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
