<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="#">
                    <img class="" alt="logo" height="50" width="50"
                        src="{{ asset('backend/app-assets/images/logo/newlnmu.gif') }}">
                    <h2 class="brand-text" style="color: #7C0000;">FileTracking</h2>
                    {{-- <h2 class="brand-text mb-0">LNMU</h2> --}}
                </a>
            </li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i
                        class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i
                        class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block primary"
                        data-ticon="icon-disc"></i></a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item"><a href="{{ route('filetrack.dashboard') }}"><i class="feather icon-home"></i><span
                        class="menu-title" data-i18n="Dashboard">Dashboard</span></a>
            </li>
            @can('File User')
            <li class=" nav-item"><a href="{{ route('filetrack.fileuser.index') }}"><i
                        class="feather icon-users"></i><span class="menu-title" data-i18n="Documentation">File
                        Users</span></a>
            </li>
            @endcan
            <li class=" nav-item"><a href="#"><i class="fa fa-folder-open"></i><span class="menu-title"
                        data-i18n="Starter kit">File System</span></a>
                <ul class="menu-content">
                    <ul class="menu-content">

                        @can('All File')
                            <li><a href="{{ route('filetrack.show-all') }}"><i></i><span class="menu-item"
                                        data-i18n="Roles">All Files</span></a>
                            </li>
                        @endcan


                        @canany(['All File_create', 'File_create'])
                            <li><a href="{{ route('filetrack.file-generate.index') }}"><i></i><span class="menu-item"
                                        data-i18n="Roles">Generate New File</span></a>
                            </li>
                            <li><a href="{{ route('filetrack.generated-Files') }}"><i></i><span class="menu-item"
                                data-i18n="Permissions">New Generated Files</span></a>
                             </li>
                        @endcanany

                       
                        @can(['File_read'])
                            <li><a href="{{ route('filetrack.file-generate.create') }}"><i></i><span class="menu-item"
                                        data-i18n="Permissions">My Files</span></a>
                            </li>
                        @endcan
                        @can('File_edit')
                            <li><a href="{{ route('filetrack.arriving-files') }}"><i></i><span class="menu-item"
                                        data-i18n="Permissions">Arriving Files</span></a>
                            </li>
                            <li><a href="{{ route('filetrack.pending-files') }}"><i></i><span class="menu-item"
                                        data-i18n="Permissions">Pending Files</span></a>
                            </li>
                        @endcan

                        <li><a href="{{ route('filetrack.pending-files') }}"><i></i><span class="menu-item"
                                    data-i18n="Permissions">Search Files</span></a>
                        </li>
                    </ul>
                </ul>
            </li>

            @can('Role Permission')
            <li class=" nav-item"><a href="#"><i class="feather icon-zap"></i><span class="menu-title"
                        data-i18n="Starter kit">Roles/Permissions</span></a>
                <ul class="menu-content">
                    <ul class="menu-content">
                        @can('Role Permission_create')
                        <li><a href="{{ route('filetrack.role.index') }}"><i></i><span class="menu-item"
                            data-i18n="Roles">Roles</span></a>
                        </li>
                        @endcan
                        @can('Role Permission_create')
                        <li><a href="{{ route('filetrack.permission.index') }}"><i></i><span class="menu-item"
                                    data-i18n="Permissions">Permissions</span></a>
                        </li>
                        @endcan
                        @can('Role Permission_edit')
                        <li><a href="{{ route('filetrack.userPermission') }}"><i></i><span class="menu-item"
                                    data-i18n="Assign Permission">Assign Permission</span></a>
                        </li>
                        @endcan
                        @can('Role Permission_edit')
                        <li><a href="{{ route('filetrack.roleHasPermission') }}"><i></i><span class="menu-item"
                                    data-i18n="Role Has Permission">Role Has Permission</span></a>
                        </li>
                        @endcan

                    </ul>
                </ul>
            </li>
            @endcan
        </ul>
    </div>
</div>
