@extends('layouts.admin')

@section('title','Edit Settings')

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

#map{
height:350px;
border-radius:10px;
margin-top:15px;
}

</style>

<div class="settings-wrapper">

<form method="POST"
action="{{ route('admin.settings.update',$setting->id) }}"
enctype="multipart/form-data">

@csrf
@method('PUT')

<div class="card settings-card">

<div class="card-header">
<h3>Edit Application Settings</h3>
</div>

<div class="card-body">

<ul class="nav nav-tabs">

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
<a class="nav-link" data-toggle="tab" href="#mapTab">Map</a>
</li>

<li class="nav-item">
<a class="nav-link" data-toggle="tab" href="#logs">Logs</a>
</li>

<li class="nav-item">
<a class="nav-link" data-toggle="tab" href="#integration">Integration</a>
</li>

</ul>

<div class="tab-content pt-4">

<!-- GENERAL -->

<div class="tab-pane fade show active" id="general">

<div class="row">

<div class="col-md-6">
<label>Title</label>
<input name="title" value="{{ $setting->title }}" class="form-control">
</div>

<div class="col-md-6">
<label>Project Status</label>
<input name="project_status" value="{{ $setting->project_status }}" class="form-control">
</div>

<div class="col-md-6">
<label>Address</label>
<input name="address" value="{{ $setting->address }}" class="form-control">
</div>

<div class="col-md-12">
<label>Description</label>
<textarea name="description" class="form-control">{{ $setting->description }}</textarea>
</div>

<div class="col-md-6">
<label>App Name</label>
<input type="text" name="app_name" value="{{ $setting->app_name }}" class="form-control">
</div>

<div class="col-md-6">
<label>App Logo</label>

<input type="file" name="app_logo" id="logoInput" class="form-control">

@php
$logo = \App\Models\Media::where('model_type',App\Models\Setting::class)
->where('model_id',$setting->id)
->where('collection_name','logo')
->first();
@endphp

@if($logo)

<img id="logoPreview"
src="{{ asset('storage/settings/'.$logo->file_name) }}"
class="logo-preview">

@else

<img id="logoPreview" class="logo-preview">

@endif

</div>

<div class="col-md-4">
<label>Time Zone</label>
<input name="time_zone" value="{{ $setting->time_zone }}" class="form-control">
</div>

<div class="col-md-4">
<label>Date Format</label>
<input name="date_format" value="{{ $setting->date_format }}" class="form-control">
</div>

<div class="col-md-4">
<label>Default Language</label>
<input name="default_language" value="{{ $setting->default_language }}" class="form-control">
</div>

<div class="col-md-6">
<label>Tracking Interval</label>
<input name="tracking_interval" value="{{ $setting->tracking_interval }}" class="form-control">
</div>

<div class="col-md-6">
<label>Enable Tracking</label>
<select name="enable_tracking" class="form-control">
<option value="1" {{ $setting->enable_tracking ? 'selected':'' }}>Enable</option>
<option value="0" {{ !$setting->enable_tracking ? 'selected':'' }}>Disable</option>
</select>
</div>

</div>

</div>

<!-- DEVICE -->

<div class="tab-pane fade" id="device">

<div class="row">

<div class="col-md-4">
<label>Enable GPS Tracking</label>
<input name="enable_gps_tracking" value="{{ $setting->enable_gps_tracking }}" class="form-control">
</div>

<div class="col-md-4">
<label>Background Tracking</label>
<input name="enable_background_tracking" value="{{ $setting->enable_background_tracking }}" class="form-control">
</div>

<div class="col-md-4">
<label>Device ID</label>
<input name="device_id" value="{{ $setting->device_id }}" class="form-control">
</div>

<div class="col-md-4">
<label>Phone Number</label>
<input name="phone_number" value="{{ $setting->phone_number }}" class="form-control">
</div>

<div class="col-md-4">
<label>User ID</label>
<input name="user_id" value="{{ $setting->user_id }}" class="form-control">
</div>

<div class="col-md-4">
<label>IMEI</label>
<input name="imei" value="{{ $setting->imei }}" class="form-control">
</div>

<div class="col-md-4">
<label>Device Model</label>
<input name="device_model" value="{{ $setting->device_model }}" class="form-control">
</div>

