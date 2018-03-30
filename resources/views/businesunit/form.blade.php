@extends('layouts.app')

@section('content')

    <h1 class="h1-responsive">@lang('messages.BusinessUnit')</h1>

    {{Form::model($bu,['route' => ['bu.store'], 'files'=>false,'class'=>'col-sm-6'])}}
        {{ csrf_field() }}
        {{Form::hidden('_method','PUT')}}

        @if (isset($bu->id))
            {{Form::hidden('id',$bu->id)}}
        @endif

        <div class="md-form">
            {{Form::text('name',null,array('class' => 'form-control', 'id'=>'name'))}}
            {{Form::label('name', trans(('messages.ItemName')))}}
        </div>
        @if ($errors->has('name'))
            <p class="text-danger form-error-msg">{{ $errors->first('name') }}</p>
        @endif
        
        <div class="md-form">
            {{Form::select('head_user_id',$users,$bu->head_uesr_id,['class'=>'mdb-select colorful-select dropdown-info','id'=>'head_user_id'])}}
            {{Form::label('head_user_id', 'Руководитель')}}
        </div>
        @if ($errors->has('head_user_id'))
            <p class="text-danger form-error-msg">{{ $errors->first('head_user_id') }}</p>
        @endif

        <div class="text-xs-center">
            <button class="btn btn-default">@lang('messages.Submit')</button>
        </div>

    </form>

@endsection
