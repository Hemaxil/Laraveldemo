<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- search form (Optional) -->
{{--       <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
        </div>
      </form> --}}
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header"><span class="fa fa-bars"></span><b>Navigation</b></li>
        <!-- Optionally, you can add icons to the links -->
        <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard fw"></i> <span >Dashboard</span></a></li>
        
        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Catalog</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href={{route('categories.index')}}>Categories</a></li>
            <li><a href={{route('products.index')}}>Products</a></li>
            <li><a href={{route('coupons.index')}}>Coupons</a></li>
            <li class="treeview">
                <a href="#"><i class="fa fa-link"></i> <span>Attributes</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href={{route('product_attributes.index')}}>Attributes</a></li>
                  <li><a href={{route('product_attributes_values.index')}}>Attribute Values</a></li>
              
                </ul>
            </li>
          </ul>
        </li>


        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Users,Roles</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href={{route('users.index')}}>Users</a></li>
            <li><a href={{route('roles.index')}}>Roles</a></li>
             
          </ul>
        </li>

        <li><a href="{{route('configurations.index')}}"><i class="fa fa-link"></i> <span >Configurations</span></a></li>

        <li><a href="{{route('banners.index')}}"><i class="fa fa-link"></i> <span >Banners</span></a></li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>