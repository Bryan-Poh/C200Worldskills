@extends('layouts.master')

@section('content')
<div class="panel-heading">
    <h1>Worldskills Conference 2019</h1>
    <h5>August 23, 2019</h5>
</div>
<form method = "post" action = "#">
    <div class="panel-heading">
        <br>
        <h4>Create New Channel</h4>
        <br>
        Name:<br>
        <input type="text" size="50" name="channel_name" value=" " required/>
        <br>
        <br>
        <br>
    </div>

    <div>
        <br>
        <input type="submit" value="Save Channel">
    </div>
</form>


@endsection
