@extends('layouts.admin')

@section('title','')

@section('content')

<style>

.dashboard-card{
    border-radius:12px;
    padding:20px;
    color:white;
    position:relative;
    overflow:hidden;
    box-shadow:0 8px 20px rgba(0,0,0,0.1);
    transition:0.3s;
}

.dashboard-card:hover{
    transform:translateY(-5px);
    box-shadow:0 12px 25px rgba(0,0,0,0.2);
}

.dashboard-card .count{
    font-size:32px;
    font-weight:bold;
}

.dashboard-card .title{
    font-size:16px;
    opacity:0.9;
}

.dashboard-icon{
    position:absolute;
    right:20px;
    bottom:10px;
    font-size:45px;
    opacity:0.3;
}

/* Colors */

.bg-users{
    background:linear-gradient(135deg,#36d1dc,#5b86e5);
}

.bg-roles{
    background:linear-gradient(135deg,#11998e,#38ef7d);
}

.bg-permissions{
    background:linear-gradient(135deg,#f7971e,#ffd200);
}

.bg-license{
    background:linear-gradient(135deg,#ff512f,#dd2476);
}

</style>


<div class="row">

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="dashboard-card bg-users">
            <div class="count">{{ \App\Models\User::count() }}</div>
            <div class="title">Total Users</div>
            <div class="dashboard-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>


    <div class="col-lg-3 col-md-6 mb-4">
        <div class="dashboard-card bg-roles">
            <div class="count">{{ \App\Models\Role::count() }}</div>
            <div class="title">Total Roles</div>
            <div class="dashboard-icon">
                <i class="fas fa-user-shield"></i>
            </div>
        </div>
    </div>


    <div class="col-lg-3 col-md-6 mb-4">
        <div class="dashboard-card bg-permissions">
            <div class="count">{{ \App\Models\Permission::count() }}</div>
            <div class="title">Total Permissions</div>
            <div class="dashboard-icon">
                <i class="fas fa-key"></i>
            </div>
        </div>
    </div>


    <div class="col-lg-3 col-md-6 mb-4">
        <div class="dashboard-card bg-license">
            <div class="count">{{ \App\Models\License::count() }}</div>
            <div class="title">Total License</div>
            <div class="dashboard-icon">
                <i class="fas fa-id-card"></i>
            </div>
        </div>
    </div>

</div>

@endsection
