@extends('layouts.app')

@section('content')

    <h1 class="h1-responsive">@lang('messages.Program')</h1>

    {{Form::model($program,['route' => ['program.store'], 'files'=>false,'class'=>'col-sm-6'])}}
        {{ csrf_field() }}
        {{Form::hidden('_method','PUT')}}

        @if (isset($program->id))
            {{Form::hidden('id',$program->id)}}
        @endif

        <div class="md-form">
            {{Form::select('business_unit_id',$BUs,$program->business_unit_id,['class'=>'mdb-select colorful-select dropdown-info','id'=>'business_unit_id'])}}
            {{Form::label('business_unit_id', trans('messages.BusinessUnit'))}}
        </div>
        @if ($errors->has('business_unit_id'))
            <p class="text-danger form-error-msg">{{ $errors->first('business_unit_id') }}</p>
        @endif

        <div class="md-form">
            {{Form::text('name',null,array('class' => 'form-control', 'id'=>'name'))}}
            {{Form::label('name', trans(('messages.ItemName')))}}
        </div>
        @if ($errors->has('name'))
            <p class="text-danger form-error-msg">{{ $errors->first('name') }}</p>
        @endif
        
        <div class="md-form">
            {{Form::select('dp_user_id',$users,$program->flp_uesr_id,['class'=>'mdb-select colorful-select dropdown-info','id'=>'dp_user_id'])}}
            {{Form::label('dp_user_id', 'Руководитель')}}
        </div>
        @if ($errors->has('dp_user_id'))
            <p class="text-danger form-error-msg">{{ $errors->first('dp_user_id') }}</p>
        @endif

        <div class="text-xs-center">
            <button class="btn btn-default">@lang('messages.Submit')</button>
        </div>

    </form>

@endsection
