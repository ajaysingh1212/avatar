@extends('layouts.admin')

@section('title','Settings Dashboard')

@section('content')

<style>

.settings-wrapper{
background:#111827;
padding:35px;
border-radius:12px;
min-height:80vh;
}

/* Header */

.settings-header{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:30px;
border-bottom:1px solid #374151;
padding-bottom:15px;
}

.settings-header h2{
color:#fff;
font-weight:600;
letter-spacing:.5px;
}

/* Grid */

.settings-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
gap:20px;
}

/* Card */

.settings-card{
background:#1f2937;
border-radius:10px;
padding:22px;
color:#fff;
position:relative;
transition:all .25s ease;
border:1px solid #374151;
box-shadow:0 5px 12px rgba(0,0,0,0.25);
}

.settings-card:hover{
transform:translateY(-4px);
box-shadow:0 10px 20px rgba(0,0,0,0.35);
}

/* Title */

.settings-title{
font-size:14px;
font-weight:500;
color:#9ca3af;
margin-bottom:6px;
text-transform:uppercase;
letter-spacing:.5px;
}

/* Value */

.settings-value{
font-size:18px;
font-weight:600;
color:#f9fafb;
word-break:break-word;
}

/* Icon */

.settings-icon{
position:absolute;
top:18px;
right:18px;
font-size:20px;
opacity:.2;
}

/* Button */

.settings-btn{
padding:8px 18px;
font-weight:500;
border-radius:6px;
}

</style>

<div class="settings-wrapper">

<div class="settings-header">

<h2>Application Settings</h2>

<a href="{{ route('admin.settings.edit', setting()->id)}}" class="btn btn-primary settings-btn">
<i class="fa fa-edit me-1"></i> Edit Settings
</a>

</div>

<div class="settings-grid">

<div class="settings-card">
<i class="fa fa-cog settings-icon"></i>
<div class="settings-title">Application Name</div>
<div class="settings-value">{{ setting('app_name') }}</div>
</div>

<div class="settings-card">
<i class="fa fa-language settings-icon"></i>
<div class="settings-title">Default Language</div>
<div class="settings-value">{{ setting('default_language') }}</div>
</div>

<div class="settings-card">
<i class="fa fa-clock settings-icon"></i>
<div class="settings-title">Time Zone</div>
<div class="settings-value">{{ setting('time_zone') }}</div>
</div>

<div class="settings-card">
<i class="fa fa-sync settings-icon"></i>
<div class="settings-title">Tracking Interval</div>
<div class="settings-value">{{ setting('tracking_interval') }}</div>
</div>

<div class="settings-card">
<i class="fa fa-map settings-icon"></i>
<div class="settings-title">Map Provider</div>
<div class="settings-value">{{ setting('map_provider') }}</div>
</div>

<div class="settings-card">
<i class="fa fa-location-arrow settings-icon"></i>
<div class="settings-title">Geofence Radius</div>
<div class="settings-value">{{ setting('geofence_radius') }}</div>
</div>

<div class="settings-card">
<i class="fa fa-sms settings-icon"></i>
<div class="settings-title">SMS Gateway</div>
<div class="settings-value">{{ setting('sms_gateway_api') }}</div>
</div>

<div class="settings-card">
<i class="fa fa-bell settings-icon"></i>
<div class="settings-title">Firebase Push</div>
<div class="settings-value">{{ setting('firebase_push_key') }}</div>
</div>

<div class="settings-card">
<i class="fa fa-file settings-icon"></i>
<div class="settings-title">Logs Enabled</div>
<div class="settings-value">
{{ setting('enable_tracking_logs') ? 'Yes' : 'No' }}
</div>
</div>

</div>

</div>

@endsection
