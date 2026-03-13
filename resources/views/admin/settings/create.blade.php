@extends('layouts.admin')

@section('title','Create Settings')

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

.form-control{
background:#111827;
border:1px solid #374151;
color:#fff;
}

.nav-tabs .nav-link{
color:#fff;
}

.nav-tabs .nav-link.active{
background:#2563eb;
}

.logo-preview{
width:120px;
height:120px;
border-radius:8px;
margin-top:10px;
object-fit:contain;
background:#000;
padding:5px;
}

.toggle{
position:relative;
display:inline-block;
width:50px;
height:24px;
}

.toggle input{
display:none;
}

.slider{
position:absolute;
cursor:pointer;
background:#444;
border-radius:34px;
top:0;
left:0;
right:0;
bottom:0;
transition:.3s;
}

.slider:before{
position:absolute;
content:"";
height:18px;
width:18px;
left:3px;
bottom:3px;
background:white;
border-radius:50%;
transition:.3s;
}

input:checked + .slider{
background:#22c55e;
}

input:checked + .slider:before{
transform:translateX(26px);
}

#map{
height:350px;
border-radius:10px;
margin-top:15px;
}

</style>

<div class="settings-wrapper">

<form method="POST" action="{{ route('admin.settings.store') }}" enctype="multipart/form-data">

@csrf

<div class="card settings-card">

<div class="card-header">
<h3>Application Settings</h3>
</div>

<div class="card-body">

<ul class="nav nav-tabs" id="settingTabs">

<li class="nav-item">
<a class="nav-link active" data-toggle="tab" href="#general">General</a>
</li>

<li class="nav-item">
<a class="nav-link" data-toggle="tab" href="#device">Device Tracking</a>
</li>

<li class="nav-item">
<a class="nav-link" data-toggle="tab" href="#location">Location</a>
</li>

<li class="nav-item">
<a class="nav-link" data-toggle="tab" href="#alerts">Alerts</a>
</li>

<li class="nav-item">
<a class="nav-link" data-toggle="tab" href="#security">Security</a>
</li>

<li class="nav-item">
<a class="nav-link" data-toggle="tab" href="#mapsettings">Map Settings</a>
</li>

<li class="nav-item">
<a class="nav-link" data-toggle="tab" href="#map">Map</a>
</li>

<li class="nav-item">
<a class="nav-link" data-toggle="tab" href="#logs">Logs</a>
</li>

<li class="nav-item">
<a class="nav-link" data-toggle="tab" href="#integration">Integration</a>
</li>

</ul>

<div class="tab-content pt-4">

<!-- GENERAL SETTINGS -->

<div class="tab-pane fade show active" id="general">

<div class="row">

<div class="col-md-6">
<label>App Name</label>
<input type="text" name="app_name" class="form-control">
</div>

<div class="col-md-6">
<label>App Logo</label>
<input type="file" name="app_logo" id="logoInput" class="form-control">
<img id="logoPreview" class="logo-preview"/>
</div>

<div class="col-md-4">
<label>Time Zone</label>
<input type="text" name="time_zone" class="form-control">
</div>

<div class="col-md-4">
<label>Date Format</label>
<input type="text" name="date_format" class="form-control">
</div>

<div class="col-md-4">
<label>Default Language</label>
<input type="text" name="default_language" class="form-control">
</div>

<div class="col-md-6">
<label>Tracking Interval</label>
<input type="number" name="tracking_interval" class="form-control">
</div>

<div class="col-md-6">
<label>Enable Tracking</label>
<br>
<label class="toggle">
<input type="checkbox" name="enable_tracking" value="1">
<span class="slider"></span>
</label>
</div>

</div>

</div>


<!-- DEVICE TRACKING -->

<div class="tab-pane fade" id="device">

<div class="row">

<div class="col-md-4">
<label>Enable GPS Tracking</label>
<select name="enable_gps_tracking" class="form-control">
<option value="1">On</option>
<option value="0">Off</option>
</select>
</div>

<div class="col-md-4">
<label>Background Tracking</label>
<select name="enable_background_tracking" class="form-control">
<option value="1">On</option>
<option value="0">Off</option>
</select>
</div>