<div class="col-md-4">
<label>OS Version</label>
<input name="os_version" value="{{ $setting->os_version }}" class="form-control">
</div>

<div class="col-md-4">
<label>Last Active Time</label>
<input name="last_active_time" value="{{ $setting->last_active_time }}" class="form-control">
</div>

<div class="col-md-4">
<label>Battery Status</label>
<input name="battery_status" value="{{ $setting->battery_status }}" class="form-control">
</div>

</div>

</div>

<!-- LOCATION -->

<div class="tab-pane fade" id="location">

<div class="row">

<div class="col-md-4">
<label>GPS Accuracy</label>
<input name="gps_accuracy_level" value="{{ $setting->gps_accuracy_level }}" class="form-control">
</div>

<div class="col-md-4">
<label>Location Update Interval</label>
<input name="location_update_interval" value="{{ $setting->location_update_interval }}" class="form-control">
</div>

<div class="col-md-6">
<label>Latitude</label>
<input id="latitude" name="latitude" value="{{ $setting->latitude }}" class="form-control">
</div>

<div class="col-md-6">
<label>Longitude</label>
<input id="longitude" name="longitude" value="{{ $setting->longitude }}" class="form-control">
</div>

<div class="col-md-6">
<label>Geofence Radius</label>
<input id="radius" name="geofence_radius" value="{{ $setting->geofence_radius }}" class="form-control">
</div>

<div class="col-md-6">
<label>Enable Geofencing</label>
<input name="enable_geofencing" value="{{ $setting->enable_geofencing }}" class="form-control">
</div>

<div class="col-md-12">
<label>Allowed Location Area</label>
<textarea name="allowed_location_area" class="form-control">{{ $setting->allowed_location_area }}</textarea>
</div>

<div class="col-md-4">
<label>Location History Limit</label>
<input name="location_history_limit" value="{{ $setting->location_history_limit }}" class="form-control">
</div>

</div>

</div>

<!-- ALERTS -->

<div class="tab-pane fade" id="alerts">

<div class="row">

<div class="col-md-4">
<label>Low Battery Alert</label>
<input name="low_battery_alert" value="{{ $setting->low_battery_alert }}" class="form-control">
</div>

<div class="col-md-4">
<label>Out Of Area Alert</label>
<input name="out_of_area_alert" value="{{ $setting->out_of_area_alert }}" class="form-control">
</div>

<div class="col-md-4">
<label>Device Offline Alert</label>
<input name="device_offline_alert" value="{{ $setting->device_offline_alert }}" class="form-control">
</div>

<div class="col-md-4">
<label>Emergency SOS Alert</label>
<input name="emergency_sos_alert" value="{{ $setting->emergency_sos_alert }}" class="form-control">
</div>

<div class="col-md-4">
<label>Email Notification</label>
<input name="email_notification_enable" value="{{ $setting->email_notification_enable }}" class="form-control">
</div>

<div class="col-md-4">
<label>SMS Notification</label>
<input name="sms_notification_enable" value="{{ $setting->sms_notification_enable }}" class="form-control">
</div>

<div class="col-md-4">
<label>Push Notification</label>
<input name="push_notification_enable" value="{{ $setting->push_notification_enable }}" class="form-control">
</div>

<div class="col-md-4">
<label>Custom Notification</label>
<input name="custom_notification" value="{{ $setting->custom_notification }}" class="form-control">
</div>

<div class="col-md-12">
<label>Alert Message</label>
<textarea name="alert_message" class="form-control">{{ $setting->alert_message }}</textarea>
</div>

</div>

</div>

<!-- SECURITY -->

<div class="tab-pane fade" id="security">

<div class="row">

<div class="col-md-4">
<label>Data Encryption</label>
<input name="data_encryption_enable" value="{{ $setting->data_encryption_enable }}" class="form-control">
</div>

<div class="col-md-4">
<label>Location History Retention</label>
<input name="location_history_retention" value="{{ $setting->location_history_retention }}" class="form-control">
</div>

<div class="col-md-4">
<label>User Consent Required</label>
<input name="user_consent_required" value="{{ $setting->user_consent_required }}" class="form-control">
</div>

<div class="col-md-4">
<label>Admin Access Control</label>
<input name="admin_access_control" value="{{ $setting->admin_access_control }}" class="form-control">
</div>

