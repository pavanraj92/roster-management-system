<header class="main-header navbar">
    <div class="col-search">
        <!-- <form class="searchform">
            <div class="input-group">
                <input list="search_terms" type="text" class="form-control" placeholder="Search term" />
                <button class="btn btn-light bg" type="button"><i class="material-icons md-search"></i></button>
            </div>
            <datalist id="search_terms">
                <option value="New orders"></option>
                <option value="Apple iphone"></option>
                <option value="Ahmed Hassan"></option>
            </datalist>
        </form> -->
    </div>
    <div class="col-nav">
        <button class="btn btn-icon btn-mobile me-auto" data-trigger="#offcanvas_aside"><i
                class="material-icons md-apps"></i></button>
        <ul class="nav">
            <!-- <li class="nav-item">
                <a class="nav-link btn-icon" href="#">
                    <i class="material-icons md-notifications animation-shake"></i>
                    <span class="badge rounded-pill">3</span>
                </a>
            </li> -->
            <!-- <li class="nav-item">
                <a class="nav-link btn-icon darkmode" href="#"> <i class="material-icons md-nights_stay"></i> </a>
            </li>
            <li class="nav-item">
                <a href="#" class="requestfullscreen nav-link btn-icon"><i class="material-icons md-cast"></i></a>
            </li> -->
            <li class="dropdown nav-item">
                <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" id="dropdownAccount"
                    aria-expanded="false">
                    <img class="img-xs rounded-circle shadow-sm border" src="{{ Auth::user()->avatar_url }}" alt="User Profile" 
                        style="width: 40px; height: 40px; object-fit: cover; background: #fff;" />
                </a>

                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownAccount">

                    <h6 class="dropdown-header">Welcome {{ Auth::user()->name }}!</h6>
                    {{-- <a class="dropdown-item" href="{{ route('admin.profile.index') }}"><i class="material-icons md-perm_identity"></i>Edit Profile</a> --}}
                    <a class="dropdown-item" href="{{ route('admin.profile.index', ['tab' => 'profile']) }}">
                        <i class="material-icons md-perm_identity"></i> Update Profile
                    </a>
                    <a class="dropdown-item" href="{{ route('admin.profile.index', ['tab' => 'password']) }}">
                        <i class="material-icons md-lock"></i> Change Password
                    </a>


                    <!-- <a class="dropdown-item" href="#"><i class="material-icons md-settings"></i>Account Settings</a>
                    <a class="dropdown-item" href="#"><i class="material-icons md-account_balance_wallet"></i>Wallet</a>
                    <a class="dropdown-item" href="#"><i class="material-icons md-receipt"></i>Billing</a>
                    <a class="dropdown-item" href="#"><i class="material-icons md-help_outline"></i>Help center</a>
                    <div class="dropdown-divider"></div> -->
                    <div class="dropdown-divider"></div>
                    {{-- <a class="dropdown-item text-danger" href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="material-icons md-exit_to_app"></i>Logout
                    </a> --}}

                      <a class="dropdown-item text-danger" href="javascript:void();"
                            onclick="event.preventDefault(); handleLogout();"><i class="material-icons md-exit_to_app"></i>Logout</a>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
</header>

<script>
    function handleLogout() {
        Swal.fire({
            html: `
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/zpxybbhl.json" trigger="loop"
                        colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-2 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you sure?</h4>
                        <p class="text-muted mx-4 mb-0">You will be logged out of your account.</p>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Yes, logout!',
            cancelButtonText: 'Cancel',
            customClass: {
                confirmButton: 'btn btn-primary w-xs me-2 mt-2',
                cancelButton: 'btn btn-danger w-xs mt-2',
            },
            buttonsStyling: false,
            showCloseButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>
