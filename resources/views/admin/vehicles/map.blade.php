@extends('layouts.admin')

@section('title','Live Vehicle Tracking')

@section('content')

<style>

.device-scroll{
height:650px;
overflow-y:auto;
}

.device-item{
cursor:pointer;
transition:.2s;
}

.device-item:hover{
background:#f3f6f9;
}

.map-toolbar{
background:#f8f9fa;
padding:10px;
border-bottom:1px solid #eee;
}

.search-box{
padding:10px;
border-bottom:1px solid #eee;
}

</style>


<div class="row">

<div class="col-md-3">

<div class="card shadow-sm">

<div class="card-header bg-primary text-white">
Devices
</div>

<div class="search-box">
<input type="text" id="searchDevice" class="form-control" placeholder="Search IMEI...">
</div>

<div class="device-scroll">

<ul class="list-group list-group-flush" id="deviceList">

@foreach($devices as $d)

<li class="list-group-item device-item"
data-imei="{{ $d->imei }}"
id="device-{{ $d->imei }}"
onclick="focusDevice('{{ $d->imei }}')">

<b>{{ $d->imei }}</b>

<br>

Speed :
<span class="badge badge-info" id="speed-{{ $d->imei }}">
0 km/h
</span>

<br>

Ignition :
<span id="ignition-{{ $d->imei }}" class="badge badge-danger">
OFF
</span>

<br>

Status :
<span id="status-{{ $d->imei }}" class="badge badge-secondary">
OFFLINE
</span>

</li>

@endforeach

</ul>

</div>

</div>

</div>



<div class="col-md-9">

<div class="card shadow-sm">

<div class="card-header bg-success text-white">
Live GPS Map
</div>

<div class="map-toolbar">

<div class="row">

<div class="col-md-3">

<select id="historyDevice" class="form-control">

@foreach($devices as $device)

<option value="{{ $device->imei }}">
{{ $device->imei }}
</option>

@endforeach

</select>

</div>

<div class="col-md-3">
<input type="datetime-local" id="from" class="form-control">
</div>

<div class="col-md-3">
<input type="datetime-local" id="to" class="form-control">
</div>

<div class="col-md-3">
<button class="btn btn-primary btn-block" onclick="loadHistory()">
Show History
</button>
</div>

</div>

</div>

<div id="map" style="height:600px;"></div>

</div>

</div>

</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://js.pusher.com/8.2/pusher.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.0/dist/echo.iife.js"></script>

<script async defer
src="https://maps.googleapis.com/maps/api/js?key={{ $settings->map_api_key }}&callback=initMap">
</script>


<script>

let map;
let markers = {};
let lastSeen = {};
let historyPath;


/*
=====================
INIT GOOGLE MAP
=====================
*/

function initMap(){

map = new google.maps.Map(document.getElementById('map'),{

zoom:12,

center:{
lat: {{ $devices->first()->latitude ?? 25.6097 }},
lng: {{ $devices->first()->longitude ?? 85.1480 }}
}

});

}



/*
=====================
INIT WEBSOCKET
=====================
*/

window.Pusher = Pusher;

window.Echo = new Echo({

broadcaster: 'reverb',

key: "{{ env('REVERB_APP_KEY') }}",

wsHost: window.location.hostname,

wsPort: 8080,

forceTLS:false,

enabledTransports:['ws','wss']

});



/*
=====================
WEBSOCKET LISTENER
=====================
*/

window.Echo.channel('gps')

.listen('.LocationUpdated', function(e){

console.log("LIVE EVENT", e);

/* FIX EVENT DATA */

let d = e.data ? e.data : e;

if(!d.imei) return;


let pos = {

lat: parseFloat(d.latitude),

lng: parseFloat(d.longitude)

};



/*
=====================
MAP MARKER UPDATE
=====================
*/

if(markers[d.imei]){

markers[d.imei].setPosition(pos);

}else{

markers[d.imei] = new google.maps.Marker({

position:pos,

map:map,

title:d.imei

});

}



/*
=====================
UPDATE UI
=====================
*/

updateDeviceUI(d);

moveOnlineTop(d.imei);

lastSeen[d.imei] = Date.now();

map.panTo(pos);

});



/*
=====================
UPDATE DEVICE UI
=====================
*/

function updateDeviceUI(d){

let speed = document.getElementById("speed-"+d.imei);

let ignition = document.getElementById("ignition-"+d.imei);

let status = document.getElementById("status-"+d.imei);

if(speed){

speed.innerHTML = (d.speed ?? 0) + " km/h";

}

if(ignition){

let ign = Number(d.ignition) === 1;

ignition.innerHTML = ign ? "ON" : "OFF";

ignition.className = "badge " + (ign ? "badge-success":"badge-danger");

}

if(status){

status.innerHTML="ONLINE";

status.className="badge badge-success";

}

}



/*
=====================
MOVE ONLINE DEVICE TOP
=====================
*/

function moveOnlineTop(imei){

let list = document.getElementById("deviceList");

let item = document.getElementById("device-"+imei);

if(item){

list.prepend(item);

}

}



/*
=====================
SEARCH DEVICE
=====================
*/

document.getElementById("searchDevice")

.addEventListener("keyup",function(){

let val = this.value.toLowerCase();

document.querySelectorAll("#deviceList li")

.forEach(function(li){

let imei = li.dataset.imei.toLowerCase();

li.style.display = imei.includes(val) ? "list-item":"none";

});

});



/*
=====================
FOCUS DEVICE
=====================
*/

function focusDevice(imei){

if(markers[imei]){

map.setCenter(markers[imei].getPosition());

map.setZoom(16);

}

}



/*
=====================
AUTO OFFLINE CHECK
=====================
*/

setInterval(function(){

Object.keys(lastSeen).forEach(function(imei){

if(Date.now() - lastSeen[imei] > 30000){

let status = document.getElementById("status-"+imei);

let speed = document.getElementById("speed-"+imei);

let ignition = document.getElementById("ignition-"+imei);

if(status){

status.innerHTML="OFFLINE";

status.className="badge badge-secondary";

}

if(speed){

speed.innerHTML="0 km/h";

}

if(ignition){

ignition.innerHTML="OFF";

ignition.className="badge badge-danger";

}

}

});

},5000);



/*
=====================
LOAD HISTORY
=====================
*/

function loadHistory(){

let imei = document.getElementById('historyDevice').value;

let from = document.getElementById('from').value;

let to = document.getElementById('to').value;

fetch(`/admin/vehicles/history?imei=${imei}&from=${from}&to=${to}`)

.then(res=>res.json())

.then(data=>{

let path=[];

data.forEach(p=>{

path.push({

lat:parseFloat(p.latitude),

lng:parseFloat(p.longitude)

});

});


if(historyPath){

historyPath.setMap(null);

}

historyPath = new google.maps.Polyline({

path:path,

map:map,

strokeColor:"#ff0000",

strokeWeight:4

});


if(path.length){

map.setCenter(path[0]);

}

});

}

</script>

@endsection