<div class="col-md-4">
<label>API Key</label>
<input name="api_key" value="{{ $setting->api_key }}" class="form-control">
</div>

<div class="col-md-4">
<label>Token Expiry</label>
<input name="token_expiry_time" value="{{ $setting->token_expiry_time }}" class="form-control">
</div>

</div>

</div>

<!-- MAP -->

<div class="tab-pane fade" id="mapTab">
<div id="map"></div>

<div class="row mt-3">

<div class="col-md-4">
<label>Map Provider</label>
<input name="map_provider" value="{{ $setting->map_provider }}" class="form-control">
</div>

<div class="col-md-4">
<label>Map API Key</label>
<input name="map_api_key" value="{{ $setting->map_api_key }}" class="form-control">
</div>

<div class="col-md-4">
<label>Default Zoom Level</label>
<input name="default_zoom_level" value="{{ $setting->default_zoom_level }}" class="form-control">
</div>

<div class="col-md-4">
<label>Map Theme</label>
<input name="map_theme" value="{{ $setting->map_theme }}" class="form-control">
</div>

</div>

</div>

<!-- LOGS -->

<div class="tab-pane fade" id="logs">

<div class="row">

<div class="col-md-4">
<label>Enable Tracking Logs</label>
<input name="enable_tracking_logs" value="{{ $setting->enable_tracking_logs }}" class="form-control">
</div>

<div class="col-md-4">
<label>Log Retention Period</label>
<input name="log_retention_period" value="{{ $setting->log_retention_period }}" class="form-control">
</div>

<div class="col-md-4">
<label>Export Report</label>
<input name="export_report" value="{{ $setting->export_report }}" class="form-control">
</div>

<div class="col-md-4">
<label>Daily Tracking Report</label>
<input name="daily_tracking_report_enable" value="{{ $setting->daily_tracking_report_enable }}" class="form-control">
</div>

</div>

</div>

<!-- INTEGRATION -->

<div class="tab-pane fade" id="integration">

<div class="row">

<div class="col-md-12">
<label>SMS Gateway API</label>
<textarea name="sms_gateway_api" class="form-control">{{ $setting->sms_gateway_api }}</textarea>
</div>

<div class="col-md-12">
<label>Email SMTP Settings</label>
<textarea name="email_smtp_settings" class="form-control">{{ $setting->email_smtp_settings }}</textarea>
</div>

<div class="col-md-12">
<label>Firebase Push Key</label>
<textarea name="firebase_push_key" class="form-control">{{ $setting->firebase_push_key }}</textarea>
</div>

<div class="col-md-12">
<label>Third Party Tracking API</label>
<textarea name="third_party_tracking_api" class="form-control">{{ $setting->third_party_tracking_api }}</textarea>
</div>

</div>

</div>

</div>

</div>

<div class="card-footer text-right">

<button class="btn btn-success">
Update Settings
</button>

</div>

</div>

</form>

</div>

<script src="https://maps.googleapis.com/maps/api/js?key={{ setting('map_api_key') }}"></script>

<script>

let map;
let marker;
let circle;

function initMap(){

let lat = parseFloat(document.getElementById('latitude').value) || 20.5937;
let lng = parseFloat(document.getElementById('longitude').value) || 78.9629;
let radius = parseFloat(document.getElementById('radius').value) || 200;

let center = {lat:lat,lng:lng};

map = new google.maps.Map(document.getElementById("map"),{
zoom:8,
center:center
});

marker = new google.maps.Marker({
position:center,
map:map
});

circle = new google.maps.Circle({
map:map,
radius:radius,
fillColor:'#2563eb'
});

circle.bindTo('center',marker,'position');

map.addListener("click",function(e){

marker.setPosition(e.latLng);

circle.setCenter(e.latLng);

document.getElementById("latitude").value = e.latLng.lat();
document.getElementById("longitude").value = e.latLng.lng();

});

document.getElementById("radius").addEventListener("input",function(){
circle.setRadius(parseInt(this.value));
});

}

initMap();

document.getElementById('logoInput').addEventListener('change',function(e){

const reader = new FileReader();

reader.onload = function(){
document.getElementById('logoPreview').src = reader.result;
};

reader.readAsDataURL(e.target.files[0]);

});

</script>

@endsection
