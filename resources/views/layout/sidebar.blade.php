<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion " id="accordionSidebar">

    <!-- Sidebar - Brand -->

    <div class="sidebar-brand"
        style="width: 100%;height : 50px;display: flex; box-sizing: border-box;padding: 5px 5px 0 5px; justify-content: center">
        <img class="sidebar-brand-icon " src="{{ url('/image/jb.png') }}" style="height: 100%">
        <h6 class="sidebar-brand-text" style="color: White;font-weight: bolder">Website Perankingan Siswa</h6>
    </div>
    @if (Auth::user()->role_id == 1)
        <li class="nav-item mt-4">
            <a class="nav-link" href="{{ url('/admin') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
    @else
        <li class="nav-item mt-4">
            <a class="nav-link" href="{{ url('/') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
    @endIf


    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Settings
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ isset($view) && $view == 'Category' ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo2"
            aria-expanded="true" aria-controls="collapseTwo2">
            <i class="fas fa-fw fa-cog"></i>
            <span>Account</span>
        </a>
        <div id="collapseTwo2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Account Settings</h6>
                @if (Auth::user()->role_id == 1)
                    <a class="collapse-item" href="{{ url('/admin/user') }}">List User</a>

                    <a class="collapse-item" href="{{ url('/admin/settings') }}">App Settings</a>
                @endif
                <a class="collapse-item" href="{{ url('/profile') }}">Profile</a>

                <a class="collapse-item" href="{{ url('/change-password') }}">Change Password</a>
            </div>
        </div>
    </li>
    <!-- Divider -->

    @if (Auth::user()->roleUser['role'] == 'Admin')
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Kriteria
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item {{ isset($view) && $view == 'Category' ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Category</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">management Category :</h6>
                    <a class="collapse-item" href="{{ url('/admin/category') }}">List Category</a>
                    <a class="collapse-item" href="{{ url('/admin/category/add') }}">Add Category</a>
                    <a class="collapse-item" href="{{ url('/admin/category/compar') }}">Compare Category</a>
                    <a class="collapse-item" href="{{ url('/admin/category/compar/list') }}">List Comparation
                        Category</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Sub Category</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Manajemen Sub Category :</h6>
                    <a class="collapse-item" href="{{ url('/admin/subcategory') }}">List Subcategory</a>
                    <a class="collapse-item" href="{{ url('/admin/subcategory/add') }}">Add Subcategory</a>
                    <a class="collapse-item" href="{{ url('/admin/subcategory/compar/1') }}">Subcategory Compar</a>
                    <a class="collapse-item" href="{{ url('/admin/subcategory/compar/list/1') }}">Subcategory Compar
                        List</a>

                </div>
            </div>
        </li>

        <!-- Divider -->
    @else
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Test Data
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item {{ isset($view) && $view == 'Category' ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Category</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Category :</h6>
                    <a class="collapse-item" href="{{ url('/category') }}">List Category</a>

                    <a class="collapse-item" href="{{ url('/category/compar/list') }}">List Comparation
                        Category</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Sub Category</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Manajemen Sub Category :</h6>
                    <a class="collapse-item" href="{{ url('/subcategory') }}">List Subcategory</a>

                    <a class="collapse-item" href="{{ url('/subcategory/compar/list/1') }}">Subcategory
                        Compar
                        List</a>

                </div>
            </div>
        </li>
    @endIf
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Alternative Data
    </div>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities2"
            aria-expanded="true" aria-controls="collapseUtilities2">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Alternative Data</span>
        </a>
        <div id="collapseUtilities2" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Manajemen Sub Category :</h6>
                <a class="collapse-item" href="{{ url('/mahasiswa/add') }}">Add Mahasiswa</a>
                <a class="collapse-item" href="{{ url('/mahasiswa') }}">List Mahasiswa</a>
                <a class="collapse-item" href="{{ url('/alternative-data') }}">Alternative Data</a>
                <a class="collapse-item" href="{{ url('/mahasiswa-ranking') }}">Rangking Mahasiswa</a>

            </div>
        </div>
    </li>
    <!-- Nav Item - Dashboard -->


    <!-- Divider -->

    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


    <!-- Heading -->


</ul>
<!-- End of Sidebar -->
