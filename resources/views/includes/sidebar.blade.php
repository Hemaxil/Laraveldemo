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
        <!-- Optionally, you can add icons to the cogs -->
        <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard fw"></i> <span >Dashboard</span></a></li>  
        <li><a href="{{route('categories.index')}}"><i class="fa fa-cog"></i> <span >Category Management</span></a></li>
        <li><a href="{{route('products.index')}}"><i class="fa fa-cog"></i> <span >Product Management</span></a></li>
        <li><a href="{{route('coupons.index')}}"><i class="fa fa-cog"></i> <span >Coupon Management</span></a></li>
        <li><a href="{{route('configurations.index')}}"><i class="fa fa-cog"></i> <span >Configuration Management</span></a></li>
        <li><a href="{{route('banners.index')}}"><i class="fa fa-cog"></i> <span >Banner Management</span></a></li>
         <li class="treeview">
                <a href="#"><i class="fa fa-cog"></i> <span>Attributes Management</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href={{route('product_attributes.index')}}>Attribute Management</a></li>
                  <li><a href={{route('product_attributes_values.index')}}>Attribute Values Management</a></li>
              
                </ul>
            </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-cog"></i> <span>Users & Roles Management</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href={{route('users.index')}}>User Management</a></li>
            <li><a href={{route('roles.index')}}>Role Management</a></li>
             
          </ul>
        </li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>