
<li class="nav-item has-treeview">
  <a href="{{url('admin/dashboard/')}}" class="nav-link">
    <i class="nav-icon fas fa-tachometer-alt"></i>
    <p>
      Dashboard
    </p>
  </a>
</li>

@if(Auth::user()->is_super_admin != 0)
<!-- FuelShop Menu -->
<li class="nav-item has-treeview ">
  <a href="" class="nav-link">
    <i class="nav-icon fas fa-gas-pump"></i>
    <p>
      Fuel Shop
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{url('admin/shops/create')}}" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Add Fuel Shop</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{url('admin/shops')}}" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Fuel Shop List</p>
      </a>
    </li>
  </ul>
</li>
@endif

<li class="nav-item has-treeview ">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-users"></i>
    <p>
      Users
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{url('admin/users/create')}}" class="nav-link ">
        <i class="far fa-circle nav-icon"></i>
        <p>Add User</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{url('admin/users')}}" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>User List</p>
      </a>
    </li>
  </ul>
</li>

<!-- FuelShop Menu -->
<li class="nav-item has-treeview ">
  <a href="" class="nav-link">
    <i class="nav-icon fas fa-burn"></i>
    <p>
     Product
     <i class="right fas fa-angle-left"></i>
   </p>
 </a>
 <ul class="nav nav-treeview">
  <li class="nav-item">
    <a href="{{url('admin/products/create')}}" class="nav-link">
      <i class="far fa-circle nav-icon"></i>
      <p>Add  Product</p>
    </a>
  </li>
  <li class="nav-item">
    <a href="{{url('admin/products')}}" class="nav-link">
      <i class="far fa-circle nav-icon"></i>
      <p> Product list</p>
    </a>
  </li>
  <li class="nav-item">
    <a href="{{url('admin/price_histories')}}" class="nav-link">
      <i class="far fa-circle nav-icon"></i>
      <p> Product Price History</p>
    </a>
  </li>
</ul>
</li>

<!-- Tank Menu -->
<li class="nav-item has-treeview ">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-water"></i>
    <p>
      Tank
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{url('admin/tanks/create')}}" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Add Tank</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{url('admin/tanks')}}" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Tank List</p>
      </a>
    </li>
  </ul>
</li>


<li class="nav-item has-treeview ">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-male"></i>
    <p>
      Purchase
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{url('admin/purchases/create')}}" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Add Purchase</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{url('admin/purchases')}}" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Purchase List</p>
      </a>
    </li>
  </ul>
</li>

<li class="nav-item has-treeview ">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-tachometer-alt"></i>
    <p>
      Adjustment
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{url('admin/adjustments/create')}}" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Add Adjustment</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{url('admin/adjustments')}}" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Adjustment List</p>
      </a>
    </li>
  </ul>
</li>

<!-- Station Menu -->
<li class="nav-item has-treeview ">
  <a href="" class="nav-link">
    <i class="nav-icon fas fa-gas-pump"></i>
    <p>
      Pumps
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{url('admin/pumps/create')}}" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Add Pump</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{url('admin/pumps')}}" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Pump List</p>
      </a>
    </li>
  </ul>
</li>
<!-- Vehicle Menu -->
<li class="nav-item has-treeview ">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-truck-moving"></i>
    <p>
      Business Type
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{url('admin/businesses/create')}}" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Add Business Type</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{url('admin/businesses')}}" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Business Type List</p>
      </a>
    </li>
  </ul>
</li>
@if(auth()->user()->shop->confirmed_nozzle == 1)
  <!-- Pump Menu -->
<li class="nav-item has-treeview ">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fas fa-gas-pump"></i>
    <p>
      Nozzles
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{url('admin/nozzles/create')}}" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Add Nozzles</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{url('admin/nozzles')}}" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Nozzles List</p>
      </a>
    </li>
  </ul>
</li>
@endif
<!-- Counter Menu -->
<li class="nav-item has-treeview ">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-cash-register"></i>
    <p>
      Counter
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{url('admin/counters/create')}}" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Add Counter</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{url('admin/counters')}}" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Counter List</p>
      </a>
    </li>
  </ul>
</li>
<!-- Sales Menu -->
<li class="nav-item has-treeview ">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-shopping-cart"></i>
    <p>
      Sales
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{url('admin/sales')}}" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Sales</p>
      </a>
      <a href="{{url('admin/daily-sales')}}" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Daily Sales</p>
      </a>
      <a href="{{url('admin/sales-histories')}}" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Sales Histories</p>
      </a>
    </li>
  </ul>
</li>