@extends('layouts.admin')

@section('title','View Settings')

@section('content')

<style>

.settings-wrapper{
background:#111827;
padding:25px;
border-radius:10px;
}

.settings-card{
background:#1f2937;
color:#fff;
}

.info-box{
background:#111827;
padding:12px;
border-radius:6px;
margin-bottom:10px;
}

</style>

<div class="settings-wrapper">

<div class="card settings-card">

<div class="card-header">
<h3>Application Settings Details</h3>
</div>

<div class="card-body">

<div class="row">

<div class="col-md-4">

<div class="info-box">

<strong>App Name</strong><br>

{{ $setting->app_name }}

</div>

</div>

<div class="col-md-4">

<div class="info-box">

<strong>Time Zone</strong><br>

{{ $setting->time_zone }}

</div>

</div>

<div class="col-md-4">

<div class="info-box">

<strong>Default Language</strong><br>

{{ $setting->default_language }}

</div>

</div>

<div class="col-md-4">

<div class="info-box">

<strong>Latitude</strong><br>

{{ $setting->latitude }}

</div>

</div>

<div class="col-md-4">

<div class="info-box">

<strong>Longitude</strong><br>

{{ $setting->longitude }}

</div>

</div>

<div class="col-md-4">

<div class="info-box">

<strong>Tracking Interval</strong><br>

{{ $setting->tracking_interval }}

</div>

</div>

<div class="col-md-4">

<div class="info-box">

<strong>Map Provider</strong><br>

{{ $setting->map_provider }}

</div>

</div>

<div class="col-md-4">

<div class="info-box">

<strong>Zoom Level</strong><br>

{{ $setting->default_zoom_level }}

</div>

</div>

<div class="col-md-4">

<div class="info-box">

<strong>Device Model</strong><br>

{{ $setting->device_model }}

</div>

</div>

</div>

</div>

<div class="card-footer">

<a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">

Back

</a>

</div>

</div>

</div>

@endsection
