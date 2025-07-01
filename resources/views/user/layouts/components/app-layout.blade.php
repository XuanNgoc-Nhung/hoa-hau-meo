<!doctype html>
<html lang="en">
  <!--begin::Head-->
  @include('user.layouts.components.head')
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed fixed-header fixed-sidebar sidebar-expand-lg bg-body-tertiary" style="padding-bottom: 0px;">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      @include('user.layouts.components.navbar')
      <!--end::Header-->
      <!--begin::Sidebar-->
      @include('user.layouts.components.sidebar')
      <!--end::Sidebar-->
      <!--begin::App Main-->
      <main class="app-main">
        @yield('content')
      </main>
      <!--end::App Main-->
      <!--begin::Footer-->
      @include('user.layouts.components.footer')
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    @stack('scripts')
    <!--end::Script-->
  </body>
  <!--end::Body-->
</html> 