<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <!-- Branding -->
        <div class="navbar-header">
            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- Branding Image -->
            <a class="navbar-brand" href="
                @if(Auth::guard('admin')->check())
                    {{ url('/admin') }}
                @elseif(Auth::check())
                    {{ url('/') }}
                @endif
                ">
                AUNH
            </a>

        </div>
        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->

            

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                        @if(Auth::check() || Auth::guard('admin')->check())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        @if(Auth::check())
                                        {{ Auth::user()->name }}
                                    @else
                                        {{ Auth::guard('admin')->user()->name }}
                                        @endif
                                    <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            @if(Auth::guard('admin')->check())
                            <li>
                                <a href="{{ url('/admin/wsconfig') }}">
                                    <i class="fa fa-btn fa-cogs"></i>أعدادات الأنظمة
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('error_log') }}">
                                    <i class="fa fa-btn fa-exclamation-triangle"></i> سجل أخطاء النظام
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('tran_log') }}">
                                    <i class="fa fa-btn fa-book" aria-hidden="true"></i></i> سجل الأدخال
                                </a>
                            </li>
                            @endif
                            <li>
                                <a href="@if(Auth::check()) {{ url('/logout') }} @else {{ url('/admin/logout') }} @endif">
                                    <i class="fa fa-btn fa-sign-out"></i>تسجيل خروج</a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
            <!-- End of Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                @if(Auth::guard('admin')->check())
                @include('layouts.admin.menu')
                @elseif(Auth::check())
                @include('layouts.home.menu')
                @endif
            </ul>
            </div>
            <!-- End of #app-navbar-collapse -->
        </div>
    </div>
</nav>
