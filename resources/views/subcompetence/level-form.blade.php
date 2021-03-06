@extends('layouts.app')

@section('content')

    <h1 class="h1-responsive mb-3">Уровень подкомпетенции</h1>

    {{Form::model($subclevel,['route' => ['subcompetence.levelstore'], 'files'=>false,'class'=>'col-sm-10'])}}
        {{ csrf_field() }}
        {{Form::hidden('_method','PUT')}}

        @if (isset($subclevel->id))
            {{Form::hidden('id',$subclevel->id)}}
        @endif

        @if ($subclevel->subcompetence_id)
            {{Form::hidden('subcompetence_id',$subclevel->subcompetence_id)}}
        @elseif ($subcompetence->id)
            {{Form::hidden('subcompetence_id',$subcompetence->id)}}
        @endif

        <div class="md-form">
            {{Form::selectRange('level', 1, config('everest.max_competence_level'),$subclevel->level,['class'=>'mdb-select colorful-select dropdown-info','id'=>'level'])}}
            {{Form::label('level', 'Уровень компетенции')}}
        </div>

        <div class="md-form">
            {{Form::textarea('description',null,array('class' => 'md-textarea', 'id'=>'description', 'style'=>'height:350px; overflow-y: scroll;'))}}
            {{Form::label('description', 'Описание уровня')}}
        </div>
        @if ($errors->has('description'))
            <p class="text-danger form-error-msg">{{ $errors->first('description') }}</p>
        @endif
        
        <div class="text-xs-center">
            <button class="btn btn-default">@lang('messages.Submit')</button>
        </div>

    </form>

@endsection
