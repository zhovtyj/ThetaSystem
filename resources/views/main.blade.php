<!DOCTYPE html>
<html lang="en">

@include('partials._head')

    <body>

        @include('partials._header')

        @include('partials._messages')

        @yield('content')

        @include('partials._footer')

        @yield('javascripts')

    </body>

</html>

