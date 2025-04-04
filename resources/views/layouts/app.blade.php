<!DOCTYPE html>

@include('components.profile-dropdown')

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

    <!-- Include List.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>

   
    <!-- Vite (CSS & JS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 d-flex">
        <!-- Sidebar -->
        <nav class="bg-dark text-white p-3" style="min-width: 250px;">
            @include('layouts.sidebar')
        </nav>

        <!-- Main Content -->
        <div class="flex-fill p-4">
            <!-- Role-Based Welcome Message -->
            @if(auth()->check())
                <div class="max-w-7xl mx-auto p-4 text-center text-white bg-blue-600 mb-4">
                    @if(auth()->user()->hasRole('Super Admin'))
                        <p>Welcome, Super Admin!</p>
                    @elseif(auth()->user()->hasRole('Company Admin'))
                        <p>Welcome, Company Admin!</p>
                    @elseif(auth()->user()->hasRole('HR Admin'))
                        <p>Welcome, HR Admin!</p>
                    @endif
                </div>
            @endif

            <!-- Company Switch -->
            @isset($companies)
                <nav>
                    <form action="{{ route('switch.company') }}" method="POST">
                        @csrf
                        <select name="company_id" onchange="this.form.submit()">
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}" {{ session('selected_company_id', auth()->user()->company_id) == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </nav>
            @endisset

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow mb-4">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    <script src="{{ asset('assets/js/listjs.init.js') }}"></script>
    <script src="{{ asset('assets/js/jsvectormap.min.js') }}"></script>

    <

    <!-- ✅ Page-Specific Scripts -->
    @yield('scripts')

</body>
</html>
