@php View::share('disableAutoToast', true); @endphp
@extends('layouts.guest')

@section('title', 'Login - SiHalalPKU')

@section('content')
<div class="min-h-screen flex flex-col md:flex-row">
    <!-- Left Side - Form -->
    <div class="w-full md:w-1/2 bg-white flex flex-col items-center px-4 md:px-16 py-6 md:py-8 min-h-screen">
        <!-- Logo Section -->
        <div class="w-full max-w-[356px] md:max-w-[584px] flex items-center gap-1 md:gap-2 flex-shrink-0">
            <img src="{{ asset('images/logo/logo_lppm.webp') }}" alt="LPPM UIN SUSKA RIAU" class="h-[39px] w-auto md:h-[60px] object-contain">
            <img src="{{ asset('images/logo/pusatp3h.webp') }}" alt="Pusat P3H" class="h-[39px] w-auto md:h-[60px] object-contain">
            <img src="{{ asset('images/logo/logo_uin.webp') }}" alt="UIN SUSKA" class="h-[39px] w-auto md:h-[60px] object-contain">
            <img src="{{ asset('images/logo/logo_bhalal.webp') }}" alt="HALAL" class="h-[34px] w-auto md:h-[55px] object-contain">
        </div>

        <!-- Form Container -->
        <div class="w-full max-w-[356px] md:max-w-[584px] flex-1 flex flex-col justify-center py-6 md:py-8">
            <!-- Title -->
            <h1 class="text-2xl md:text-4xl font-semibold text-black mb-1 md:mb-2">
                Log In SiHalalPKU
            </h1>
            <p class="text-[13px] md:text-base font-extralight text-black mb-6 md:mb-10">
                Silahkan Masuk menggunakan fitur web SiHalalPKU
            </p>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-4 p-3 md:p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm md:text-base">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-4 p-3 md:p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm md:text-base">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('login.proses') }}" method="POST" class="space-y-4 md:space-y-6">
                @csrf
                
                <!-- Email -->
                <div>
                    <label for="email" class="block text-base md:text-xl font-semibold text-[#242424] mb-1 md:mb-2">
                        Email
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           class="w-full h-[40px] md:h-[69px] bg-[#f6f6f6] border border-[#2d7e37] rounded-3xl shadow-md px-4 md:px-6 text-sm md:text-lg focus:outline-none focus:ring-2 focus:ring-[#2d7e37]"
                           required>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-base md:text-xl font-semibold text-[#242424] mb-1 md:mb-2">
                        Password
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password"
                           class="w-full h-[40px] md:h-[69px] bg-[#f6f6f6] border border-[#2d7e37] rounded-3xl shadow-md px-4 md:px-6 text-sm md:text-lg focus:outline-none focus:ring-2 focus:ring-[#2d7e37]"
                           required>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full h-[43px] md:h-[70px] bg-gradient-to-b from-[#2d7e37] to-[#18471d] rounded-3xl shadow-md text-white text-base md:text-2xl font-semibold hover:opacity-90 transition-opacity mt-4 md:mt-8">
                    Login
                </button>
            </form>

            <!-- Register Link -->
            <p class="text-center mt-4 md:mt-8 text-sm md:text-xl">
                Belum punya akun? 
                <a href="{{ route('registrasi') }}" class="text-[#6561d4] hover:underline">
                    Buat akun di sini
                </a>
            </p>
        </div>
    </div>

    <!-- Right Side - Image (hidden on mobile) -->
    <div class="hidden md:block w-1/2 relative">
        <img src="{{ asset('images/background_food.webp') }}" 
             alt="Background" 
             class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-b from-[#686868] to-[#666666] opacity-50"></div>
    </div>
</div>
@endsection
