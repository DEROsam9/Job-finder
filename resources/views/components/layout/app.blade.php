<!DOCTYPE html>
<html class="no-js" lang="en">
@include('components.includes.head')

<body class="layout-body">
    @include('components.includes.header')

    <div class="layout-wrapper application-pg">
        <main class="layout-main">
            @yield('content')
        </main>

        @include('components.includes.footer')
    </div>
</body>
</html>
