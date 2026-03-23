<aside class="main-sidebar elevation-4 sidebar-theme">

@php
$setting = \App\Models\Setting::first();

$logo = \App\Models\Media::where('model_type',\App\Models\Setting::class)
->where('model_id',optional($setting)->id)
->where('collection_name','logo')
->first();
@endphp

<a href="{{ route('dashboard') }}" class="brand-link">

@if($logo)

<img src="{{ asset('storage/settings/'.$logo->file_name) }}"
alt="Logo"
style="height:35px;width:auto;margin-right:8px">

@endif

<span class="brand-text font-weight-light">
<b>{{ $setting->app_name ?? 'ET-ADV' }}</b>
</span>

</a>

<div class="sidebar">

<nav class="mt-2">

<ul class="nav nav-pills nav-sidebar flex-column"
data-widget="treeview"
role="menu"
data-accordion="false">

<li class="nav-item">

<a href="{{ route('dashboard') }}"
class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">

<i class="nav-icon fas fa-tachometer-alt"></i>

<p>Dashboard</p>

</a>

</li>


{{-- USER MANAGEMENT --}}

@canany(['user-list','role-list','permission-list'])

<li class="nav-item has-treeview">

<a href="#" class="nav-link">

<i class="nav-icon fas fa-users"></i>

<p>
User Management
<i class="right fas fa-angle-left"></i>
</p>

</a>

<ul class="nav nav-treeview">

@can('user-list')

<li class="nav-item">

<a href="{{ route('admin.users.index') }}"
class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">

<i class="far fa-circle nav-icon"></i>

<p>Users</p>

</a>

</li>

@endcan

@can('role-list')

<li class="nav-item">

<a href="{{ route('admin.roles.index') }}"
class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">

<i class="far fa-circle nav-icon"></i>

<p>Roles</p>

</a>

</li>

@endcan

@can('permission-list')

<li class="nav-item">

<a href="{{ route('admin.permissions.index') }}"
class="nav-link {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}">

<i class="far fa-circle nav-icon"></i>

<p>Permissions</p>

</a>

</li>

@endcan

</ul>

</li>

@endcanany



{{-- ================= VEHICLE TRACKING ================= --}}

@canany(['vehicle-live-map','vehicle-history','geofence-manage','alert-view'])

<li class="nav-item has-treeview">

<a href="#" class="nav-link">

<i class="nav-icon fas fa-map-marker-alt"></i>

<p>
Vehicle Tracking
<i class="right fas fa-angle-left"></i>
</p>

</a>

<ul class="nav nav-treeview">

@can('vehicle-live-map')

<li class="nav-item">

<a href="{{ route('admin.vehicles.map') }}"
class="nav-link {{ request()->routeIs('admin.vehicles.map') ? 'active' : '' }}">

<i class="far fa-circle nav-icon"></i>

<p>Live Tracking</p>

</a>

</li>

@endcan


@can('vehicle-history')

<li class="nav-item">

<a href="{{ route('admin.vehicles.history') }}"
class="nav-link {{ request()->routeIs('admin.vehicles.history') ? 'active' : '' }}">

<i class="far fa-circle nav-icon"></i>

<p>Vehicle History</p>

</a>

</li>

@endcan


@can('geofence-manage')

<li class="nav-item">

<a href="{{ route('admin.geofences.index') }}"
class="nav-link {{ request()->routeIs('admin.geofences.*') ? 'active' : '' }}">

<i class="far fa-circle nav-icon"></i>

<p>Geofence</p>

</a>

</li>

@endcan


@can('alert-view')

<li class="nav-item">

<a href="{{ route('admin.alerts.index') }}"
class="nav-link {{ request()->routeIs('admin.alerts.*') ? 'active' : '' }}">

<i class="far fa-circle nav-icon"></i>

<p>Alerts</p>

</a>

</li>

@endcan

</ul>

</li>

@endcanany



@canany(['license-list','license-create'])

<li class="nav-item has-treeview">

<a href="#" class="nav-link">

<i class="nav-icon fas fa-key"></i>

<p>
License Management
<i class="right fas fa-angle-left"></i>
</p>

</a>

<ul class="nav nav-treeview">

@can('license-list')

<li class="nav-item">

<a href="{{ route('admin.licenses.index') }}"
class="nav-link {{ request()->routeIs('admin.licenses.*') ? 'active' : '' }}">

<i class="far fa-circle nav-icon"></i>

<p>Licenses</p>

</a>

</li>

@endcan


@can('license-create')

<li class="nav-item">

<a href="{{ route('admin.licenses.create') }}"
class="nav-link {{ request()->routeIs('admin.licenses.create') ? 'active' : '' }}">

