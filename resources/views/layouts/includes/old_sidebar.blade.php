<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ $user->avatar }}" class="img-circle" alt="{{ trans('user.avatar.label') }}">
            </div>
            <div class="pull-left info">
                <p>{{ $user->info }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <!-- Optionally, you can add icons to the links -->
            <li {{ setActive(route('admin.index')) }}>
                <a href="{{ route('admin.index') }}"><i class="fa fa-home"></i>
                    <span>{{ trans('site.dashboard') }}</span>
                </a>
            </li>
            <li {{ setActive()->all(route('admin.user.index')) }} class="treeview">
                <a href="#"><i class="fa fa-users"></i>
                    <span>Users</span>
                    <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li {{ setActive(route('admin.user.index')) }}><a href="{{ route('admin.user.index') }}"><i class="fa fa-list"></i> All Users</a></li>
                    <li {{ setActive(route('admin.user.create')) }}><a href="{{ route('admin.user.create') }}"><i class="fa fa-user-plus"></i> New User</a></li>
                    <li>
                        <a href="#"><i class="fa fa-ban"></i> Banned Users <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ route('mod.banned.create') }}" target="_blank"><i class="fa fa-user-times"></i> Ban a User</a></li>
                            <li>
                                <a href="{{ route('mod.banned.index') }}" target="_blank"><i class="fa fa-list"></i> Banned Users</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li {{ setActive()->all(route('admin.role.index')) }} class="treeview">
                <a href="#"><i class="fa fa-shield"></i>
                    <span>User Roles</span>
                    <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li {{ setActive(route('admin.role.index')) }}><a href="{{ route('admin.role.index') }}"><i class="fa fa-list"></i> View Roles</a></li>
                    <li {{ setActive(route('admin.role.create')) }}><a href="{{ route('admin.role.create') }}"><i class="fa fa-plus"></i> New Role</a></li>
                    <li {{ setActive(route('admin.role.permission.index')) }}><a href="{{ route('admin.role.permission.index') }}"><i class="fa fa-circle-o"></i> Permissions</a></li>
                    <li  {{ setActive(route('admin.role.permission.create')) }}><a href="{{ route('admin.role.permission.create') }}"><i class="fa fa-plus-circle"></i> New Permission</a></li>
                </ul>
            </li>

            <li {{ setActive()->all(route('admin.forum.index')) }} class="treeview">
                <a href="#">
                    <i class="fa fa-comments"></i>
                    <span>Forum</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li {{ setActive(route('admin.forum.index')) }}><a href="{{ route('admin.forum.index') }}"><i class="fa fa-list-alt"></i> View Forums</a></li>
                    <li {{ setActive(route('admin.forum.create')) }}><a href="{{ route('admin.forum.create') }}"><i class="fa fa-plus"></i> New Forum</a></li>
                </ul>
            </li>

            <li class="header">SETTINGS</li>
            <li class="treeview">
                <a href="#"><i class="fa fa-gear"></i>
                    <span>Configuration</span>
                    <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    @foreach($setting_groups as $group)
                        <li><a href="{{ route('admin.config.index', $group->id) }}"><i class="{{ $group->icon }}"></i> {{ $group->name }}</a></li>
                    @endforeach
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-wrench"></i>
                    <span>Tools</span>
                    <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.tools.site.health') }}"><i class="fa fa-medkit"></i> Site Health</a></li>
                    <li><a href="{{ route('admin.tools.cache.manager') }}"><i class="fa fa-hdd-o"></i> Cache Manager</a></li>
                    <li><a href="{{ route('admin.tools.php.info') }}"><i class="fa fa-info"></i> PHP Info</a></li>
                    <li><a href="{{ route('admin.tools.database.rebuild') }}"><i class="fa fa-database"></i> Rebuild Database</a></li>
                    <li><a href="{{ route('admin.tools.stats.recount') }}"><i class="fa fa-list-ol"></i> Recount Stats</a></li>
                </ul>
            </li>



        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>