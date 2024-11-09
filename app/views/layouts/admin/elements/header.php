<div class="page-header">
	<nav class="navbar navbar-expand-lg d-flex justify-content-between">
	   <div class="" id="navbarNav">
	      <ul class="navbar-nav" id="leftNav">
	         <li class="nav-item">
	            <a class="nav-link" id="sidebar-toggle" href="#"><i data-feather="menu"></i></a>
	         </li>
	         <li class="nav-item">
	            <a class="nav-link" href="<?=admin_url('dashboard')?>"><?=get_option('website_name')?></a>
	         </li>
	      </ul>
	   </div>
	   <div class="logo">
	      <a class="navbar-brand" href="<?=client_url('dashboard')?>"><img style="height:100%" src="<?=PATH.get_option('website_logo')?>"></a>
	   </div>
	   <div class="" id="headerNav">
	      <ul class="navbar-nav">
	         
	         <li class="nav-item dropdown">
	            <a class="nav-link profile-dropdown" href="#" id="profileDropDown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img class="rounded-circle" src="<?=get_avatar()?>" alt="Admin"></a>
	            <div class="dropdown-menu dropdown-menu-end profile-drop-menu" aria-labelledby="profileDropDown">
	               <a class="dropdown-item" href="<?=admin_url('profile')?>"><i data-feather="user"></i>Profile</a>
	               <a class="dropdown-item" href="<?=admin_url('logout')?>"><i data-feather="log-out"></i>Logout</a>
	            </div>
	         </li>
	      </ul>
	   </div>
	</nav>
</div>