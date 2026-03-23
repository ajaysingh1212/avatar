<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Admin Panel</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">

<style>

/* GLOBAL */

body{
background:#111827;
color:#e5e7eb;
}


/* CARDS */

.card{
background:#1f2937;
border:none;
border-radius:10px;
}

.card-header{
background:#111827;
border-bottom:1px solid #374151;
}


/* FORM */

.form-control{
background:#111827;
border:1px solid #374151;
color:#fff;
}

.form-control:focus{
background:#111827;
color:#fff;
border-color:#6366f1;
box-shadow:none;
}


/* BUTTON */

.btn{
transition:0.3s;
}

.btn:hover{
transform:scale(1.08);
}


/* NAVBAR USER */

.user-avatar{
width:35px;
height:35px;
border-radius:50%;
margin-right:8px;
border:2px solid #3b82f6;
}


/* WALLET */

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


/* NAV ICON */

.animated-icon{
transition:0.3s;
}

.animated-icon:hover{
transform:rotate(15deg) scale(1.2);
color:#60a5fa;
}


/* PROFILE DROPDOWN */

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


/* THEMES */

.theme-blue .main-header{
background:#1e40af !important;
}

.theme-blue .main-sidebar{
background:#1e3a8a !important;
}

.theme-green .main-header{
background:#065f46 !important;
}

.theme-green .main-sidebar{
background:#064e3b !important;
}

.theme-red .main-header{
background:#7f1d1d !important;
}

.theme-red .main-sidebar{
background:#991b1b !important;
}

.theme-dark .main-header{
background:#111827 !important;
}

.theme-dark .main-sidebar{
background:#111827 !important;
}


/* RTL SUPPORT */

[dir="rtl"] body{
direction:rtl;
text-align:right;
}

[dir="rtl"] .main-sidebar{
right:0;
left:auto;
}

[dir="rtl"] .content-wrapper,
[dir="rtl"] .main-footer,
[dir="rtl"] .main-header{
margin-right:250px;
margin-left:0;
}

[dir="rtl"].sidebar-collapse .content-wrapper,
[dir="rtl"].sidebar-collapse .main-footer,
[dir="rtl"].sidebar-collapse .main-header{
margin-right:0;
}

[dir="rtl"] .navbar-nav{
flex-direction:row-reverse;
}

[dir="rtl"] .nav-sidebar .nav-link > .right{
left:1rem;
right:auto;
transform:rotate(180deg);
}


/* DATATABLE RTL */

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


/* ANIMATION */

@keyframes pulse{
0%{transform:scale(1)}
50%{transform:scale(1.2)}
100%{transform:scale(1)}
}

</style>

</head>

<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">

@include('admin.layouts.navbar')

@include('admin.layouts.sidebar')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">
<h1>@yield('title')</h1>
</div>
</section>

<section class="content">
<div class="container-fluid">
@yield('content')
</div>
</section>

</div>

@include('admin.layouts.footer')

</div>


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- AdminLTE -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>


<!-- DataTables -->

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>


<!-- Export Buttons -->

<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>


<!-- SweetAlert -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- RTL + THEME SYSTEM -->

<script>

function setDirection(dir){

localStorage.setItem("direction",dir)
document.documentElement.setAttribute("dir",dir)

}


function setTheme(theme){

localStorage.setItem("theme",theme)

document.body.classList.remove(
"theme-blue",
"theme-green",
"theme-red",
"theme-dark"
)

if(theme !== "default"){
document.body.classList.add("theme-"+theme)
}

}


/* LOAD SETTINGS */

window.onload=function(){

let dir=localStorage.getItem("direction")
let theme=localStorage.getItem("theme")

if(dir){
document.documentElement.setAttribute("dir",dir)
}

if(theme && theme!=="default"){
document.body.classList.add("theme-"+theme)
}

}

</script>


@yield('scripts')

</body>
</html>
