<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tenant->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --primary: {{ $tenant->primary_color }}; }
        .navbar { background-color: var(--primary) !important; }
        .hero   { background-color: var(--primary); color: white; padding: 80px 0; }
    </style>
</head>
<body>

<nav class="navbar navbar-dark">
    <div class="container">
        @if($tenant->logo)
            <img src="{{ asset($tenant->logo) }}" height="40" alt="{{ $tenant->name }}">
        @else
            <span class="navbar-brand fw-bold">{{ $tenant->name }}</span>
        @endif
    </div>
</nav>

<section class="hero text-center">
    <div class="container">
        <h1 class="display-4 fw-bold">{{ $tenant->name }}</h1>
        @if($tenant->tagline)
            <p class="lead mt-3">{{ $tenant->tagline }}</p>
        @endif
    </div>
</section>

<section class="py-5">
    <div class="container text-center">
        @if($tenant->email)
            <p><strong>Email:</strong> {{ $tenant->email }}</p>
        @endif
        @if($tenant->phone)
            <p><strong>Phone:</strong> {{ $tenant->phone }}</p>
        @endif
    </div>
</section>

</body>
</html>