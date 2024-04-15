<div>
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900">
            {{ config('app.name') }}
        </a>
        <div class="w-full p-6 rounded-lg shadow dark:border md:mt-0 sm:max-w-md sm:p-8">
            <h2 class="mb-1 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl text-center">
                {{ session('status') }}
            </h2>
        </div>
    </div>
</div>
