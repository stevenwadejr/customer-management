@include('partials.header')

<div class="container">
    @include('partials.flash')

    @yield('content')
</div>

@include('partials.footer')