@props([])

@php
    $brand = config('branding');
    $brandName = data_get($brand, 'name', config('app.name', 'Laravel'));
    $locale = $locale ?? 'en';
    $locales = ['en', 'fr', 'es'];
    $localeLabels = ['en' => 'English', 'fr' => 'Français', 'es' => 'Español'];
@endphp

<!DOCTYPE html>
<html lang="{{ $locale }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ __('agency.hero_title') }} — {{ $brandName }}</title>

        <link rel="icon" href="{{ asset(data_get($brand, 'assets.favicon', 'favicon.ico')) }}" type="image/svg+xml">
        <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
        <link rel="dns-prefetch" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=manrope:300,400,500,600,700&display=swap" rel="stylesheet" />
        <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased text-ink-900">
        <div class="relative isolate overflow-hidden">
            <div class="absolute inset-0 -z-10 bg-sand-50"></div>
            <div class="absolute -top-40 right-0 -z-10 h-80 w-80 rounded-full bg-[radial-gradient(circle_at_center,var(--color-clay-500),transparent_68%)] opacity-40 blur-3xl animate-float"></div>
            <div class="absolute -bottom-48 left-0 -z-10 h-[28rem] w-[28rem] rounded-full bg-[radial-gradient(circle_at_center,var(--color-moss-500),transparent_70%)] opacity-25 blur-3xl animate-float"></div>

            {{-- Header --}}
            <header class="mx-auto w-full max-w-6xl px-6 pt-6">
                <nav class="flex items-center justify-between gap-4 rounded-full border border-sand-200 bg-white/80 px-5 py-3 shadow-sm backdrop-blur">
                    <a href="{{ $locale === 'en' ? '/' : '/'.$locale }}" class="flex items-center gap-3 font-display text-lg tracking-tight">
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-ink-900 text-white">
                            {{ strtoupper(substr($brandName, 0, 1)) }}
                        </span>
                        <span>{{ $brandName }}</span>
                    </a>

                    {{-- Language switcher --}}
                    <div class="flex items-center gap-3 text-sm font-medium text-ink-700">
                        @foreach ($locales as $loc)
                            @php
                                $url = $loc === 'en' ? '/' : '/'.$loc;
                            @endphp
                            <a
                                href="{{ $url }}"
                                class="transition hover:text-ink-900 {{ $loc === $locale ? 'text-ink-900 font-semibold' : '' }}"
                            >
                                {{ strtoupper($loc) }}
                            </a>
                        @endforeach
                    </div>
                </nav>
            </header>

            {{-- Hero --}}
            <main class="mx-auto w-full max-w-6xl px-6">
                <section class="pb-20 pt-14">
                    <div class="mx-auto max-w-3xl text-center space-y-6">
                        <h1 class="text-balance text-4xl font-semibold leading-tight text-ink-900 md:text-6xl animate-fade-up">
                            {{ __('agency.hero_title') }}
                        </h1>
                        <p class="mx-auto max-w-xl text-lg text-ink-700 animate-fade-up" style="animation-delay: 0.08s;">
                            {{ __('agency.hero_description') }}
                        </p>
                        <div class="flex flex-wrap items-center justify-center gap-4 animate-fade-up" style="animation-delay: 0.16s;">
                            <a href="{{ route('register') }}" class="rounded-full bg-ink-900 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-ink-900/15 transition hover:bg-ink-700">
                                {{ __('agency.cta_start') }}
                            </a>
                            <a href="#features" class="rounded-full border border-ink-900/15 bg-white/80 px-6 py-3 text-sm font-semibold text-ink-900 transition hover:border-ink-900/30">
                                {{ __('agency.cta_learn') }}
                            </a>
                        </div>
                    </div>
                </section>

                {{-- Features --}}
                <section id="features" class="pb-20">
                    <p class="mb-6 text-center text-sm font-semibold uppercase tracking-[0.2em] text-ink-600">{{ __('agency.features_label') }}</p>
                    <div class="grid gap-6 lg:grid-cols-3">
                        @foreach ([1, 2, 3] as $i)
                            <div class="rounded-3xl border border-sand-200 bg-white/80 p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                                <h3 class="text-lg font-semibold text-ink-900">{{ __("agency.feature_{$i}_title") }}</h3>
                                <p class="mt-3 text-sm text-ink-700">{{ __("agency.feature_{$i}_description") }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>

                {{-- CTA --}}
                <section class="pb-24">
                    <div class="rounded-[2.5rem] border border-ink-900/10 bg-ink-900 px-10 py-12 text-white">
                        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                            <div class="space-y-3">
                                <h2 class="text-3xl font-semibold">{{ __('agency.cta_title') }}</h2>
                                <p class="max-w-xl text-white/70">{{ __('agency.cta_description') }}</p>
                            </div>
                            <a href="{{ route('register') }}" class="rounded-full bg-white px-6 py-3 text-sm font-semibold text-ink-900">
                                {{ __('agency.cta_start') }}
                            </a>
                        </div>
                    </div>
                </section>
            </main>

            {{-- Footer --}}
            <footer class="mx-auto w-full max-w-6xl px-6 pb-12 pt-16">
                <div class="border-t border-sand-200 pt-10">
                    <div class="flex flex-wrap items-center justify-between gap-3 text-xs text-ink-600">
                        <span>{{ $brandName }}. All rights reserved.</span>
                        <div class="flex items-center gap-3">
                            @foreach ($locales as $loc)
                                @php
                                    $url = $loc === 'en' ? '/' : '/'.$loc;
                                @endphp
                                <a
                                    href="{{ $url }}"
                                    class="transition hover:text-ink-900 {{ $loc === $locale ? 'font-semibold text-ink-900' : '' }}"
                                >
                                    {{ $localeLabels[$loc] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
