<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->


    <a class="btn btn-success btn-sm"> Ranking Web</a>

    <li class="nav-item ">
        <a class="nav-link" href="index.html">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    @if (Auth::user()->roleUser['role'] == 'Admin')
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
                    <a class="collapse-item" href="{{ url('/admin/subcategory/compar/list/1') }}">Subcategory Compar List</a>

                </div>
            </div>
        </li>

        <!-- Divider -->
    @endif
    <!-- Nav Item - Dashboard -->


    <!-- Divider -->

    <hr class="sidebar-divider">

    <!-- Heading -->


</ul>
<!-- End of Sidebar -->
