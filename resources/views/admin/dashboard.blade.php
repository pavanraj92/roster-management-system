@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<section class="content-main">

    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Dashboard</h2>
            <p>Roster management overview</p>
        </div>
    </div>

    <div class="row">
        {{-- Total Users --}}
        <div class="col-lg-3 col-md-6">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-primary-light">
                        <i class="text-primary material-icons md-groups"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Total Users</h6>
                        <span>{{ $totalUsersCount }}</span>
                    </div>
                </article>
            </div>
        </div>

        {{-- Total Managers --}}
        <div class="col-lg-3 col-md-6">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-primary-light">
                        <i class="text-primary material-icons md-groups"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Total Managers</h6>
                        <span>{{ $managersCount }}</span>
                    </div>
                </article>
            </div>
        </div>


        {{-- Active Managers --}}
        <div class="col-lg-3 col-md-6">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-success-light">
                        <i class="text-success material-icons md-person"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Active managers</h6>
                        <span>{{ $activeManagersCount }}</span>
                    </div>
                </article>
            </div>
        </div>

        {{-- Inactive Managers --}}
        <div class="col-lg-3 col-md-6">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-danger-light">
                        <i class="text-danger material-icons md-person"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Inactive managers</h6>
                        <span>{{ $inactiveManagersCount }}</span>
                    </div>
                </article>
            </div>
        </div>

        {{-- Total Staff --}}
        <div class="col-lg-3 col-md-6">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-primary-light">
                        <i class="text-primary material-icons md-groups"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Total Staff</h6>
                        <span>{{ $staffsCount }}</span>
                    </div>
                </article>
            </div>
        </div>

        {{-- Active Staff --}}
        <div class="col-lg-3 col-md-6">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-success-light">
                        <i class="text-success material-icons md-person"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Active Staff</h6>
                        <span>{{ $activeStaffsCount }}</span>
                    </div>
                </article>
            </div>
        </div>

        {{-- Inactive Staff --}}
        <div class="col-lg-3 col-md-6">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-danger-light">
                        <i class="text-danger material-icons md-person"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Inactive Staff</h6>
                        <span>{{ $inactiveStaffsCount }}</span>
                    </div>
                </article>
            </div>
        </div>


        {{-- Total Shifts --}}
        <div class="col-lg-3 col-md-6">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-info-light">
                        <i class="text-info material-icons md-access_time"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Total Shifts</h6>
                        <span>{{ $totalShifts }}</span>
                    </div>
                </article>
            </div>
        </div>

        {{-- Present Today --}}
        <div class="col-lg-3 col-md-6">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-success-light">
                        <i class="text-success material-icons md-check_circle"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Present Today</h6>
                        <span>{{ $presentToday }}</span>
                    </div>
                </article>
            </div>
        </div>

        {{-- Absent Today --}}
        <div class="col-lg-3 col-md-6">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-danger-light">
                        <i class="text-danger material-icons md-cancel"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Absent Today</h6>
                        <span>{{ $absentToday }}</span>
                    </div>
                </article>
            </div>
        </div>

        {{-- Late Today --}}
        <div class="col-lg-3 col-md-6">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-warning-light">
                        <i class="text-warning material-icons md-access_time"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Late Today</h6>
                        <span>{{ $lateToday }}</span>
                    </div>
                </article>
            </div>
        </div>

    </div>

    {{-- Latest Users --}}
    <div class="row">
        <div class="col-lg-6">

            <div class="card mb-4">
                <article class="card-body">
                    <h5 class="card-title">Latest Users</h5>
                    <div class="new-member-list">

                        @foreach($latestUsers as $user)
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <img src="{{ $user->image ? asset('storage/'.$user->image) : asset('backend/imgs/people/avatar-1.png') }}"
                                    class="avatar me-3" width="40" height="40">
                                <div>
                                    <h6 class="mb-0">{{ $user->name }}</h6>
                                    <p class="text-muted font-xs">{{ $user->email }}</p>
                                </div>
                            </div>
                            <a href="#" class="btn btn-xs btn-primary">View</a>
                        </div>
                        @endforeach

                    </div>
                </article>
            </div>

        </div>

        {{-- System Summary --}}
        <div class="col-lg-6">

            <div class="card mb-4">
                <article class="card-body">
                    <h5 class="card-title">System Summary</h5>
                    <ul class="list-group list-group-flush">

                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total Users</span>
                            <strong>{{ $totalUsersCount }}</strong>
                        </li>

                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total Staff</span>
                            <strong>{{ $staffsCount }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Active Staff</span>
                            <strong>{{ $activeStaffsCount }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Inactive Staff</span>
                            <strong>{{ $inactiveStaffsCount }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total Shifts</span>
                            <strong>{{ $totalShifts }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Present Today</span>
                            <strong>{{ $presentToday }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Absent Today</span>
                            <strong>{{ $absentToday }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Late Today</span>
                            <strong>{{ $lateToday }}</strong>
                        </li>

                    </ul>
                </article>
            </div>

        </div>
    </div>

</section>

@endsection