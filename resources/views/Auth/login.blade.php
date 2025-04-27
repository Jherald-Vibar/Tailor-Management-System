<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('app.name')}}</title>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{asset('images/logo.jfif')}}">
</head>
<body class="overflow-hidden m-0 p-0">
    <div class="h-screen overflow-hidden">
        <nav class="w-full bg-white border-b border-gray-200 dark:bg-gray-900">
            <div class="flex flex-wrap justify-between items-center mx-auto w-full p-4">
                <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
                    <img src="{{ asset('images/logo.jfif') }}" class="h-8" alt="Threadlog Logo" />
                    <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Threadlog</span>
                </a>
                <div class="flex items-center space-x-6 rtl:space-x-reverse">
                    <a href="{{route('registerForm')}}" class="text-sm text-gray-500 dark:text-white hover:underline">{{ $route }}</a>
                    <a href="#" class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium rounded-lg px-4 py-2 transition">Login</a>
                </div>
            </div>
        </nav>

        <section class="bg-gray-50 dark:bg-gray-900 h-[calc(100vh-64px)] flex items-center justify-center">
            <div class="w-full max-w-md p-6 bg-white rounded-lg dark:bg-gray-800 dark:border dark:border-gray-700" style="box-shadow: 1px 1px 3px 3px rgb(212, 212, 212)">
                <div class="flex justify-center gap-2 items-center">
                    <h1 class="text-xl font-bold font-sans text-center text-gray-900 dark:text-white mb-4">
                       Threadlog
                    </h1>
                    <div class="flex justify-center mb-6">
                        <img class="w-10 h-10" src="{{ asset('images/logo.jfif') }}" alt="logo">
                    </div>
                </div>
                <form class="space-y-8" action="{{route('customer-authenticate')}}" method="POST">
                    @csrf
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" id="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="name@company.com" required>
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <input type="password" id="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="••••••••" required>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" type="checkbox" class="w-4 h-4 border-gray-300 rounded focus:ring-orange-500 dark:bg-gray-700 dark:border-gray-600">
                            <label for="remember" class="ml-2 text-sm text-gray-500 dark:text-gray-300">Remember me</label>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-3 mb-3 mt-5">
                        <button type="submit" class="w-full text-white bg-orange-500 hover:bg-orange-600 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition">
                            Sign in
                        </button>

                        <a href="{{route('registerForm')}}" class="w-full text-center text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 transition">
                           Create Account
                        </a>
                    </div>
                    <div class="flex items-center justify-center">
                        <a href="" class="text-sm text-blue-300">Forgot Password or Cannot Login?</a>
                    </div>
                </form>
            </div>
        </section>
    </div>
</body>
</html>
