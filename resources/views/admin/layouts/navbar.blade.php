{{-- MODAL --}}
<div class="modal fade" id="walletModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-wallet"></i> Create Wallet
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    &times;
                </button>
            </div>

            <div class="modal-body">

                <form id="walletForm" >

                    @csrf

                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text"
                               class="form-control"
                               value="{{ auth()->user()->name }}"
                               readonly>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email"
                               class="form-control"
                               value="{{ auth()->user()->email }}"
                               readonly>
                    </div>

                    <button type="submit" class="btn btn-success btn-block">
                        <i class="fas fa-check"></i> Create Wallet
                    </button>

                </form>

            </div>

        </div>
    </div>
</div>


{{-- JS --}}
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){

    const openBtn = document.querySelector('.openWalletModal');
    const form = document.getElementById('walletForm');

    // OPEN MODAL
    if(openBtn){
        openBtn.addEventListener('click', function(e){
            e.preventDefault();
            $('#walletModal').modal('show');
        });
    }

    // AJAX SUBMIT
    if(form){
        form.addEventListener('submit', function(e){
            e.preventDefault(); // 🔥 MOST IMPORTANT

            let formData = new FormData(form);

            fetch("{{ route('admin.wallets.store') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: formData
            })
            .then(async res => {

                let data = await res.json();

                if(!res.ok){
                    throw data;
                }

                return data;
            })
            .then(data => {

                Swal.fire({
                    icon:'success',
                    title:data.message
                }).then(()=>{
                    location.reload();
                });

            })
            .catch(err => {

                Swal.fire({
                    icon:'error',
                    title: err.message || 'Wallet already exists'
                });

            });

        });
    }

});
</script>
@endsection


{{-- CSS --}}
<style>

/* MODAL FIX */
.modal {
    z-index: 9999 !important;
}

.modal-backdrop {
    z-index: 9990 !important;
}

/* MODAL DESIGN */
.modal-content {
    background: #1f2937;
    color: #fff;
    border-radius: 12px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.5);
}

.modal-header {
    border-bottom: none;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
}

.modal-body {
    background: #1f2937;
}

/* INPUT FIX */
.modal-content input {
    background: #374151 !important;
    color: #fff !important;
    border: 1px solid #4b5563;
    border-radius: 8px;
}

.modal-content input::placeholder {
    color: #9ca3af;
}

.modal-content input:focus {
    background: #374151 !important;
    border-color: #3b82f6;
    box-shadow: 0 0 5px rgba(59,130,246,0.5);
}

/* BUTTON */
.modal-content .btn-success {
    background: linear-gradient(135deg, #10b981, #059669);
    border: none;
    font-weight: 600;
    border-radius: 8px;
}

.modal-content .btn-success:hover {
    transform: scale(1.03);
}

</style>

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

@if($authWallet)

<a href="#" class="nav-link wallet-box">

    <i class="fas fa-wallet wallet-icon"></i>

    <span class="wallet-amount">
        ₹ {{ number_format($authWallet->balance,2) }}
    </span>

    @if($authWallet->is_frozen)
        <span class="badge badge-danger ml-2">Frozen</span>
    @elseif($authWallet->status=='pending')
        <span class="badge badge-warning ml-2">Pending</span>
    @endif

</a>

@else

{{-- APPLY WALLET BUTTON --}}
<a href="#" class="nav-link wallet-box text-warning openWalletModal">
    <i class="fas fa-plus-circle"></i>
    <span class="wallet-amount">Apply Wallet</span>
</a>
@endif


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
