<!doctype html>
<html class="no-js" lang="zxx">

@include('components.includes.head')

<body>
<!-- Preloader Start -->
@include('components.includes.loader')

<!-- Preloader Start -->
@include('components.includes.header')

@yield('content')

@include('components.includes.footer')

@include('components.includes.script')

</body>
</html>
