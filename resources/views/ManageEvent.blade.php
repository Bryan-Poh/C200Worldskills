@extends('layouts.master')

@section('content')

<div class="panel-heading">
	<div class="row" style="display: flex">
		<div class="col-10">
	    <h2>Manage Events</h2>
		</div>

		<div class="col-2">
            <a href="{{route('event.create')}}" class="btn btn-outline-primary" style="float: right">Create new event<a href=""></a></a>
		</div>
	</div>
	<hr>
	@include('layouts.flash-messages')
	
	<!-- Count total Events -->
	<!-- <div class="alert alert-primary" role="alert">
	  	TOTAL EVENTS : {{count($dataArr)}}
	</div> -->
	@if($countOrgEvent < 1)
	<div class="alert alert-warning" role="alert">
  	There are no events currently..
	</div>
	@endif
	<div class="grid-container">
		@foreach($events as $event)
			@if($event->organizer_id == Auth::user()->id)
				<div class="card grid-item" style="width: 18rem;">
				<a href="{{ url('event/'.$event->event_slug) }}">
				  <div class="card-body">
				    <h5 class="card-title">{{ $event->event_name }}</h5>
				    <h6 class="card-subtitle mb-2 text-muted">{{ $event->event_date->format('F d, Y') }}</h6>
				    <hr>
				    @foreach($dataArr as $key=>$value)
				    	@if($key == $event->id)
				    	<p class="card-text">{{ $value }} registrations</p>
				    	@endif
            @endforeach
				  </div>
					</a>
			</div>
			@endif
		@endforeach
	</div>

	<!-- @foreach($events as $event) -->
			
		<!-- @endforeach -->
</div>


@endsection
