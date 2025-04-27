<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                },
            },
        }
    </script>

    <link rel="icon" href="{{ asset('images/logo.jfif') }}">
</head>

<body class="bg-gray-50 font-sans">
    <div class="flex flex-col min-h-screen">

        <!-- Sidebar + Main content wrapper -->
        <div class="flex flex-1 flex-col sm:flex-row">
            <!-- Sidebar (offcanvas on mobile if you want) -->
            <aside class="w-full sm:w-64 bg-white shadow-md sm:h-auto h-auto">
                @include('layouts.sidebar')
            </aside>

            <!-- Main Content -->
            <main class="flex-1 p-4 sm:p-6 md:p-8 ml-1 bg-gray-50">
                @yield('content')
            </main>
        </div>

        <!-- Footer -->
        <footer class="bg-white border-t mt-auto">
            @include('layouts.footer')
        </footer>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