<div class="col-md-4">
<label>Device ID</label>
<input name="device_id" class="form-control">
</div>

<div class="col-md-4">
<label>Phone Number</label>
<input name="phone_number" class="form-control">
</div>

<div class="col-md-4">
<label>User ID</label>
<input name="user_id" class="form-control">
</div>

<div class="col-md-4">
<label>IMEI</label>
<input name="imei" class="form-control">
</div>

<div class="col-md-4">
<label>Device Model</label>
<input name="device_model" class="form-control">
</div>

<div class="col-md-4">
<label>OS Version</label>
<input name="os_version" class="form-control">
</div>

<div class="col-md-4">
<label>Battery Status</label>
<input name="battery_status" class="form-control">
</div>

<div class="col-md-4">
<label>Last Active Time</label>
<input type="datetime-local" name="last_active_time" class="form-control">
</div>

</div>

</div>


<!-- LOCATION -->

<div class="tab-pane fade" id="location">

<div class="row">

<div class="col-md-4">
<label>GPS Accuracy</label>
<input name="gps_accuracy_level" class="form-control">
</div>

<div class="col-md-4">
<label>Location Update Interval</label>
<input name="location_update_interval" class="form-control">
</div>

<div class="col-md-4">
<label>Geofence Radius</label>
<input id="radius" name="geofence_radius" class="form-control">
</div>

<div class="col-md-6">
<label>Latitude</label>
<input id="latitude" name="latitude" class="form-control">
</div>

<div class="col-md-6">
<label>Longitude</label>
<input id="longitude" name="longitude" class="form-control">
</div>

<div class="col-md-6">
<label>Enable Geofencing</label>
<select name="enable_geofencing" class="form-control">
<option value="1">Enable</option>
<option value="0">Disable</option>
</select>
</div>

<div class="col-md-6">
<label>Location History Limit</label>
<input name="location_history_limit" class="form-control">
</div>

<div class="col-md-12">
<label>Allowed Location Area</label>
<textarea name="allowed_location_area" class="form-control"></textarea>
</div>

</div>

</div>


<!-- ALERTS -->

<div class="tab-pane fade" id="alerts">

<div class="row">

<div class="col-md-4">
<label>Low Battery Alert</label>
<select name="low_battery_alert" class="form-control">
<option value="1">Enable</option>
<option value="0">Disable</option>
</select>
</div>

<div class="col-md-4">
<label>Out Of Area Alert</label>
<select name="out_of_area_alert" class="form-control">
<option value="1">Enable</option>
<option value="0">Disable</option>
</select>
</div>

<div class="col-md-4">
<label>Device Offline Alert</label>
<select name="device_offline_alert" class="form-control">
<option value="1">Enable</option>
<option value="0">Disable</option>
</select>
</div>

<div class="col-md-4">
<label>Emergency SOS Alert</label>
<select name="emergency_sos_alert" class="form-control">
<option value="1">Enable</option>
<option value="0">Disable</option>
</select>
</div>

<div class="col-md-4">
<label>Email Notification</label>
<select name="email_notification_enable" class="form-control">
<option value="1">Enable</option>
<option value="0">Disable</option>
</select>
</div>

<div class="col-md-4">
<label>SMS Notification</label>
<select name="sms_notification_enable" class="form-control">
<option value="1">Enable</option>
<option value="0">Disable</option>
</select>
</div>

<div class="col-md-4">
<label>Push Notification</label>
<select name="push_notification_enable" class="form-control">
<option value="1">Enable</option>
<option value="0">Disable</option>
</select>
</div>

</div>

</div>


<!-- SECURITY -->

<div class="tab-pane fade" id="security">

<div class="row">

<div class="col-md-6">
<label>API Key</label>
<input name="api_key" class="form-control">
</div>

<div class="col-md-6">
<label>Token Expiry Time</label>
<input name="token_expiry_time" class="form-control">
</div>

