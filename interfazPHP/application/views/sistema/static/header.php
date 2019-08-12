<header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="<?php echo base_url('images/task2.png');?>" width="30px" style="object-fit: contain;"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg" style="opacity:0.5;">TaskManager</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <?php $imagenPeril = base_url('images/profiles/'.$this->session->userdata('imagen'));?>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              
              <img src="<?php echo $imagenPeril; ?>" onerror="this.src='<?php echo base_url('images/default.jpg');?>'"  class="img-circle" width="20px" alt="User Image">
              <span class="hidden-xs"><?php echo $this->session->userdata('username'); ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <img src="<?php echo $imagenPeril; ?>" onerror="this.src='<?php echo base_url('images/default.jpg');?>'" width="30px" class="img-circle" alt="User Image">
                <p><?php echo $this->session->userdata('username'); ?>
                </p>
              </li>
            
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" id="showPerfil" class="btn btn-default btn-flat">User Data</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo site_url('inicio/logout')?>" class="btn btn-default btn-flat">Log Out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <aside class="main-sidebar">  
    <section class="sidebar">
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
				<li class="<?php echo isset($op_dashboard)?$op_dashboard:'';?>">
          <a href="<?php echo site_url('sistema');?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li><a href="<?php echo site_url('inicio/logout')?>"><i class="fa fa-circle-o text-red"></i> <span>Cerrar Sesión</span></a></li>
      </ul>
    </section>
   
  </aside>

	  