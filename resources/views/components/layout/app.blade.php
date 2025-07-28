<!DOCTYPE html>
<html class="no-js" lang="en">

@include('components.includes.head')

<body>
@include('components.includes.header')

<div class="application-pg">


    @yield('content')

    @include('components.includes.footer')
</div>

</body>
</html>
