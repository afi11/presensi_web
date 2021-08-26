<header class="main-header " id="header">
    <nav class="navbar navbar-static-top navbar-expand-lg">
      <!-- Sidebar toggle button -->
      <button id="sidebar-toggler" class="sidebar-toggle">
        <span class="sr-only">Toggle navigation</span>
      </button>
      <div class="search-form d-none d-lg-inline-block"></div>

      <div class="navbar-right ">
        <ul class="nav navbar-nav">
          <!-- User Account -->
          <li class="dropdown user-menu">
            <button href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
              <span class="d-none d-lg-inline-block">{{ getUsername() }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-right">
              <!-- User image -->
              <li class="dropdown-header">
                <div class="d-inline-block">
                  {{ getUsername() }}
                </div>
              </li>
              <li class="dropdown-footer">
                <a href="{{ url('logout') }}"> <i class="mdi mdi-logout"></i> Log Out </a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>	