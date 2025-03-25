<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Bootstrap (optional) -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 d-flex">
            <!-- Sidebar on the left -->
            <nav class="bg-dark text-white p-3" style="min-width: 250px;">
                @include('layouts.sidebar')  <!-- Or 'layouts.navigation' if that's your sidebar file -->
            </nav>

            <!-- Main content on the right -->
            <div class="flex-fill p-4">
                <!-- ✅ Role-Based Welcome Message -->
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

        <!-- JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
