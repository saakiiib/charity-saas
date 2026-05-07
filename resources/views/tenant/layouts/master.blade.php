{{-- resources/views/tenant/layouts/master.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $tenant->name)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        :root { --primary: {{ $tenant->primary_color }}; }
        .navbar-brand, .btn-primary { background-color: var(--primary) !important; border-color: var(--primary) !important; }
        .navbar { background-color: var(--primary) !important; }
        .hero { background-color: var(--primary); color: white; padding: 100px 0; }
        .text-primary { color: var(--primary) !important; }
        .section { padding: 70px 0; }
        footer { background: #222; color: #aaa; padding: 40px 0; }
    </style>
    @yield('styles')
</head>
<body>

<nav class="navbar navbar-dark navbar-expand-lg">
    <div class="container">
        @if($tenant->logo)
            <a class="navbar-brand" href="/"><img src="{{ asset($tenant->logo) }}" height="40" alt="{{ $tenant->name }}"></a>
        @else
            <a class="navbar-brand fw-bold" href="/">{{ $tenant->name }}</a>
        @endif
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link text-white" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="/about">About</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="/services">Services</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="/contact">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>

@yield('content')

<footer>
    <div class="container text-center">
        <p class="mb-1 fw-bold text-white">{{ $tenant->name }}</p>
        @if($tenant->email)<p class="mb-1"><i class="ri-mail-line me-1"></i>{{ $tenant->email }}</p>@endif
        @if($tenant->phone)<p class="mb-1"><i class="ri-phone-line me-1"></i>{{ $tenant->phone }}</p>@endif
        <p class="mt-3 mb-0 small">&copy; {{ date('Y') }} {{ $tenant->name }}. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>