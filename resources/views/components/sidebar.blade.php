<div id="sidebar-nav" class="sidebar">
  <div class="sidebar-scroll">
    <nav>
      <ul class="nav">
        <li><a href="{{ route('home') }}">
          <span>Dashboard</span></a>
        </li>
        @role('superuser')
        <li>
          <a href="#setup" data-toggle="collapse" class="collapsed">
            <span>Setup</span>
            <i class="icon-submenu fa fa-angle-right"></i>
          </a>
          <div id="setup" class="collapse ">
            <ul class="nav">
              <li><a href="{{ route('permissions.index') }}" ><span>Permission</span></a></li>
              <li><a href="{{ route('roles.index') }}" ><span>Role</span></a></li>
              <li><a href="{{ route('users.index') }}" ><span>User</span></a></li>
              <li><a href="{{ route('notifications.index') }}" ><span>Notifications</span></a></li>
            </ul>
          </div>
        </li>
        @endrole
        <li>
          <a href="#expedition" data-toggle="collapse" class="collapsed">
            <span>Ekspedisi</span>
            <i class="icon-submenu fa fa-angle-right"></i>
          </a>
          <div id="expedition" class="collapse ">
            <ul class="nav">
              <li>
                <a href="#expedition-setup" data-toggle="collapse" class="collapsed">
                  <span>Setup</span>
                  <i class="icon-submenu fa fa-angle-right"></i>
                </a>
                <div id="expedition-setup" class="collapse ">
                  <ul class="nav">
                    <li><a href="{{ route('vehicle_classes.index') }}" ><span>Jenis Kendaraan</span></a></li>
                    <li><a href="{{ route('vehicles.index') }}" ><span>Kendaraan</span></a></li>
                    <li><a href="{{ route('areas.index') }}" ><span>Area</span></a></li>
                    <li><a href="{{ route('customer_addons.index') }}" ><span>Customer Add On</span></a></li>
                    <li><a href="{{ route('costs.index') }}" ><span>Cost</span></a></li>
                    <li><a href="{{ route('cost_settings.index') }}" ><span>Setting Cost</span></a></li>
                    <li><a href="{{ route('employees.index') }}" ><span>Employee</span></a></li>
                    <li><a href="{{ route('etoll_cards.index') }}" ><span>EToll Card</span></a></li>
                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </li>
        <li><a href="{{ route('notif.index','unread') }}">
          <span>Notifikasi</span></a>
        </li>
        <!--
        <li><a href="notifications.html" class=""><i class="lnr lnr-alarm"></i> <span>Notifications</span></a></li>
        <li>
          <a href="#subPages" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>Pages</span> <i class="icon-submenu fa fa-angle-right"></i></a>
          <div id="subPages" class="collapse ">
            <ul class="nav">
              <li><a href="page-profile.html" class="">Profile</a></li>
              <li><a href="page-login.html" class="">Login</a></li>
              <li><a href="page-lockscreen.html" class="">Lockscreen</a></li>
            </ul>
          </div>
        </li>
        <li><a href="tables.html" class=""><i class="lnr lnr-dice"></i> <span>Tables</span></a></li>
        <li><a href="typography.html" class=""><i class="lnr lnr-text-format"></i> <span>Typography</span></a></li>
        <li><a href="icons.html" class=""><i class="lnr lnr-linearicons"></i> <span>Icons</span></a></li>
        -->
      </ul>
    </nav>
  </div>
</div>
