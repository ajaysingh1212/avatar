<nav class="main-header navbar navbar-expand navbar-dark">

	<ul class="navbar-nav">

		<li class="nav-item">

			<a class="nav-link animated-icon"
			data-widget="pushmenu"
			href="#">

			<i class="fas fa-bars"></i>

		</a>

	</li>

</ul>


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


<!-- Settings -->

<li class="nav-item">

	<a href="#" class="nav-link animated-icon">

		<i class="fas fa-cog"></i>

	</a>

</li>


<!-- Notification -->

<li class="nav-item">

	<a href="#" class="nav-link animated-icon">

		<i class="fas fa-bell"></i>

		<span class="badge badge-danger navbar-badge">

			3

		</span>

	</a>

</li>


@php
$profile = auth()->user()->media->where('collection_name','profile')->first();
@endphp


<!-- User Profile -->

<li class="nav-item dropdown">

	<a class="nav-link dropdown-toggle user-menu"
	data-toggle="dropdown"
	href="#">

	@if($profile)

	<img
	src="{{ asset('storage/'.$profile->file_name) }}"
	class="user-avatar">

	@else

	<img
	src="https://i.pravatar.cc/40"
	class="user-avatar">

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


	<a href="#" class="dropdown-item">

		<i class="fas fa-cog text-warning"></i>

		Settings

	</a>


	<div class="dropdown-divider"></div>


	<form method="POST"
	action="{{ route('logout') }}">

	@csrf

	<button type="submit"
	class="dropdown-item text-danger">

	<i class="fas fa-sign-out-alt"></i>

	Logout

</button>

</form>

</div>

</li>

</ul>

</nav>


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

	@keyframes pulse{

		0%{transform:scale(1)}
		50%{transform:scale(1.2)}
		100%{transform:scale(1)}

	}

</style>
