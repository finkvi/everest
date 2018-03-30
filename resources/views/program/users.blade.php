@extends('layouts.app')

@section('content')

    <h1 class="h1-responsive">Программа &laquo;{{ $program->name }}&raquo; - @lang('messages.Users')</h1>

    Укажите пользователей для включения в программу &laquo;{{ $program->name }}&raquo;
    <br>Показаны пользователи, которые привязаны к потокам программы. 
    <br><br>

    {{Form::model($program,['route' => ['program.storeusers'], 'files'=>false])}}

        {{ csrf_field() }}
        {{Form::hidden('_method','post')}}

        @if (isset($program->id))
            {{Form::hidden('program_id',$program->id)}}
        @endif

        @foreach ($flows as $f)
            <div class='row mb-1 mt-1'>
                <div class="col-sm-4">
                    <h2 class="h2-responsive">{{ $f->name }}</h2>
                </div>
            </div>
            @foreach ($f->users as $u)
                <div class='row'>
                    <fieldset class="form-group col-sm-4">
                        {{Form::checkbox('users[]',$u->id,in_array($u->id,$programUsers),array('class' => 'form-control', 'id'=>'chk'.$u->id))}}
                        {{Form::label('chk'.$u->id, $u->name)}}
                    </fieldset>
                </div>
            @endforeach
        @endforeach
        
        <div class='row mt-1'>
            <div class="col-sm-4 text-xs-center">
                <button class="btn btn-default waves-effect">@lang('messages.Submit')</button>
            </div>
        </div>

    {{Form::close()}}

@endsection
