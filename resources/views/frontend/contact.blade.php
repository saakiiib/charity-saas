@extends('frontend.master')

@section('content')

{{-- Hero --}}
<section class="page-hero"
    style="background-image:url('{{ $hero?->image ? asset('uploads/masters/' . $hero->image) : '' }}')">
    <div class="page-hero-overlay"></div>
    <div class="container hero-inner">
        <span class="eyebrow">{{ $hero?->short_title }}</span>
        <h1 class="hero-title">{{ $hero?->long_title }}</h1>
        <p class="hero-sub">{{ $hero?->short_description }}</p>
        <nav class="breadcrumb" aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a> <i>/</i> <span>Contact</span></nav>
    </div>
    <div class="hero-orb" aria-hidden="true"></div>
</section>

{{-- Contact --}}
<section class="section">
    <div class="container contact-grid">
        <div class="contact-info">
            @if($company?->address1)
            <div class="info-card">
                <h4>Visit</h4>
                <p>
                    {{ $company->address1 }}
                    @if($company->address2)<br>{{ $company->address2 }}@endif
                </p>
            </div>
            @endif

            @if($company?->email1 || $company?->email2)
            <div class="info-card">
                <h4>Email</h4>
                <p>
                    @if($company->email1){{ $company->email1 }}@endif
                    @if($company->email2)<br>{{ $company->email2 }}@endif
                </p>
            </div>
            @endif

            @if($company?->phone1 || $company?->whatsapp)
            <div class="info-card">
                <h4>Phone</h4>
                <p>
                    @if($company->phone1){{ $company->phone1 }}@endif
                    @if($company->phone2)<br>{{ $company->phone2 }}@endif
                    @if($company->opening_time)<br>{{ $company->opening_time }}@endif
                </p>
            </div>
            @endif

            @if($company?->facebook || $company?->instagram || $company?->twitter || $company?->linkedin || $company?->youtube)
            <div class="info-card">
                <h4>Follow us</h4>
                <div class="socials" aria-label="Follow us on social media">
                    @if ($company?->facebook)
                        <a href="{{ $company->facebook }}" target="_blank" rel="noopener" aria-label="Facebook" class="soc">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M13 22v-8h3l1-4h-4V7.5c0-1.1.4-2 2-2h2V2.1C16.6 2 15.4 2 14.2 2 11.6 2 9.7 3.6 9.7 6.7V10H7v4h2.7v8H13z" />
                            </svg>
                        </a>
                    @endif
                    @if ($company?->instagram)
                        <a href="{{ $company->instagram }}" target="_blank" rel="noopener" aria-label="Instagram" class="soc">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <rect x="3" y="3" width="18" height="18" rx="5" />
                                <circle cx="12" cy="12" r="4" />
                                <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none" />
                            </svg>
                        </a>
                    @endif
                    @if ($company?->twitter)
                        <a href="{{ $company->twitter }}" target="_blank" rel="noopener" aria-label="X / Twitter" class="soc">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18 3h3l-7.5 8.6L22 21h-6.6l-5.2-6.3L4.3 21H1.2l8-9.2L1 3h6.8l4.7 5.8L18 3zm-1.2 16h1.7L7.3 4.9H5.5L16.8 19z" />
                            </svg>
                        </a>
                    @endif
                    @if ($company?->linkedin)
                        <a href="{{ $company->linkedin }}" target="_blank" rel="noopener" aria-label="LinkedIn" class="soc">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M4.98 3.5C4.98 4.88 3.86 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1s2.48 1.12 2.48 2.5zM.22 8h4.56v14H.22V8zm7.5 0h4.37v1.92h.06c.61-1.1 2.1-2.27 4.33-2.27 4.63 0 5.48 3.05 5.48 7.01V22h-4.56v-6.16c0-1.47-.03-3.37-2.05-3.37-2.05 0-2.37 1.6-2.37 3.26V22H7.72V8z" />
                            </svg>
                        </a>
                    @endif
                    @if ($company?->youtube)
                        <a href="{{ $company->youtube }}" target="_blank" rel="noopener" aria-label="YouTube" class="soc">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M23 7.2c-.3-1.1-1.1-1.9-2.1-2.2C19 4.5 12 4.5 12 4.5s-7 0-8.9.5C2.1 5.3 1.3 6.1 1 7.2.5 9.1.5 12 .5 12s0 2.9.5 4.8c.3 1.1 1.1 1.9 2.1 2.2 1.9.5 8.9.5 8.9.5s7 0 8.9-.5c1-.3 1.8-1.1 2.1-2.2.5-1.9.5-4.8.5-4.8s0-2.9-.5-4.8zM9.8 15.5v-7l6.1 3.5-6.1 3.5z" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <form class="contact-form" id="contactForm" action="{{ route('contact.submit') }}" method="POST">
            @csrf
            @if(session('success'))
            <div style="margin-bottom:20px;">
                <div class="alert alert-success">{{ session('success') }}</div>
            </div>
            @endif
            <div class="row">
                <div>
                    <label for="fn">First name</label>
                    <input id="fn" type="text" name="first_name" required value="{{ old('first_name') }}">
                </div>
                <div>
                    <label for="ln">Last name</label>
                    <input id="ln" type="text" name="last_name" value="{{ old('last_name') }}">
                </div>
            </div>
            <div class="row">
                <div>
                    <label for="em">Email</label>
                    <input id="em" type="email" name="email" required value="{{ old('email') }}">
                </div>
                <div>
                    <label for="ph">Phone (optional)</label>
                    <input id="ph" type="tel" name="phone" value="{{ old('phone') }}">
                </div>
            </div>
            <div style="margin-bottom:16px">
                <label for="rs">Subject</label>
                <input id="rs" type="text" name="subject" value="{{ old('subject') }}">
            </div>
            <div style="margin-bottom:22px">
                <label for="msg">Your message</label>
                <textarea id="msg" name="message" required >{{ old('message') }}</textarea>
            </div>
            <div style="margin-bottom:22px">
                <label id="captcha-question"></label>
                <input id="captcha-answer" type="number" placeholder="Your answer">
                <span id="captcha-error" class="d-none" style="color:red;font-size:.85rem;display:block;margin-top:4px"></span>
            </div>
            <button class="btn btn-primary" type="submit">Send message</button>
        </form>
    </div>
</section>

{{-- CTA --}}
@include('frontend.cta')

@endsection

@push('script')
<script>
(function () {
    function generateCaptcha() {
        var num1 = Math.floor(Math.random() * 10) + 1;
        var num2 = Math.floor(Math.random() * 10) + 1;
        return { question: 'What is ' + num1 + ' + ' + num2 + '? *', answer: num1 + num2 };
    }

    var captcha = generateCaptcha();
    document.getElementById('captcha-question').textContent = captcha.question;

    document.getElementById('contactForm').addEventListener('submit', function (e) {
        var userAnswer = parseInt(document.getElementById('captcha-answer').value);
        var error = document.getElementById('captcha-error');
        if (userAnswer !== captcha.answer) {
            e.preventDefault();
            error.style.display = 'block';
            error.textContent = 'Incorrect answer. Please try again.';
            captcha = generateCaptcha();
            document.getElementById('captcha-question').textContent = captcha.question;
            document.getElementById('captcha-answer').value = '';
        } else {
            error.style.display = 'none';
            this.querySelector('button[type="submit"]').disabled = true;
            this.querySelector('button[type="submit"]').textContent = 'Sending...';
        }
    });
})();
</script>
@endpush