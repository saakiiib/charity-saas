<footer id="contact-footer" class="site-footer">
    <div class="footer-top">
        <div class="container foot">
            <div class="foot-brand">
                <a class="brand" href="{{ route('home') }}">
                    @if ($company?->footer_logo)
                        <img src="{{ asset('uploads/company/' . $company->footer_logo) }}"
                            alt="{{ $company->company_name }} logo" class="brand-logo">
                    @elseif($company?->company_logo)
                        <img src="{{ asset('uploads/company/' . $company->company_logo) }}"
                            alt="{{ $company->company_name }} logo" class="brand-logo">
                    @endif
                    <span class="brand-name">{{ $company?->company_name ?? config('app.name') }}</span>
                </a>
                @if ($company?->footer_content)
                    <p class="foot-tag">{{ $company->footer_content }}</p>
                @endif
                <div class="socials" aria-label="Follow us">
                    @if ($company?->facebook)
                        <a href="{{ $company->facebook }}" target="_blank" aria-label="Facebook" class="soc"><svg
                                viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M13 22v-8h3l1-4h-4V7.5c0-1.1.4-2 2-2h2V2.1C16.6 2 15.4 2 14.2 2 11.6 2 9.7 3.6 9.7 6.7V10H7v4h2.7v8H13z" />
                            </svg></a>
                    @endif
                    @if ($company?->instagram)
                        <a href="{{ $company->instagram }}" target="_blank" aria-label="Instagram" class="soc"><svg
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <rect x="3" y="3" width="18" height="18" rx="5" />
                                <circle cx="12" cy="12" r="4" />
                                <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none" />
                            </svg></a>
                    @endif
                    @if ($company?->twitter)
                        <a href="{{ $company->twitter }}" target="_blank" aria-label="X / Twitter" class="soc"><svg
                                viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M18 3h3l-7.5 8.6L22 21h-6.6l-5.2-6.3L4.3 21H1.2l8-9.2L1 3h6.8l4.7 5.8L18 3zm-1.2 16h1.7L7.3 4.9H5.5L16.8 19z" />
                            </svg></a>
                    @endif
                    @if ($company?->linkedin)
                        <a href="{{ $company->linkedin }}" target="_blank" aria-label="LinkedIn" class="soc"><svg
                                viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M4.98 3.5C4.98 4.88 3.86 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1s2.48 1.12 2.48 2.5zM.22 8h4.56v14H.22V8zm7.5 0h4.37v1.92h.06c.61-1.1 2.1-2.27 4.33-2.27 4.63 0 5.48 3.05 5.48 7.01V22h-4.56v-6.16c0-1.47-.03-3.37-2.05-3.37-2.05 0-2.37 1.6-2.37 3.26V22H7.72V8z" />
                            </svg></a>
                    @endif
                    @if ($company?->youtube)
                        <a href="{{ $company->youtube }}" target="_blank" aria-label="YouTube" class="soc"><svg
                                viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M23 7.2c-.3-1.1-1.1-1.9-2.1-2.2C19 4.5 12 4.5 12 4.5s-7 0-8.9.5C2.1 5.3 1.3 6.1 1 7.2.5 9.1.5 12 .5 12s0 2.9.5 4.8c.3 1.1 1.1 1.9 2.1 2.2 1.9.5 8.9.5 8.9.5s7 0 8.9-.5c1-.3 1.8-1.1 2.1-2.2.5-1.9.5-4.8.5-4.8s0-2.9-.5-4.8zM9.8 15.5v-7l6.1 3.5-6.1 3.5z" />
                            </svg></a>
                    @endif
                </div>
            </div>
            <div class="foot-cols">
                @if ($company?->address1)
                    <div>
                        <h4>Visit</h4>
                        <p>
                            {{ $company->address1 }}
                            @if ($company->address2)
                                <br>{{ $company->address2 }}
                            @endif
                        </p>
                    </div>
                @endif
                @if ($company?->email1 || $company?->phone1)
                    <div>
                        <h4>Contact</h4>
                        <p>
                            @if ($company->email1)
                                <a href="mailto:{{ $company->email1 }}">{{ $company->email1 }}</a>
                            @endif
                            @if ($company->phone1)
                            <a href="tel:{{ $company->phone1 }}">{{ $company->phone1 }}</a>
                            @endif
                        </p>
                    </div>
                @endif
                <div class="foot-links">
                    <h4>Explore</h4>
                    <a href="{{ route('about') }}">About</a>
                    <a href="{{ route('services') }}">Services</a>
                    <a href="{{ route('updates') }}">Updates</a>
                    <a href="{{ route('gallery') }}">Gallery</a>
                    <a href="{{ route('contact') }}">Contact</a>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container foot-bottom-row">
            <small>© {{ date('Y') }} {{ $company?->company_name ?? config('app.name') }}</small>
            <small>
                Designed &amp; Developed by 
                <a href="https://mentosoftware.co.uk" target="_blank" class="active">Mentosoftware</a>
            </small>
            <small>
                <a href="{{ route('privacy.policy') }}">Privacy Policy</a>
                ·
                <a href="{{ route('terms.and.conditions') }}">Terms & Conditions</a>
                ·
                <a href="{{ route('faq') }}">FAQ</a>
            </small>
        </div>
    </div>
</footer>

@if ($company?->whatsapp)
    <a class="whatsapp-fab" href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $company->whatsapp) }}" target="_blank"
        rel="noopener" aria-label="Chat on WhatsApp">
        <svg viewBox="0 0 32 32" fill="currentColor" aria-hidden="true">
            <path
                d="M16 .5C7.4.5.5 7.4.5 16c0 2.8.8 5.5 2.2 7.9L.5 31.5l7.8-2.1c2.3 1.3 4.9 2 7.7 2C24.6 31.4 31.5 24.5 31.5 16S24.6.5 16 .5zm0 28.2c-2.5 0-4.9-.7-7-2l-.5-.3-4.6 1.2 1.2-4.5-.3-.5c-1.4-2.2-2.2-4.7-2.2-7.3 0-7.3 6-13.2 13.4-13.2S29.4 8.6 29.4 16 23.4 28.7 16 28.7zm7.3-9.9c-.4-.2-2.4-1.2-2.7-1.3-.4-.1-.6-.2-.9.2s-1 1.3-1.3 1.6c-.2.2-.5.3-.9.1-.4-.2-1.7-.6-3.2-2-1.2-1-2-2.3-2.2-2.7-.2-.4 0-.6.2-.8l.6-.7c.2-.2.3-.4.4-.6.1-.2 0-.5 0-.7s-.9-2.1-1.2-2.9c-.3-.8-.7-.7-.9-.7h-.8c-.3 0-.7.1-1.1.5-.4.4-1.4 1.4-1.4 3.4 0 2 1.5 3.9 1.7 4.2.2.3 2.9 4.4 7 6.2.9.4 1.7.6 2.3.8.9.3 1.8.2 2.5.2.7-.1 2.4-1 2.7-1.9.3-.9.3-1.7.2-1.9-.1-.2-.4-.3-.8-.5z" />
        </svg>
    </a>
@endif