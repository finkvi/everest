@extends('layouts.app')

@section('content')

    <h1 class="h1-responsive">@lang('messages.Profile')</h1>

    {{Form::model($profile,['route' => ['profile.store'], 'files'=>false,'class'=>'mt-2'])}}
    <div class='row'>
        <div class='col-sm-5'>
    
            {{ csrf_field() }}
            {{Form::hidden('_method','PUT')}}

            @if (isset($profile->id))
                {{Form::hidden('id',$profile->id)}}
            @endif

            {{Form::hidden('flow_id',$flow->id)}}

            <div class="md-form">
                {{Form::text('flow',$flow->name,['class'=>'','id'=>'flow','readonly'=>'readonly'])}}
                {{Form::label('flow', trans('messages.Flow'))}}
            </div>
            @if ($errors->has('flow'))
                <p class="text-danger form-error-msg">{{ $errors->first('flow') }}</p>
            @endif

            <div class="md-form">
                {{Form::text('name',null,array('class' => 'form-control', 'id'=>'name'))}}
                {{Form::label('name', trans(('messages.ItemName')))}}
            </div>
            @if ($errors->has('name'))
                <p class="text-danger form-error-msg">{{ $errors->first('name') }}</p>
            @endif
            
            <div class="md-form">
                {{Form::selectRange('grade', 1, 5,$profile->grade,['class'=>'mdb-select colorful-select dropdown-info','id'=>'grade'])}}
                {{Form::label('grade', 'Грейд')}}
            </div>

            <div class="md-form">
                {{Form::text('salary',null,array('class' => 'form-control', 'id'=>'salary'))}}
                {{Form::label('salary', 'Заработная плата')}}
            </div>

            <div class="md-form">
                {{Form::text('order',$profile->order ?? 0,array('class' => 'form-control', 'id'=>'order'))}}
                {{Form::label('order', "Порядок сортировки внутри грейда")}}
            </div>

        </div>
        <div class='col-sm-5 offset-sm-1'>
            <h5>Уровни компетенций</h5>
            @foreach ($flow->competences as $c)
                
                <fieldset class="form-group">
                    <div class="range-field">
                        <label>{{ $c->name }}</label>
                        <input name='levels[{{ $c->id }}]' type="range" min="0" max="{{ config('everest.max_competence_level') }}" value='{{ $competencesProfile[$c->id] or '0' }}'>
                    </div>
                </fieldset>

            @endforeach
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
