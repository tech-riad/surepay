 <div class="page-sidebar">
    <ul class="list-unstyled accordion-menu">
       
       <li>
          <a href="<?=client_url('dashboard')?>"><i data-feather="home"></i>Dashboard</a>
       </li>

       <li class="sidebar-title">
          Main
       </li>
       <li>
         <a href="<?=client_url('add_funds')?>" class="ajaxModal"><i data-feather="plus-square"></i>Add Fund</a>          
       </li>
       <li>
          <a href="javascript:void(0)"><i data-feather="info"></i>Transaction<i class="fas fa-chevron-right dropdown-icon"></i></a>
          <ul class="multi">
             <li><a href="<?=client_url('transactions')?>"><i class="far fa-circle"></i>Transactions</a></li>
             <li><a href="<?=client_url('transactions/bank_transactions')?>"><i class="far fa-circle"></i>Bank Transactions</a></li>
             <li><a href="<?=client_url('transactions/add_manual_sms')?>" class="ajaxModal"><i class="far fa-circle"></i>Add Transaction</a> </li>
          </ul>
       </li> 

       <li>
          <a href="javascript:void(0)"><i data-feather="film"></i>Invoice<i class="fas fa-chevron-right dropdown-icon"></i></a>
          <ul class="multi">
             <li><a href="<?=client_url('invoice')?>"><i class="far fa-circle"></i>Invoices</a></li>
             <li><a href="<?=client_url('invoice/add')?>"><i class="far fa-circle"></i>Add Invoice</a></li>
          </ul>
       </li>

       <li class="sidebar-title">
          Elements
       </li>

       <li>
          <a href="javascript:void(0)"><i data-feather="cast"></i>Plans<i class="fas fa-chevron-right dropdown-icon"></i></a>
          <ul class="multi">
             <li><a href="<?=client_url('plans')?>"><i class="far fa-circle"></i>Plans</a></li>
             <li><a href="<?=client_url('plans/my_plan')?>"><i class="far fa-circle"></i>My Plans</a></li>
          </ul>
       </li>

       <li>
          <a href="<?=client_url('refferal')?>"><i data-feather="share-2"></i>Refferals</a>
       </li>

       <li>
          <a href="javascript:void(0)"><i data-feather="settings"></i>Settings<i class="fas fa-chevron-right dropdown-icon"></i></a>
          <ul class="multi">
             <li><a href="<?=client_url('settings')?>"><i class="far fa-circle"></i>Settings</a></li>
             <li><a href="<?=client_url('settings/api_credentials')?>"><i class="far fa-circle"></i>Credentials</a></li>
             <li><a href="<?=client_url('settings/domain_whitelist')?>"><i class="far fa-circle"></i>Domain Whitelist</a></li>
             <li><a href="<?=client_url('settings/devices')?>"><i class="far fa-circle"></i>Devices</a></li>
          </ul>
       </li>

       <li>
          <a href="<?=client_url('tickets')?>"><i data-feather="mail"></i>Tickets</a>
       </li>

       <li>
          <a href="<?=get_option('app_link')?>"><i data-feather="smartphone"></i>Mobile App</a>
       </li>

       <li>
          <a href="<?=base_url('developers')?>"><i data-feather="film"></i>Developer Docs</a>
       </li>
       <li>
          <a href="<?=base_url()?>" target="_blank"><i data-feather="globe"></i>Main Site</a>
        </li>
    </ul>
 </div>