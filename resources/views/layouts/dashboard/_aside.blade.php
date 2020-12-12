<aside class="main-sidebar">

    <section class="sidebar">

        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('dashboard/img/avatar5.png') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p> {{ auth()->user()->name }} {{--auth()->user()->last_name--}}</p>
                <p style="font-size: 13px"><i class="fa fa-circle text-success"></i>
                    @if (auth()->user()->type == 'super_admin' || auth()->user()->type == 'admin')
                        @lang('site.admin')
                    @elseif (auth()->user()->type == 'student')
                        @lang('site.student')
                    @elseif (auth()->user()->type == 'doctor')
                        @lang('site.doctor')
                    @endif </p>
            </div>
        </div>

        <ul class="sidebar-menu" data-widget="tree">
        <li><a href="{{route('dashboard.index')}}"><i class="fa fa-th"></i><span>@lang('site.dashboard')</span></a></li>

        @if (auth()->user()->hasPermission('read_doctors'))
            <li><a href="{{route('dashboard.doctors.index')}}"><i class="fa fa-users"></i><span>@lang('site.doctors')</span></a></li>
        @endif

        @if (auth()->user()->hasPermission('read_students'))
            <li><a href="{{route('dashboard.students.index')}}"><i class="fa fa-users"></i><span>@lang('site.students')</span></a></li>
        @endif

        @if (auth()->user()->type == 'admin')
            <li><a href="{{url('/dashboard/complains/student-problem')}}"><i class="fa fa-users"></i><span>@lang('site.student_problems')</span></a></li>
        @endif
        @if (auth()->user()->type == 'admin')
            <li><a href="{{url('/dashboard/complains/doctor-problem')}}"><i class="fa fa-users"></i><span>@lang('site.doctor_problems')</span></a></li>
        @endif


        @if (auth()->user()->hasPermission('read_levels'))
            <li><a href="{{route('dashboard.levels.index')}}"><i class="fa fa-level-up"></i><span>@lang('site.levels')</span></a></li>
        @endif

        @if (auth()->user()->hasPermission('read_departments'))
            <li><a href="{{route('dashboard.departments.index')}}"><i class="fa fa-bank"></i><span>@lang('site.departments')</span></a></li>
        @endif

        @if (auth()->user()->hasPermission('read_subjects'))
            <li><a href="{{route('dashboard.subjects.index')}}"><i class="fa fa-graduation-cap"></i><span>@lang('site.subjects')</span></a></li>
        @endif

        @if (auth()->user()->hasPermission('read_lessons'))
            <li><a href="{{route('dashboard.lessons.index')}}"><i class="fa fa-newspaper-o"></i><span>@lang('site.lessons')</span></a></li>
        @endif

        @if (auth()->user()->hasPermission('read_assignments'))
            <li><a href="{{route('dashboard.assignments.index')}}"><i class="fa fa-list-alt"></i><span>@lang('site.assignments')</span></a></li>
        @endif

        @if (auth()->user()->hasPermission('read_stdassign'))
            <li><a href="{{route('dashboard.student_assignments.index')}}"><i class="fa fa-users"></i><span>@lang('site.student_assignments')</span></a></li>
        @endif

        @if (auth()->user()->type == 'doctor' || auth()->user()->type == 'admin')
            <li><a href="{{route('dashboard.student_assignments.getReport')}}"><i class="fa fa-users"></i><span>@lang('site.report_student_assignments')</span></a></li>
        @endif

        @if (auth()->user()->hasRole('admin' ) || auth()->user()->hasRole('super_admin' ))
            <li><a href="{{route('dashboard.student_subjects.index')}}"><i class="fa fa-th-list"></i><span>@lang('site.student_regist_subjects')</span></a></li>
        @endif

        {{--@if (auth()->user()->hasPermission('read_users'))
            <li><a href="{{route('dashboard.users.index')}}"><i class="fa fa-users"></i><span>@lang('site.users')</span></a></li>
        @endif--}}

        @if (auth()->user()->hasPermission('read_admins'))
            <li><a href="{{route('dashboard.admins.index')}}"><i class="fa fa-users"></i><span>@lang('site.admins')</span></a></li>
        @endif

        @if (auth()->user()->hasRole('admin' ) || auth()->user()->hasRole('super_admin' ))

        <li><a href="{{route('dashboard.option.index')}}"><i class="fa fa-cogs"></i><span>@lang('site.settings')</span></a></li>

        @endif

           {{-- @if (auth()->user()->hasPermission('read_categories'))
                <li><a href="{{ route('dashboard.categories.index') }}"><i class="fa fa-th"></i><span>@lang('site.categories')</span></a></li>
            @endif

            @if (auth()->user()->hasPermission('read_products'))
                <li><a href="{{ route('dashboard.products.index') }}"><i class="fa fa-th"></i><span>@lang('site.products')</span></a></li>
            @endif

            @if (auth()->user()->hasPermission('read_clients'))
                <li><a href="{{ route('dashboard.clients.index') }}"><i class="fa fa-th"></i><span>@lang('site.clients')</span></a></li>
            @endif

            @if (auth()->user()->hasPermission('read_users'))
                <li><a href="{{ route('dashboard.users.index') }}"><i class="fa fa-th"></i><span>@lang('site.users')</span></a></li>
            @endif--}}

            {{--<li><a href="{{ route('dashboard.categories.index') }}"><i class="fa fa-book"></i><span>@lang('site.categories')</span></a></li>--}}
            {{----}}
            {{----}}
            {{--<li><a href="{{ route('dashboard.users.index') }}"><i class="fa fa-users"></i><span>@lang('site.users')</span></a></li>--}}

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

