<nav class="main-header navbar navbar-expand navbar-dark">

<!-- LEFT SIDE -->

<ul class="navbar-nav">

<li class="nav-item">
<a class="nav-link animated-icon" data-widget="pushmenu" href="#">
<i class="fas fa-bars"></i>
</a>
</li>

<!-- Dark Mode Toggle -->

<li class="nav-item">
<a class="nav-link animated-icon" href="#" onclick="toggleDarkMode()">
<i class="fas fa-moon"></i>
</a>
</li>

<!-- Fullscreen -->

<li class="nav-item">
<a class="nav-link animated-icon" data-widget="fullscreen" href="#">
<i class="fas fa-expand-arrows-alt"></i>
</a>
</li>

</ul>

<!-- RIGHT SIDE -->

<ul class="navbar-nav ml-auto align-items-center">

<!-- Wallet -->

<li class="nav-item mr-3">
<a href="#" class="nav-link wallet-box">
<i class="fas fa-wallet wallet-icon"></i>
<span class="wallet-amount">
₹ 2,500
</span>
</a>
</li>

<!-- Theme + RTL Switcher -->

<li class="nav-item dropdown">
<a class="nav-link animated-icon" data-toggle="dropdown" href="#">
<i class="fas fa-palette"></i>
</a>

<div class="dropdown-menu dropdown-menu-right theme-panel p-3">

<h6 class="mb-2">Theme</h6>

<button class="theme-btn" onclick="setTheme('default')">Default</button>
<button class="theme-btn" onclick="setTheme('dark')">Dark</button>

<button class="theme-btn" onclick="setTheme('blue')">Blue</button>
<button class="theme-btn" onclick="setTheme('green')">Green</button>
<button class="theme-btn" onclick="setTheme('red')">Red</button>

<button class="theme-btn" onclick="setTheme('purple')">Purple</button>
<button class="theme-btn" onclick="setTheme('indigo')">Indigo</button>
<button class="theme-btn" onclick="setTheme('teal')">Teal</button>
<button class="theme-btn" onclick="setTheme('orange')">Orange</button>
<button class="theme-btn" onclick="setTheme('pink')">Pink</button>
<button class="theme-btn" onclick="setTheme('cyan')">Cyan</button>
<button class="theme-btn" onclick="setTheme('amber')">Amber</button>
<button class="theme-btn" onclick="setTheme('lime')">Lime</button>
<button class="theme-btn" onclick="setTheme('rose')">Rose</button>
<button class="theme-btn" onclick="setTheme('sky')">Sky</button>

<hr>

<h6 class="mb-2">Direction</h6>

<button class="theme-btn" onclick="setDirection('ltr')">LTR</button>
<button class="theme-btn" onclick="setDirection('rtl')">RTL</button>

</div>
</li>

<!-- Settings -->

<li class="nav-item">
<a href="{{ route('admin.settings.index') }}" class="nav-link animated-icon">
<i class="fas fa-cog"></i>
</a>
</li>

<!-- Notification -->

<li class="nav-item dropdown">

<a class="nav-link animated-icon" data-toggle="dropdown" href="#">
<i class="fas fa-bell"></i>

<span class="badge badge-danger navbar-badge">
3
</span>
</a>

<div class="dropdown-menu dropdown-menu-right">

<a href="#" class="dropdown-item">
<i class="fas fa-envelope mr-2"></i>
New message
</a>

<a href="#" class="dropdown-item">
<i class="fas fa-users mr-2"></i>
New user registered
</a>

</div>
</li>

@php
$profile = auth()->user()->media->where('collection_name','profile')->first();
@endphp

<!-- User Profile -->

<li class="nav-item dropdown">

<a class="nav-link dropdown-toggle user-menu" data-toggle="dropdown" href="#">

@if($profile)

<img src="{{ asset('storage/'.$profile->file_name) }}" class="user-avatar">

@else

<img src="https://i.pravatar.cc/40" class="user-avatar">

@endif

<span class="d-none d-md-inline">
{{ auth()->user()->name }}
</span>

</a>

