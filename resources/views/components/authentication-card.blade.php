{{--<div class="min-h-screen flex flex-col sm:flex-row sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">--}}
<div class="min-h-screen grid grid-cols-1 sm:grid-cols-2 sm:justify-center items-center pt-6 sm:pt-0 bg-white">
    <div class="hidden sm:block sm:items-center">
        <img src="{{ url('img/login_image.jpg') }}" class="ml-12 w-full" alt="">
    </div>
    <div class="flex flex-col items-center justify-center">
        <div>
            {{ $logo }}
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
</div>
