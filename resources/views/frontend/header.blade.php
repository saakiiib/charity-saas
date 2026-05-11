<header class="site-header">
    <div class="container nav">
        <a class="brand" href="{{ route('home') }}">
            @if ($company?->company_logo)
                <img src="{{ asset('uploads/company/' . $company->company_logo) }}"
                    alt="{{ $company->company_name }} logo" class="brand-logo">
            @endif
            <span class="brand-name">{{ $company?->company_name ?? config('app.name') }}</span>
        </a>
        <button class="nav-toggle" aria-label="Open menu" aria-expanded="false"
            aria-controls="primary-nav"><span></span><span></span><span></span></button>
        <nav class="nav-links" id="primary-nav">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a>
            <a href="{{ route('services') }}"
                class="{{ request()->routeIs('services', 'service.detail') ? 'active' : '' }}">Services</a>
            <a href="{{ route('updates') }}"
                class="{{ request()->routeIs('updates', 'updates.detail') ? 'active' : '' }}">Updates</a>
            <a href="{{ route('gallery') }}" class="{{ request()->routeIs('gallery') ? 'active' : '' }}">Gallery</a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
        </nav>
        <a class="btn btn-primary nav-cta" href="https://tevini.co.uk/">Donate</a>
    </div>
</header>