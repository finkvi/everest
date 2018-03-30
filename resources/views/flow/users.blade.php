@extends('layouts.app')

@section('content')

    <h1 class="h1-responsive">{{ $flow->name }} - @lang('messages.Users')</h1>

    Укажите пользователей для включения в поток &laquo;{{ $flow->name }}&raquo;
    <br>Показаны пользователи, которые еще не привязаны к потокам
    <br><br>

    {{Form::model($flow,['route' => ['flow.storeusers'], 'files'=>false, 'class'=>'col-sm-4'])}}

        {{ csrf_field() }}
        {{Form::hidden('_method','post')}}

        @if (isset($flow->id))
            {{Form::hidden('flow_id',$flow->id)}}
        @endif

        @foreach ($users as $u)
        <div class='row'>
            <fieldset class="form-group">
                {{Form::checkbox('users[]',$u->id,($u->flow_id==$flow->id),array('class' => 'form-control', 'id'=>'chk'.$u->id))}}
                {{Form::label('chk'.$u->id, $u->name)}}
            </fieldset>
        </div>
        @endforeach
        
        <div class="text-xs-center">
            <button class="btn btn-default waves-effect">@lang('messages.Submit')</button>
        </div>

    {{Form::close()}}

@endsection
