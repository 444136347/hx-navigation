<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('navigation.layouts.head')

<body class="io-grey-mode">
<!-- page-container start -->
<div class="page-container">
    <div class="flex-fill">
    @include('navigation.layouts.contributeContent')
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
