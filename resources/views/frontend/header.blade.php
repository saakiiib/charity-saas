<header class="site-header">
  <div class="container nav">
    <a class="brand" href="{{ url('/') }}">
      @if($company?->company_logo)
        <img src="{{ asset('uploads/company/' . $company->company_logo) }}" alt="{{ $company->company_name }} logo" class="brand-logo">
      @endif
      <span class="brand-name">{{ $company?->company_name ?? config('app.name') }}</span>
    </a>
    <nav class="nav-links">
      <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
      <a href="{{ url('/about') }}" class="{{ request()->is('about') ? 'active' : '' }}">About</a>
      <a href="{{ url('/services') }}" class="{{ request()->is('services') ? 'active' : '' }}">Services</a>
      <a href="{{ url('/updates') }}" class="{{ request()->is('updates') ? 'active' : '' }}">Updates</a>
      <a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}">Contact</a>
    </nav>
    <a class="btn btn-primary nav-cta" href="https://tevini.co.uk">Donate</a>
  </div>
</header>