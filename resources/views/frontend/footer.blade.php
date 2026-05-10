<footer id="contact-footer" class="site-footer">
  <div class="container foot">
    <div>
      <a class="brand" href="{{ url('/') }}">
        @if($company?->footer_logo)
          <img src="{{ asset('uploads/company/' . $company->footer_logo) }}" alt="{{ $company->company_name }} logo" class="brand-logo">
        @elseif($company?->company_logo)
          <img src="{{ asset('uploads/company/' . $company->company_logo) }}" alt="{{ $company->company_name }} logo" class="brand-logo">
        @endif
        <span class="brand-name">{{ $company?->company_name ?? config('app.name') }}</span>
      </a>
      @if($company?->footer_content)
        <p class="muted">{{ $company->footer_content }}</p>
      @endif
    </div>
    <div class="foot-cols">
      @if($company?->address1)
      <div>
        <h4>Visit</h4>
        <p>
          {{ $company->address1 }}
          @if($company->address2)<br>{{ $company->address2 }}@endif
        </p>
      </div>
      @endif
      @if($company?->email1 || $company?->phone1)
      <div>
        <h4>Contact</h4>
        <p>
          @if($company->email1){{ $company->email1 }}@endif
          @if($company->phone1)<br>{{ $company->phone1 }}@endif
        </p>
      </div>
      @endif
      <div>
        <h4>Pages</h4>
        <a href="{{ url('/about') }}">About</a>
        <a href="{{ url('/services') }}">Services</a>
        <a href="{{ url('/updates') }}">Updates</a>
        <a href="{{ url('/contact') }}">Contact</a>
      </div>
    </div>
  </div>
  <div class="container copyright">
    <small>© {{ date('Y') }} {{ $company?->company_name ?? config('app.name') }}. All rights reserved.</small>
  </div>
</footer>

@if($company?->whatsapp)
<a class="whatsapp-fab" href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $company->whatsapp) }}" target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
  <svg viewBox="0 0 32 32" fill="currentColor" aria-hidden="true"><path d="M16 .5C7.4.5.5 7.4.5 16c0 2.8.8 5.5 2.2 7.9L.5 31.5l7.8-2.1c2.3 1.3 4.9 2 7.7 2C24.6 31.4 31.5 24.5 31.5 16S24.6.5 16 .5zm0 28.2c-2.5 0-4.9-.7-7-2l-.5-.3-4.6 1.2 1.2-4.5-.3-.5c-1.4-2.2-2.2-4.7-2.2-7.3 0-7.3 6-13.2 13.4-13.2S29.4 8.6 29.4 16 23.4 28.7 16 28.7zm7.3-9.9c-.4-.2-2.4-1.2-2.7-1.3-.4-.1-.6-.2-.9.2s-1 1.3-1.3 1.6c-.2.2-.5.3-.9.1-.4-.2-1.7-.6-3.2-2-1.2-1-2-2.3-2.2-2.7-.2-.4 0-.6.2-.8l.6-.7c.2-.2.3-.4.4-.6.1-.2 0-.5 0-.7s-.9-2.1-1.2-2.9c-.3-.8-.7-.7-.9-.7h-.8c-.3 0-.7.1-1.1.5-.4.4-1.4 1.4-1.4 3.4 0 2 1.5 3.9 1.7 4.2.2.3 2.9 4.4 7 6.2.9.4 1.7.6 2.3.8.9.3 1.8.2 2.5.2.7-.1 2.4-1 2.7-1.9.3-.9.3-1.7.2-1.9-.1-.2-.4-.3-.8-.5z"/></svg>
</a>
@endif