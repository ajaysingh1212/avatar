<aside class="main-sidebar sidebar-dark-primary elevation-4">

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
role="menu">

<li class="nav-item">

<a href="{{ route('dashboard') }}"
class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">

<i class="nav-icon fas fa-tachometer-alt"></i>

<p>Dashboard</p>

</a>

</li>

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

{{-- LIVE TRACKING --}}

@can('vehicle-live-map')

<li class="nav-item">

<a href="{{ route('admin.vehicles.map') }}"
class="nav-link {{ request()->routeIs('admin.vehicles.map') ? 'active' : '' }}">

<i class="far fa-circle nav-icon"></i>

<p>Live Tracking</p>

</a>

</li>

@endcan


{{-- VEHICLE HISTORY --}}

@can('vehicle-history')

<li class="nav-item">

<a href="{{ route('admin.vehicles.history') }}"
class="nav-link {{ request()->routeIs('admin.vehicles.history') ? 'active' : '' }}">

<i class="far fa-circle nav-icon"></i>

<p>Vehicle History</p>

</a>

</li>

@endcan


{{-- GEOFENCE --}}

@can('geofence-manage')

<li class="nav-item">

<a href="{{ route('admin.geofences.index') }}"
class="nav-link {{ request()->routeIs('admin.geofences.*') ? 'active' : '' }}">

<i class="far fa-circle nav-icon"></i>

<p>Geofence</p>

</a>

</li>

@endcan


{{-- ALERTS --}}

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
<a href="{{ route('admin.stock-transfer.create') }}"
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
@canany(['license-stock','license-transfer'])

<li class="nav-item has-treeview">

<a href="#" class="nav-link">

<i class="nav-icon fas fa-boxes"></i>

<p>
License Stock
<i class="right fas fa-angle-left"></i>
</p>

</a>

<ul class="nav nav-treeview">

@can('license-stock')

<li class="nav-item">

<a href="{{ route('admin.license-stock.index') }}"
class="nav-link {{ request()->routeIs('admin.license-stock.*') ? 'active' : '' }}">

<i class="far fa-circle nav-icon"></i>
<p>Current Stock</p>

</a>

</li>

@endcan


@can('license-transfer')

<li class="nav-item">

<a href="{{ route('admin.license-transfer.create') }}"
class="nav-link {{ request()->routeIs('admin.license-transfer.*') ? 'active' : '' }}">

<i class="far fa-circle nav-icon"></i>
<p>Transfer License</p>

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
