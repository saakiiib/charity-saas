<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="language" content="English">
    <meta name="author" content="{{ $company?->company_name ?? config('app.name') }}">
    <meta name="revisit-after" content="7 days">

    @php
        $pageTitle       = $company?->company_name ?? config('app.name');
        $pageDescription = $company?->meta_description ?? '';
        $pageKeywords    = $company?->meta_keywords ?? '';
    @endphp

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    <meta name="keywords" content="{{ $pageKeywords }}">

    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    @if($company?->meta_image)
        <meta property="og:image" content="{{ asset('uploads/company/meta/' . $company->meta_image) }}">
    @endif

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDescription }}">

    @if($company?->google_site_verification)
        <meta name="google-site-verification" content="{{ $company->google_site_verification }}">
    @endif

    @if($company?->google_analytics_id)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $company->google_analytics_id }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){ dataLayer.push(arguments); }
            gtag('js', new Date());
            gtag('config', '{{ $company->google_analytics_id }}');
        </script>
    @endif

    @if($company?->fav_icon)
        <link rel="icon" href="{{ asset('uploads/company/' . $company->fav_icon) }}" sizes="48x48">
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    @endif

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "{{ $company?->company_name ?? config('app.name') }}",
        "url": "{{ url('/') }}",
        "logo": "{{ $company?->company_logo ? asset('uploads/company/' . $company->company_logo) : '' }}",
        "telephone": "{{ $company?->phone1 ?? '' }}",
        "email": "{{ $company?->email1 ?? '' }}",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "{{ $company?->address1 ?? '' }}",
            "addressCountry": "GB"
        }
    }
    </script>

    @stack('ld-json')

    @if($currentTenant)
        <link rel="stylesheet" href="{{ asset('resources/frontend/css/theme-' . $currentTenant->theme . '.css') }}">
    @endif

    <link href="{{ asset('resources/frontend/css/shared.css') }}" rel="stylesheet">

    @stack('style')
</head>

<body>

    @include('frontend.header')

    @yield('content')

    @include('frontend.footer')

    <script src="{{ asset('resources/frontend/js/shared.js') }}"></script>

    @include('frontend.extra')

    @stack('script')
    @yield('script')

</body>
</html>