<aside class="main-sidebar">

    <section class="sidebar">

        <div class="user-panel">
            <div class="pull-left image">
                @if (auth()->user()->image)
                    <img src="{{ asset('dashboard/imgs/users/' . auth()->user()->image->file) }}" class="img-circle" alt="user image">
                @else
                    <img src="{{ asset('dashboard_files/img/default.jpg') }}" class="img-circle" alt="user image">
                @endif
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <ul class="sidebar-menu" data-widget="tree">

            {{-- For Dashboard --}}
            <li>
                <a href="{{ route('dashboard.index') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>@lang('site.dashboard')</span>
                </a>
            </li>

            {{-- For Users --}}
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-angle-left pull-right"></i>
                    <span>@lang('site.users')</span>
                    <ul class="treeview-menu">
                        {{-- Users --}}
                        @if (auth()->user()->hasPermission('users_read'))
                            <li>
                                <a href="{{ route('dashboard.users.index') }}">
                                    <i class="fa fa-users"></i>
                                    <span>@lang('site.users')</span>
                                </a>
                            </li>
                        @endif
                        {{-- Add User --}}
                        @if (auth()->user()->hasPermission('users_create'))
                            <li>
                                <a href="{{ route('dashboard.users.create') }}">
                                    <i class="fa fa-user-plus"></i>
                                    <span>@lang('site.user_add')</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </a>
            </li>

            {{-- For Categories --}}
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-angle-left pull-right"></i>
                    <span>@lang('site.categories')</span>
                    <ul class="treeview-menu">
                        {{-- Categories --}}
                        @if (auth()->user()->hasPermission('categories_read'))
                            <li>
                                <a href="{{ route('dashboard.categories.index') }}">
                                    <i class="fa fa-tags"></i>
                                    <span>@lang('site.categories')</span>
                                </a>
                            </li>
                        @endif
                        {{-- Add User --}}
                        @if (auth()->user()->hasPermission('categories_create'))
                            <li>
                                <a href="{{ route('dashboard.categories.create') }}">
                                    <i class="fa fa-tag"></i>
                                    <span>@lang('site.category_add')</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </a>
            </li>

            {{-- @if (auth()->user()->hasPermission('read_categories'))
            <li><a href="{{ route('dashboard.categories.index') }}"><i
                        class="fa fa-th"></i><span>@lang('site.categories')</span></a></li>
            @endif

            @if (auth()->user()->hasPermission('read_products'))
            <li><a href="{{ route('dashboard.products.index') }}"><i
                        class="fa fa-th"></i><span>@lang('site.products')</span></a></li>
            @endif

            @if (auth()->user()->hasPermission('read_clients'))
            <li><a href="{{ route('dashboard.clients.index') }}"><i
                        class="fa fa-th"></i><span>@lang('site.clients')</span></a></li>
            @endif

            @if (auth()->user()->hasPermission('read_orders'))
            <li><a href="{{ route('dashboard.orders.index') }}"><i
                        class="fa fa-th"></i><span>@lang('site.orders')</span></a></li>
            @endif

            @if (auth()->user()->hasPermission('read_users'))
            <li><a href="{{ route('dashboard.users.index') }}"><i
                        class="fa fa-th"></i><span>@lang('site.users')</span></a></li>
            @endif --}}

            {{--<li><a href="{{ route('dashboard.categories.index') }}"><i
                        class="fa fa-book"></i><span>@lang('site.categories')</span></a></li>--}}
            {{----}}
            {{----}}
            {{--<li><a href="{{ route('dashboard.users.index') }}"><i
                        class="fa fa-users"></i><span>@lang('site.users')</span></a></li>--}}

            {{--<li class="treeview">--}}
                {{--<a href="#">--}}
                    {{--<i class="fa fa-pie-chart"></i>--}}
                    {{--<span>الخرائط</span>--}}
                    {{--<span class="pull-right-container">--}}
                        {{--<i class="fa fa-angle-left pull-right"></i>--}}
                        {{--</span>--}}
                    {{--</a>--}}
                {{--<ul class="treeview-menu">--}}
                    {{--<li>--}}
                        {{--<a href="../charts/chartjs.html"><i class="fa fa-circle-o"></i> ChartJS</a>--}}
                        {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="../charts/morris.html"><i class="fa fa-circle-o"></i> Morris</a>--}}
                        {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="../charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a>--}}
                        {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="../charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
        </ul>

    </section>

</aside>
