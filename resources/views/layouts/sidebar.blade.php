<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ URL::current() }}" class="logo logo-dark">
            <span class="logo-sm">
            <img src="{{ asset('assets/images/company_logos/' . ($company->logo ?? 'LOGOHEAD.PNG')) }}" alt="Company Logo" height="50">
            </span>
            <span class="logo-lg">
            <img src="{{ asset('assets/images/company_logos/' . ($company->logo ?? 'LOGOHEAD.PNG')) }}" alt="Company Logo" height="50">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ URL::current() }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="21">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="las la-house-damage"></i> <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>

                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Pages</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarEmployeeManagement" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebarEmployeeManagement">
                        <i class="las la-user-tie"></i> <span data-key="t-employees">Manage Employees</span>
                    </a>
                    <!-- <div class="collapse menu-dropdown" id="sidebarEmployeeManagement"> -->
                    <div class="collapse menu-dropdown {{ request()->is('employees/list*') || request()->is('employees/list') ? 'show' : '' }}" id="sidebarEmployeeManagement">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('employees.create') }}" class="nav-link" data-key="t-add-employee"> Add Employee </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('employees.index') }}" class="nav-link" data-key="t-employee-list"> Employee List </a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li class="nav-item">
    <a class="nav-link menu-link" href="#sidebarCompanyUser" data-bs-toggle="collapse"
        role="button" aria-expanded="false" aria-controls="sidebarCompanyUser">
        <i class="las la-users"></i> <span data-key="t-company-user">Company User</span>
    </a>
    <div class="collapse menu-dropdown" id="sidebarCompanyUser">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="{{ route('company.users.create') }}" class="nav-link" data-key="t-add-user">Add User</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('company.users.index') }}" class="nav-link" data-key="t-list-users">List Users</a>
            </li>
        </ul>
    </div>
</li>


<li class="nav-item">
    <a class="nav-link menu-link" href="#sidebarAttendance" data-bs-toggle="collapse" role="button"
        aria-expanded="false" aria-controls="sidebarAttendance">
        <i class="las la-calendar-check"></i> <span data-key="t-attendance">Attendance</span>
    </a>
    <div class="collapse menu-dropdown mega-dropdown-menu" id="sidebarAttendance">
        <div class="row">
            <div class="col-lg-12">
                <ul class="nav nav-sm flex-column">
                    <li class="nav-item">
                        <a href="{{ route('attendance.index') }}" class="nav-link" data-key="t-attendance-list">
                            Attendance List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('attendance.create') }}" class="nav-link" data-key="t-add-attendance">
                            Add Attendance
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</li>

             
<li class="nav-item">
    <a class="nav-link menu-link" href="#sidebarSettings" data-bs-toggle="collapse" role="button"
        aria-expanded="false" aria-controls="sidebarSettings">
        <i class="las la-cog"></i> <span data-key="t-settings">Settings</span>
    </a>
    <div class="collapse menu-dropdown" id="sidebarSettings">
        <ul class="nav nav-sm flex-column">
            <!-- Template Master -->
            <li class="nav-item">
                <a href="#sidebarTemplateMaster" class="nav-link" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarTemplateMaster">
                    Template Master
                </a>
                <div class="collapse menu-dropdown" id="sidebarTemplateMaster">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="{{ route('templates.create') }}" class="nav-link" data-key="t-add-template">
                                Add Template
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('templates.index') }}" class="nav-link" data-key="t-list-template">
                                List Templates
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</li>




                

           

            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
