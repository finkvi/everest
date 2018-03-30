@extends('layouts.app')

@section('content')

    <h1 class="h1-responsive">{{ $project->name }} - @lang('messages.Flows')</h1>

    Укажите потоки, кототорые необходимо включить в проект &laquo;{{ $project->name }}&raquo;
    <br>
    Здесь отображены потоки, которые включены в программу &laquo;{{ $project->program->name }}&raquo;
    <br><br>

    {{Form::model($project,['route' => ['project.storeflows'], 'files'=>false])}}

        {{ csrf_field() }}
        {{Form::hidden('_method','post')}}

        @if (isset($project->id))
            {{Form::hidden('project_id',$project->id)}}
        @endif

        @foreach ($allflows as $f)
        <?
            if (!isset($TL[$f->id]))
                $TL[$f->id] = 0;
        ?>
        <div class='row mb-4'>
            <fieldset class="form-group col-sm-3 mt-1">
                {{Form::checkbox('flow['.$f->id.']',$f->id,in_array($f->id,$pflowsIDs),array('class' => 'form-control', 'id'=>'chk'.$f->id))}}
                {{Form::label('chk'.$f->id, $f->name)}}
            </fieldset>
            <fieldset class="form-group col-sm-5">
                {{Form::select('tl['.$f->id.']',$users,$TL[$f->id],['class'=>'mdb-select colorful-select dropdown-info'])}}
                
            </fieldset>
        </div>
        @endforeach
        @if ($errors->has('flows'))
            <p class="text-danger form-error-msg">{{ $errors->first('flows') }}</p>
        @endif
        
        <div class="text-xs-center">
            <button class="btn btn-default waves-effect">@lang('messages.Submit')</button>
        </div>

    {{Form::close()}}

@endsection