<div class="dropdown-menu dropdown-menu-right profile-dropdown">

<a href="{{ route('profile.edit') }}" class="dropdown-item">
<i class="fas fa-user text-primary"></i>
Profile
</a>

<a href="{{ route('admin.settings.index') }}" class="dropdown-item">
<i class="fas fa-cog text-warning"></i>
Settings
</a>

<div class="dropdown-divider"></div>

<form method="POST" action="{{ route('logout') }}">
@csrf

<button type="submit" class="dropdown-item text-danger">

<i class="fas fa-sign-out-alt"></i>
Logout

</button>

</form>

</div>

</li>

</ul>

</nav>

<script>

function toggleDarkMode(){
document.body.classList.toggle("dark-mode")
localStorage.setItem("dark-mode",document.body.classList.contains("dark-mode"))
}

function setTheme(theme){

localStorage.setItem("theme",theme)

document.body.classList.remove(
"theme-dark",
"theme-blue",
"theme-green",
"theme-red",
"theme-purple",
"theme-indigo",
"theme-teal",
"theme-orange",
"theme-pink",
"theme-cyan",
"theme-amber",
"theme-lime",
"theme-rose",
"theme-sky"
)

if(theme !== "default"){
document.body.classList.add("theme-"+theme)
}

}

function setDirection(dir){

localStorage.setItem("direction",dir)
document.documentElement.setAttribute("dir",dir)

}

window.onload=function(){

let theme=localStorage.getItem("theme")
let dir=localStorage.getItem("direction")
let dark=localStorage.getItem("dark-mode")

if(theme && theme!=="default"){
document.body.classList.add("theme-"+theme)
}

if(dir){
document.documentElement.setAttribute("dir",dir)
}

if(dark==="true"){
document.body.classList.add("dark-mode")
}

}

</script>

<style>

.user-avatar{
width:35px;
height:35px;
border-radius:50%;
object-fit:cover;
margin-right:8px;
border:2px solid #3b82f6;
}

.wallet-box{
display:flex;
align-items:center;
background:#1f2937;
padding:5px 10px;
border-radius:8px;
}

.wallet-icon{
color:#f59e0b;
margin-right:6px;
animation:pulse 2s infinite;
}

.wallet-amount{
font-weight:bold;
color:#10b981;
}

.animated-icon{
transition:0.3s;
}

.animated-icon:hover{
transform:rotate(15deg) scale(1.2);
color:#60a5fa;
}

.profile-dropdown{
background:#1f2937;
color:#fff;
}

.profile-dropdown .dropdown-item{
color:#e5e7eb;
}

.profile-dropdown .dropdown-item:hover{
background:#374151;
}

.theme-panel{
min-width:180px;
}

.theme-btn{
display:block;
width:100%;
margin-bottom:5px;
padding:6px;
border:none;
background:#374151;
color:#fff;
border-radius:6px;
cursor:pointer;
font-size:13px;
}

.theme-btn:hover{
background:#4b5563;
}

/* THEME COLORS */

.theme-blue .main-header{background:#1e40af !important;}
.theme-green .main-header{background:#065f46 !important;}
.theme-red .main-header{background:#7f1d1d !important;}
.theme-purple .main-header{background:#6d28d9 !important;}
.theme-indigo .main-header{background:#4338ca !important;}
.theme-teal .main-header{background:#0f766e !important;}
.theme-orange .main-header{background:#c2410c !important;}
.theme-pink .main-header{background:#be185d !important;}
.theme-cyan .main-header{background:#0e7490 !important;}
.theme-amber .main-header{background:#b45309 !important;}
.theme-lime .main-header{background:#4d7c0f !important;}
.theme-rose .main-header{background:#be123c !important;}
.theme-sky .main-header{background:#0369a1 !important;}

[dir="rtl"] .navbar-nav{
flex-direction:row-reverse;
}

[dir="rtl"] .main-sidebar{
right:0;
left:auto;
}

@keyframes pulse{
0%{transform:scale(1)}
50%{transform:scale(1.2)}
100%{transform:scale(1)}
}

</style>
