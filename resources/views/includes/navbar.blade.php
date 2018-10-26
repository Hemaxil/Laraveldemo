 <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          <!-- User Account Menu -->
          @auth
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <img src={{asset("dist/img/user2-160x160.jpg")}} class="user-image" alt="User Image">
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs">{{Auth::user()->firstname}}</span>
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                  <img src={{asset("dist/img/user2-160x160.jpg")}} class="img-circle" alt="User Image">

                  <p>
                   {{Auth::user()->firstname}}
                    
                  </p>
                </li>
               
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                   {{--  <a href={{route('users.show',['user'=>Auth::user()])}} class="btn btn-default btn-flat">Profile</a> --}}
                  </div>
                  <div class="pull-right">
                     <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <input type="submit" value="Sign out" class="btn btn-default">
                      </form>
                   {{--  <a href="{{route('logout')}}" class="btn btn-default btn-flat">Sign out</a> --}}
                  </div>
                </li>
              </ul>
            </li>
          @endauth
         
        </ul>
      </div>
    </nav>