<div class="col-md-6">
<label>Data Encryption Enable</label>
<select name="data_encryption_enable" class="form-control">
<option value="1">Enable</option>
<option value="0">Disable</option>
</select>
</div>

<div class="col-md-6">
<label>Location History Retention</label>
<input name="location_history_retention" class="form-control">
</div>

<div class="col-md-6">
<label>User Consent Required</label>
<select name="user_consent_required" class="form-control">
<option value="1">Yes</option>
<option value="0">No</option>
</select>
</div>

<div class="col-md-6">
<label>Admin Access Control</label>
<select name="admin_access_control" class="form-control">
<option value="1">Enable</option>
<option value="0">Disable</option>
</select>
</div>

</div>

</div>


<!-- MAP SETTINGS -->

<div class="tab-pane fade" id="mapsettings">

<div class="row">

<div class="col-md-6">
<label>Map Provider</label>
<input name="map_provider" class="form-control">
</div>

<div class="col-md-6">
<label>Map API Key</label>
<input name="map_api_key" class="form-control">
</div>

<div class="col-md-6">
<label>Default Zoom Level</label>
<input name="default_zoom_level" class="form-control">
</div>

<div class="col-md-6">
<label>Map Theme</label>
<input name="map_theme" class="form-control">
</div>

</div>

</div>


<!-- MAP -->

<div class="tab-pane fade" id="map">
<div id="map"></div>
</div>


<!-- LOGS -->

<div class="tab-pane fade" id="logs">

<div class="row">

<div class="col-md-6">
<label>Enable Tracking Logs</label>
<select name="enable_tracking_logs" class="form-control">
<option value="1">Enable</option>
<option value="0">Disable</option>
</select>
</div>

<div class="col-md-6">
<label>Log Retention Period</label>
<input name="log_retention_period" class="form-control">
</div>

<div class="col-md-6">
<label>Export Report</label>
<select name="export_report" class="form-control">
<option value="1">Enable</option>
<option value="0">Disable</option>
</select>
</div>

<div class="col-md-6">
<label>Daily Tracking Report</label>
<select name="daily_tracking_report_enable" class="form-control">
<option value="1">Enable</option>
<option value="0">Disable</option>
</select>
</div>

</div>

</div>


<!-- INTEGRATION -->

<div class="tab-pane fade" id="integration">

<div class="row">

<div class="col-md-12">
<label>SMS Gateway API</label>
<textarea name="sms_gateway_api" class="form-control"></textarea>
</div>

<div class="col-md-12">
<label>Email SMTP Settings</label>
<textarea name="email_smtp_settings" class="form-control"></textarea>
</div>

<div class="col-md-12">
<label>Firebase Push Key</label>
<textarea name="firebase_push_key" class="form-control"></textarea>
</div>

<div class="col-md-12">
<label>Third Party Tracking API</label>
<textarea name="third_party_tracking_api" class="form-control"></textarea>
</div>

</div>

</div>

</div>

</div>

<div class="card-footer text-right">

<button class="btn btn-primary">
Save Settings
</button>

</div>

</div>

</form>

</div>

<script src="https://maps.googleapis.com/maps/api/js?key={{ $setting->map_api_key ?? '' }}"></script>

<script>

let map;
let marker;
let circle;

function initMap(){

let center={lat:20.5937,lng:78.9629};

map=new google.maps.Map(document.getElementById("map"),{
zoom:5,
center:center
});

map.addListener("click",function(e){
placeMarker(e.latLng);
});

}

function placeMarker(location){

if(marker){
marker.setPosition(location);
circle.setCenter(location);
}else{

marker=new google.maps.Marker({
position:location,
map:map
});

circle=new google.maps.Circle({
map:map,
radius:200,
fillColor:'#2563eb'
});

circle.bindTo('center',marker,'position');

}

document.getElementById("latitude").value=location.lat();
document.getElementById("longitude").value=location.lng();

}

initMap();


document.getElementById('logoInput').addEventListener('change',function(e){

const reader=new FileReader();

reader.onload=function(){
document.getElementById('logoPreview').src=reader.result;
};

reader.readAsDataURL(e.target.files[0]);

});

</script>

@endsection
