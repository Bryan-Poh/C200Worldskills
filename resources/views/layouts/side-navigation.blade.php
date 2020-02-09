<!-- Sidebar  -->
<nav id="sidebar">
	<div class="sidebar-header">
		<h5 style="color: white;">Events Platform</h5>
	</div>

	<ul class="list-unstyled group" style="padding-top: 15%;">
		<li>
			<a href="{{ route('event') }}">Manage Events</a>
		</li>
	</ul>

	@if (Request::is('event/*') && !Request::is('event/create'))
	<ul class="list-unstyled group">
		<p class="side-nav-header">{{ $event->event_name }}</p>

		<li >
			<a class="{{ (request()->is('event/'.$event->event_slug)) ? 'active' : '' }}"href="{{ url('event/'.$event->event_slug) }}">Overview</a>
		</li>
	</ul>
	

	<ul class="list-unstyled group">
		<p class="side-nav-header">REPORTS</p>
		<li>
			<a href="">Room Capacity</a>
		</li>
	</ul>
@endif

	
</nav>