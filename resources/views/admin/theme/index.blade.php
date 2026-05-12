@extends('admin.pages.master')
@section('title', 'Theme')
@section('content')

<div class="container-fluid">

    <form action="{{ route('theme.update') }}" method="POST">
        @csrf

        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Choose Theme</h4>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    @foreach([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15] as $theme)
                    <div class="col-md-4">
                        <label for="theme{{ $theme }}" class="theme-card w-100" style="cursor:pointer;">
                            <input type="radio" name="theme" id="theme{{ $theme }}"
                                value="{{ $theme }}"
                                {{ $tenant->theme == $theme ? 'checked' : '' }}
                                hidden>
                            <div class="card h-100 border-2 {{ $tenant->theme == $theme ? 'border-primary' : '' }}"
                                id="themeCard{{ $theme }}">
                                <img src="{{ asset('resources/backend/theme/' . $theme . '.png') }}"
                                    class="img-fluid" alt="Theme {{ $theme }}">
                                <div class="card-body text-center py-3">
                                    <h6 class="mb-1">Theme {{ $theme }}</h6>
                                    @if($tenant->theme == $theme)
                                        <span class="badge bg-primary">Active</span>
                                    @else
                                        <span class="badge bg-light text-dark">Click to select</span>
                                    @endif
                                </div>
                            </div>
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">Apply Theme</button>
            </div>
        </div>

    </form>
</div>

@endsection

@section('script')
<script>
$(document).ready(function () {
    $('input[name="theme"]').on('change', function () {
        // Reset all cards
        $('.theme-card .card').removeClass('border-primary').addClass('border-0');
        $('.theme-card .card .badge').removeClass('bg-primary').addClass('bg-light text-dark').text('Click to select');

        // Highlight selected
        var selected = $(this).attr('id').replace('theme', '');
        $('#themeCard' + selected).removeClass('border-0').addClass('border-primary');
        $('#themeCard' + selected + ' .badge').removeClass('bg-light text-dark').addClass('bg-primary').text('Active');
    });
});
</script>
@endsection