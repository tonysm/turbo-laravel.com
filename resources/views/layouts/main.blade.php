<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', $title ?? __('Turbo Laravel'))</title>

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('/site.webmanifest') }}">

    <!-- Algolia Search -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3"/>

    <x-social-media-tags />

    <!-- Fonts -->
    <link rel="stylesheet" href="https://use.typekit.net/ins2wgm.css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ tailwindcss('css/app.css') }}" />

    <x-importmap-tags />
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="w-full min-h-screen flex flex-col justify-between bg-gray-50" data-controller="nav-highlight">
        <x-skip-to-main-content />

        <header @class(["py-8", "shadow-sm" => ! request()->routeIs('welcome')])>
            <x-navigation>
                <x-slot:mobileIndex>
                    @yield('mobileIndex', $mobileIndex ?? '')
                </x-slot>
            </x-navigation>

            @yield('afterHeader', $afterHeader ?? '')
        </header>

        <div class="flex-1">@yield('content', $slot ?? '')</div>

        <hr class="my-10 w-32 mx-auto border-gray-300 shadow-sm rounded-full" />

        <x-footer class="py-4 px-8 sm:px-20" />
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@docsearch/js@3" data-turbo-eval="false"></script>
    <script type="text/javascript" data-turbo-eval="false">
        docsearch({
            appId: '6JF81FAX88',
            apiKey: 'b23e86ea68b3173af972c611e98cf7c4',
            indexName: 'turbo-laravel',
            container: '#algolia-search',
            debug: false,
        });
    </script>
</body>
</html>
