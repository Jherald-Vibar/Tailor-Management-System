<footer class="bg-white rounded-lg shadow-sm dark:bg-gray-900 m-4">
    <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
        <span id="year" class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">&copy; <a href="https://flowbite.com/" class="hover:underline">{{config('app.name')}}</a>. All Rights Reserved.</span>
    </div>
    <script>
        const date = new Date().getFullYear();
        document.getElementById('year').innerHTML = `&copy; ${date} <a href="https://flowbite.com/" class="hover:underline">{{config('app.name')}}</a>. All Rights Reserved.`;
    </script>
</footer>

