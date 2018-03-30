@extends('layouts.app')

@section('content')

    <h1 class="h1-responsive">{{ $flow->name }} - @lang('messages.Competences')</h1>

    Укажите компетенции для включения в поток &laquo;{{ $flow->name }}&raquo;
    <br><br>

    {{Form::model($flow,['route' => ['flow.storecompetences'], 'files'=>false, 'class'=>'col-sm-4'])}}

        {{ csrf_field() }}
        {{Form::hidden('_method','post')}}

        @if (isset($flow->id))
            {{Form::hidden('flow_id',$flow->id)}}
        @endif

        @foreach ($competences as $c)
        <div class='row'>
            <fieldset class="form-group">
                {{Form::checkbox('competences[]',$c->id,in_array($c->id,$flowCompetences),array('class' => 'form-control', 'id'=>'chk'.$c->id))}}
                {{Form::label('chk'.$c->id, $c->name)}}
            </fieldset>
        </div>
        @endforeach
        
        <div class="text-xs-center">
            <button class="btn btn-default waves-effect">@lang('messages.Submit')</button>
        </div>

    {{Form::close()}}

@endsection
