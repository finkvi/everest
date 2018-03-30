@extends('layouts.app')

@section('content')

    <h1 class="h1-responsive">@lang('messages.Competence')</h1>

    {{Form::model($competence,['route' => ['competence.store'], 'files'=>false,'class'=>'col-sm-6'])}}
        {{ csrf_field() }}
        {{Form::hidden('_method','PUT')}}

        @if (isset($competence->id))
            {{Form::hidden('id',$competence->id)}}
        @endif

        <div class="md-form">
            {{Form::text('name',null,array('class' => 'form-control', 'id'=>'name'))}}
            {{Form::label('name', trans(('messages.ItemName')))}}
        </div>
        @if ($errors->has('name'))
            <p class="text-danger form-error-msg">{{ $errors->first('name') }}</p>
        @endif

        <div class="switch">
            <label>
              Off
              {{Form::checkbox('sublevels',1,$competence->sublevels,array('class' => 'form-control', 'id'=>'sublevels'))}}
              <span class="lever"></span>
              On
            </label>   
            <label for='sublevels' class='ml-2' style='font-size:15px;'>Включить второй уровень компетенций</label>
        </div>

        
        <div class="text-xs-center mt-2">
            <button class="btn btn-default">@lang('messages.Submit')</button>
        </div>

    </form>

@endsection
