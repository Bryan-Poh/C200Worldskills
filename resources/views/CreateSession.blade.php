@extends('layouts.master')

@section('content')
<div class="panel-heading">
    <h2 class="mt-3 mb-3">{{$formatted_slug ?? ''}}</h2>
    <hr/>
    <h4 class="mt-3 mb-5">Create Session</h4>

    @include('layouts.flash-messages')

    {!! Form::open(['method'=>'POST','action'=>['SessionController@store', $slug]]) !!}
    @csrf
        <div class="form-group row">
            <div class="col-4">
                {!! Form::label('id_type','Type') !!}
                {!! Form::select('type', $types, 1, ['class'=>'form-control', 'id'=>'id_type']) !!}
                {{ Form::hidden('event_id', $event_id) }}
            </div>
        </div>

        <div class="form-group row">
            <div class="col-4">
                {!! Form::label('id_title','Title') !!}
                {!! Form::text('title', session('enteredData')[0] ?? '', ['class'=> $errors->has('title') ? 'form-control border-danger': 'form-control', 'id'=>'id_title']) !!}
                @if ($errors->has('title'))
                    <p class="text-danger">{{$errors->first('title')}}</p>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <div class="col-4">
                {!! Form::label('id_speaker','Speaker') !!}
                {!! Form::text('speaker', session('enteredData')[1] ?? '', ['class'=> $errors->has('speaker') ? 'form-control border-danger': 'form-control', 'id'=>'id_speaker']) !!}
                @if ($errors->has('speaker'))
                    <p class="text-danger">{{$errors->first('speaker')}}</p>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <div class="col-4">
                {!! Form::label('id_cost','Cost') !!}
                {!! Form::text('cost', session('enteredData')[2] ?? '', ['class'=> $errors->has('cost') ? 'form-control border-danger': 'form-control', 'id'=>'id_cost']) !!}
                @if ($errors->has('cost'))
                    <p class="text-danger">{{$errors->first('cost')}}</p>
                @endif
            </div>
        </div>

    <div class="row">
        <div class="col-4">
            <div class="form-group">
                {!! Form::label('id_room','Room') !!}
                {!! Form::select('room_id', $room_names, 1, ['class'=> 'form-control', 'id'=>'id_room']) !!}
            </div>
        </div>
    </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    {!! Form::label('id_start','Start') !!}
                    {!! Form::text('start_time', session('enteredData')[3] ?? '', ['class'=> $errors->has('start_time') ? 'form-control border-danger': 'form-control', 'id'=>'id_start','placeholder'=>'yyyy-mm-dd HH:MM']) !!}
                    @if ($errors->has('start_time'))
                        <p class="text-danger">{{$errors->first('start_time')}}</p>
                    @endif
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    {!! Form::label('id_end','End') !!}
                    {!! Form::text('end_time', session('enteredData')[4] ?? '', ['class'=> $errors->has('end_time') ? 'form-control border-danger': 'form-control', 'id'=>'id_end','placeholder'=>'yyyy-mm-dd HH:MM']) !!}
                    @if ($errors->has('end_time'))
                        <p class="text-danger">{{$errors->first('end_time')}}</p>
                    @endif
               </div>
           </div>
       </div>
       <div class="form-group mb-5">
           {!! Form::label('id_desc','Description') !!}
           {!! Form::textarea('description', session('enteredData')[5] ?? '', ['class'=> $errors->has('description') ? 'form-control border-danger': 'form-control', 'id'=>'id_desc', 'row'=>5, 'cols'=>20]) !!}
           @if ($errors->has('description'))
               <p class="text-danger">{{$errors->first('description')}}</p>
           @endif
        </div>
        <hr/>
        <div class="form-group form-inline">
            {!! Form::submit('Create Session',['class'=>'btn btn-primary mr-5','id'=>'submit']) !!}
            <a href="{{route('event.overview',['slug'=>$slug])}}" class="mr-5">Cancel</a>
        </div>

    {!! Form::close() !!}
</div>


@endsection
