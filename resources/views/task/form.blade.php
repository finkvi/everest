@extends('layouts.app')

@section('content')

    <h1 class="h1-responsive">Постановка задачи</h1>
    <h3>{{ $competence->name }}</h3>

    {{Form::model($task,['route' => ['task.store'], 'files'=>false,'class'=>'mt-4'])}}
    <div class='row'>
        <div class='col-sm-7'>
    
            {{ csrf_field() }}
            {{Form::hidden('_method','post')}}
            {{Form::hidden('competence_id',$competence->id)}}
            {{Form::hidden('user_id',$user->id)}}

            @if (isset($task->id))
                {{Form::hidden('id',$task->id)}}
            @endif

            <div class="md-form">
                {{Form::text('title',$task->title,['id'=>'title','class'=>'md-textarea'])}}
                {{Form::label('title','Заголовок')}}
            </div>
            @if ($errors->has('title'))
                <p class="text-danger form-error-msg">{{ $errors->first('title') }}</p>
            @endif

            <div class="md-form mt-3">
                {{Form::textarea('task',$task->task,['id'=>'task','class'=>'md-textarea','style'=>'height:200px;'])}}
                {{Form::label('task','Описание задачи')}}
            </div>
            @if ($errors->has('task'))
                <p class="text-danger form-error-msg">{{ $errors->first('task') }}</p>
            @endif


        </div>
    </div>
    <div class='row'>
        <div class=col-sm-6>
        
            <div class="text-xs-center">
                <button class="btn btn-default">@lang('messages.Submit')</button>
            </div>

        </div>
    </div>
    {{Form::close()}}

@endsection
