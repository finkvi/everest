@extends('layouts.app')

@section('content')

    <h1 class="h1-responsive">@lang('messages.Project')</h1>

    {{Form::model($project,['route' => ['project.store'], 'files'=>false,'class'=>'col-sm-6'])}}
        {{ csrf_field() }}
        {{Form::hidden('_method','PUT')}}

        @if (isset($project->id))
            {{Form::hidden('id',$project->id)}}
        @endif

        <div class="md-form">
            {{Form::select('program_id',$programs,$project->program_id,['class'=>'mdb-select colorful-select dropdown-info','id'=>'program_id'])}}
            {{Form::label('program_id', trans('messages.Program'))}}
        </div>
        @if ($errors->has('program_id'))
            <p class="text-danger form-error-msg">{{ $errors->first('program_id') }}</p>
        @endif

        <div class="md-form">
            {{Form::text('name',null,array('class' => 'form-control', 'id'=>'name'))}}
            {{Form::label('name', trans(('messages.ItemName')))}}
        </div>
        @if ($errors->has('name'))
            <p class="text-danger form-error-msg">{{ $errors->first('name') }}</p>
        @endif
        
        <div class="md-form">
            {{Form::select('rp_user_id',$users,$project->flp_uesr_id,['class'=>'mdb-select colorful-select dropdown-info','id'=>'rp_user_id'])}}
            {{Form::label('rp_user_id', 'Руководитель')}}
        </div>
        @if ($errors->has('rp_user_id'))
            <p class="text-danger form-error-msg">{{ $errors->first('rp_user_id') }}</p>
        @endif

        <div class="text-xs-center">
            <button class="btn btn-default">@lang('messages.Submit')</button>
        </div>

    </form>

@endsection
