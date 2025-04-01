<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="{{ URL::current() }}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="21">
                        </span>
                    </a>

                    <a href="{{ URL::current() }}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="21">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                    id="topnav-hamburger-icon">
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
                <form method="GET" action="{{ route('switch.company') }}">
    <label for="companySelect">Switch Company</label>
    <select name="company_id" id="companySelect" onchange="this.form.submit()">
        @foreach($companies as $company)
            <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                {{ $company->company_name }}
            </option>
        @endforeach
    </select>
</form>
                </div>
              

                <!-- 🔹 Profile Dropdown -->
                <div class="dropdown header-item">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="{{ asset('logo.png') }}" alt="User Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block fw-medium user-name-text fs-16">
                                   
                                    {{ Auth::user()->name ?? 'Guest' }}
                                    <i class="las la-angle-down fs-12 ms-1"></i>
                                </span>
                            </span>
                        </span>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- Profile link -->
                        <a class="dropdown-item" href="#"><i class="bx bx-user fs-15 align-middle me-1"></i> Profile</a>

                        <div class="dropdown-divider"></div>

                        <!-- 🔹 Add Company Option -->
                        <a class="dropdown-item" href="{{ route('companies.create') }}">
                            <i class="bx bx-plus fs-15 align-middle me-1"></i> Add Company
                        </a>

                        <!-- 🔹 List Companies -->
                        <a class="dropdown-item" href="{{ route('companies.index') }}">
                            <i class="bx bx-list-ul fs-15 align-middle me-1"></i> List Companies
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
                </div>

            </div>
        </div>
    </div>
</header>
