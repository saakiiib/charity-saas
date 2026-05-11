@php
  $tenant = app()->bound('currentTenant') ? app('currentTenant') : null;
  $cta = $tenant ? \App\Models\Master::where('tenant_id', $tenant->id)->where('page', 'all')->where('name', 'cta')->first() : null;
@endphp

<section id="donate" class="cta-band">
  <div class="container cta-inner">
    <h2>{{ $cta?->short_title }}</h2>
    <p>{{ $cta?->long_title }}</p>
    <div class="hero-cta">
      @if($cta?->content[0]['short_desc'] ?? null)
        <a class="btn btn-primary" href="{{ $cta->content[0]['long_desc'] ?? 'contact' }}">{{ $cta->content[0]['short_desc'] }}</a>
      @endif
      @if($cta?->content[1]['short_desc'] ?? null)
        <a class="btn btn-ghost" href="{{ $cta->content[1]['long_desc'] ?? 'contact' }}">{{ $cta->content[1]['short_desc'] }}</a>
      @endif
    </div>
  </div>
</section>