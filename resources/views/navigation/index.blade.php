<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('navigation.layouts.head')

<body class="io-grey-mode">
<!-- page-container start -->
<div class="page-container">
    @include('navigation.layouts.sidebar')
    <div class="main-content flex-fill">
        @include('navigation.layouts.header')
        @include('navigation.layouts.content')
        <!-- 悬浮窗start -->
        @include('navigation.layouts.float')
        <!-- 悬浮窗end -->
        @include('navigation.layouts.footer')
    </div>
</div>
<!-- page-container end -->
@include('navigation.layouts.script')
</body>

</html>
