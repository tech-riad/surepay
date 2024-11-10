 <div class="page-sidebar">
    <ul class="list-unstyled accordion-menu">
       
       <li>
          <a href="<?=admin_url('dashboard')?>"><i data-feather="home"></i>Dashboard</a>
       </li>

       <li class="sidebar-title">
          Main
       </li>
       <li>
          <a href="javascript:void(0)"><i data-feather="users"></i>Users<i class="fas fa-chevron-right dropdown-icon"></i></a>
          <ul class="multi">
             <li><a href="<?=admin_url('users')?>"><i class="far fa-circle"></i>Users</a></li>
             <li><a href="<?=admin_url('users/update')?>"><i class="far fa-circle"></i>Add User</a></li>
          </ul>
       </li>
       <li>
          <a href="javascript:void(0)"><i data-feather="film"></i>Staff<i class="fas fa-chevron-right dropdown-icon"></i></a>
          <ul class="multi">
             <li><a href="<?=admin_url('staffs')?>"><i class="far fa-circle"></i>Staffs</a></li>
             <li><a href="<?=admin_url('staffs/update')?>"><i class="far fa-circle"></i>Add Staff</a></li>
          </ul>
       </li>
       <li>
          <a href="<?=admin_url('transactions')?>"><i data-feather="info"></i>Transactions</a>
       </li>
       
       <li>
          <a href="javascript:void(0)"><i data-feather="film"></i>Invoice<i class="fas fa-chevron-right dropdown-icon"></i></a>
          <ul class="multi">
             <li><a href="<?=admin_url('invoice')?>"><i class="far fa-circle"></i>Invoices</a></li>
             <li><a href="<?=admin_url('invoice/update')?>"><i class="far fa-circle"></i>Add Invoice</a></li>
          </ul>
       </li>

       <li>
          <a href="<?=admin_url('domain')?>"><i data-feather="info"></i>Domains</a>
       </li>
       <li>
          <a href="<?=admin_url('devices')?>"><i data-feather="info"></i>Devices</a>
       </li>
       <li>
          <a href="<?=admin_url('settings')?>"><i data-feather="settings"></i>Settings</a>
       </li>

       <li class="sidebar-title">
          Elements
       </li>
       <li>
          <a href="javascript:void(0)"><i data-feather="cast"></i>Plans<i class="fas fa-chevron-right dropdown-icon"></i></a>
          <ul class="multi">
             <li><a href="<?=admin_url('plans')?>"><i class="far fa-circle"></i>Plans</a></li>
             <li><a href="<?=admin_url('plans/user_plan')?>"><i class="far fa-circle"></i>User Plans</a></li>
          </ul>
       </li>
       <li>
          <a href="<?=admin_url('payments')?>"><i data-feather="archive"></i>Payment Methods</a>
       </li>

       <li class="sidebar-title">
          Extras
       </li>

       <li>
          <a href="javascript:void(0)"><i data-feather="settings"></i>Extra Settings<i class="fas fa-chevron-right dropdown-icon"></i></a>
          <ul class="multi">
             <li><a href="<?=admin_url('faqs')?>"><i class="far fa-circle"></i>Faq</a></li>
             <li><a href="<?=admin_url('coupon')?>"><i class="far fa-circle"></i>Coupons</a></li>
             <li><a href="<?=admin_url('developers')?>"><i class="far fa-circle"></i>Developers page</a></li>
          </ul>
       </li>

       <li>
          <a href="<?=admin_url('tickets')?>"><i data-feather="mail"></i>Tickets</a>
       </li>
       <li>
          <a href="<?=base_url()?>" target="_blank"><i data-feather="globe"></i>Main Site</a>
        </li>

       <li>
          <a href="<?=admin_url('dbbackup')?>"><i data-feather="database"></i>DataBackup</a>
       </li>



       
    </ul>
 </div>