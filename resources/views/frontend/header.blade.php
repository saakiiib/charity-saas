<header class="site-header">
  <div class="container nav">
    <a class="brand" href="{{ url('/') }}">
      @if($company?->company_logo)
        <img src="{{ asset('uploads/company/' . $company->company_logo) }}" alt="{{ $company->company_name }} logo" class="brand-logo">
      @endif
      <span class="brand-name">{{ $company?->company_name ?? config('app.name') }}</span>
    </a>
    <nav class="nav-links">
        
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
        <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a>
        <a href="{{ route('services') }}" class="{{ request()->routeIs('services') ? 'active' : '' }}">Services</a>
        <a href="{{ route('updates') }}" class="{{ request()->routeIs('updates') ? 'active' : '' }}">Updates</a>
        <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
    </nav>
    <a class="btn btn-primary nav-cta" href="https://tevini.co.uk">Donate</a>
  </div>
</header>