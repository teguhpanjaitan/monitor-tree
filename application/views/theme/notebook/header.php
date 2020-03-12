<header class="bg-dark dk header navbar navbar-fixed-top-xs">
  <div class="navbar-header aside-md">
    <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen,open" data-target="#nav,html">
      <i class="fa fa-bars"></i>
    </a>
    <a href="/" class="navbar-brand">Tree Management</a>
    <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user">
      <i class="fa fa-cog"></i>
    </a>
  </div>
  <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user">

    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <!--<span class="thumb-sm avatar pull-left">
              <img src="<?php echo base_url("assets/notebook/") ?>/images/avatar.jpg">
            </span>-->
        <?php echo get_display_name() ?> <b class="caret"></b>
      </a>
      <ul class="dropdown-menu animated fadeInRight">
        <span class="arrow top"></span>
        <li class="divider"></li>
        <li>
          <a href="<?php echo get_href("logout") ?>" data-toggle="ajaxModal">Logout</a>
        </li>
      </ul>
    </li>

  </ul>
</header>