<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- Hamburger Menu Button -->
                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
            </div>

            <div class="d-flex align-items-center">
                <!-- 🔹 Company Switcher Form -->
                <div class="ms-1 header-item d-none d-sm-flex">
                <form method="POST" action="{{ route('switch.company') }}">
                    @csrf
                    <select name="company_id" onchange="this.form.submit()">
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ $selectedCompanyId == $company->id ? 'selected' : '' }}>
                                {{ $company->company_name }}
                            </option>
                        @endforeach
                    </select>
                </form>



                </div>

                <!-- 🔹 User Profile Dropdown -->
                <div class="dropdown header-item">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" 
                            aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" 
                                 src="{{ Auth::user() && Auth::user()->profileImage ? asset('storage/' . Auth::user()->profileImage->path) : url('assets/images/users/avatar-4.jpg') }}"
                                 alt="User Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block fw-medium user-name-text fs-16">
                                    {{ Auth::user()->name ?? 'Guest' }}
                                    <i class="las la-angle-down fs-12 ms-1"></i>
                                </span>
                            </span>
                        </span>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- User Info Section -->
                        <div class="dropdown-item text-center">
                            <img class="rounded-circle" 
                                 src="{{ Auth::user() && Auth::user()->profileImage ? asset('storage/' . Auth::user()->profileImage->path) : url('assets/images/users/avatar-4.jpg') }}" 
                                 alt="User Avatar" width="50" height="50">
                            <p class="fw-bold mt-2 mb-0">{{ Auth::user()->name ?? 'Guest' }}</p>
                            <p class="text-muted small">{{ Auth::user()->email ?? 'No Email' }}</p>
                        </div>

                        <div class="dropdown-divider"></div>

                        <!-- Profile link -->
                        <a class="dropdown-item" href="#"><i class="bx bx-user fs-15 align-middle me-1"></i> Profile</a>
                        
                        <div class="dropdown-divider"></div>

                        <!-- 🔹 Company Management -->
                        <a class="dropdown-item" href="{{ route('companies.create') }}">
                            <i class="bx bx-plus fs-15 align-middle me-1"></i> Add Company
                        </a>
                        <a class="dropdown-item" href="{{ route('companies.index') }}">
                            <i class="bx bx-list-ul fs-15 align-middle me-1"></i> List Companies
                        </a>

                        <div class="dropdown-divider"></div>

                        <!-- Change Password Button (Triggers Modal) -->
                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            <i class="bx bx-key fs-15 align-middle me-1"></i> Change Password
                        </a>

                        <div class="dropdown-divider"></div>

                        <!-- Logout Button -->
                        <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item text-danger">
                                <i class="bx bx-power-off fs-15 align-middle me-1 text-danger"></i> Logout
                            </button>
                        </form>
                    </div>
                </div> <!-- End Profile Dropdown -->
            </div> <!-- End d-flex align-items-center -->
        </div> <!-- End navbar-header -->
    </div> <!-- End layout-width -->
</header>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                @include('auth.change-password')
            </div>
        </div>
    </div>
</div>
*,./11,/////////////