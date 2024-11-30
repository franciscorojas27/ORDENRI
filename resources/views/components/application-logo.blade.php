{{-- @if (request()->routeIs('login') || request()->routeIs('register')) --}}
    <img src="{{ asset('/logo_cantv.svg') }}" alt="logo cantv" desc ="logo cantv" {{ $attributes }}>
{{-- @else --}}
    {{-- <img src="{{ asset('/logo_cantv.png') }}" alt="logo cantv" desc ="logo cantv" {{ $attributes }}> --}}
{{-- @endif --}}