<i class="far fa-circle nav-icon"></i>

<p>Create License</p>

</a>

</li>

@endcan

</ul>

</li>

@endcanany



@canany(['stock-view','stock-transfer','stock-report'])

<li class="nav-item has-treeview">

<a href="#" class="nav-link">

<i class="nav-icon fas fa-boxes"></i>

<p>
Stock Management
<i class="right fas fa-angle-left"></i>
</p>

</a>

<ul class="nav nav-treeview">

@can('stock-view')

<li class="nav-item">

<a href="{{ route('admin.stocks.index') }}"
class="nav-link {{ request()->routeIs('admin.stocks.*') ? 'active' : '' }}">

<i class="far fa-circle nav-icon"></i>

<p>Current Stocks</p>

</a>

</li>

@endcan


@can('stock-transfer')

<li class="nav-item">

<a href="{{ route('admin.license-transfer.index') }}"
class="nav-link">

<i class="far fa-circle nav-icon"></i>

<p>Transfer Stocks</p>

</a>

</li>

@endcan


@can('stock-report')

<li class="nav-item">

<a href="{{ route('admin.stock-report.index') }}"
class="nav-link">

<i class="far fa-circle nav-icon"></i>

<p>Stock Reports</p>

</a>

</li>

@endcan

</ul>

</li>

@endcanany
@canany(['wallet-view','wallet-transaction-view','wallet-history-view'])

<li class="nav-item has-treeview">

<a href="#" class="nav-link">

<i class="nav-icon fas fa-wallet"></i>

<p>
Wallet Management
<i class="right fas fa-angle-left"></i>
</p>

</a>

<ul class="nav nav-treeview">

@can('wallet-view')

<li class="nav-item">

<a href="{{ route('admin.wallets.index') }}"
class="nav-link {{ request()->routeIs('admin.wallets.*') ? 'active' : '' }}">

<i class="far fa-circle nav-icon"></i>

<p>Wallets</p>

</a>

</li>

@endcan


@can('wallet-transaction-view')

<li class="nav-item">

<a href="{{ route('admin.transactions.index') }}"
class="nav-link">

<i class="far fa-circle nav-icon"></i>

<p>Transactions</p>

</a>

</li>

@endcan




</ul>

</li>

@endcanany
</ul>

</nav>

</div>

</aside>



<style>
    /* ================================
   SIDEBAR BASE THEME
================================ */

.sidebar-theme{
background:#1f2937;
transition:all .3s ease;
}

/* ================================
   NAVBAR + SIDEBAR COLOR THEMES
================================ */

/* BLUE THEME */

.theme-blue .main-header{
background:#1e40af !important;
}

.theme-blue .main-sidebar{
background:#1e3a8a !important;
}


/* GREEN THEME */

.theme-green .main-header{
background:#065f46 !important;
}

.theme-green .main-sidebar{
background:#064e3b !important;
}


/* RED THEME */

.theme-red .main-header{
background:#7f1d1d !important;
}

.theme-red .main-sidebar{
background:#991b1b !important;
}


/* DARK THEME */

.theme-dark .main-header{
background:#111827 !important;
}

.theme-dark .main-sidebar{
background:#111827 !important;
}



/* ================================
   RTL LAYOUT SUPPORT
================================ */

[dir="rtl"] body{
direction:rtl;
text-align:right;
}


/* SIDEBAR POSITION */

[dir="rtl"] .main-sidebar{
right:0;
left:auto;
}




/* SIDEBAR COLLAPSE SUPPORT */

[dir="rtl"].sidebar-collapse .content-wrapper,
[dir="rtl"].sidebar-collapse .main-footer,
[dir="rtl"].sidebar-collapse .main-header{
margin-right:0;
}


/* NAVBAR ITEMS */

[dir="rtl"] .navbar-nav{
flex-direction:row-reverse;
}


/* TREEVIEW ARROW FIX */

[dir="rtl"] .nav-sidebar .nav-link > .right{
left:1rem;
right:auto;
transform:rotate(180deg);
}


/* SIDEBAR ICON SPACE */

[dir="rtl"] .nav-sidebar .nav-link > .nav-icon{
margin-left:.5rem;
margin-right:0;
}


/* ================================
   DATATABLE RTL SUPPORT
================================ */

[dir="rtl"] div.dataTables_wrapper .dataTables_filter{
float:left;
text-align:left;
}

[dir="rtl"] div.dataTables_wrapper .dataTables_length{
float:right;
}

[dir="rtl"] div.dataTables_wrapper .dt-buttons{
float:right;
}

[dir="rtl"] div.dataTables_wrapper .dataTables_paginate{
float:left;
}



/* ================================
   TRANSITIONS
================================ */


</style>
