@extends('layouts.app')

@section('content')

    <h1 class="h1-responsive">@lang('messages.Competence')</h1>

    {{Form::model($subcompetence,['route' => ['subcompetence.store'], 'files'=>false,'class'=>'col-sm-6'])}}
        {{ csrf_field() }}
        {{Form::hidden('_method','PUT')}}
        {{Form::hidden('competence_id',$competence->id)}}

        @if (isset($subcompetence->id))
            {{Form::hidden('id',$subcompetence->id)}}
        @endif

        <div class="md-form">
            {{Form::text('name',null,array('class' => 'form-control', 'id'=>'name'))}}
            {{Form::label('name', trans(('messages.ItemName')))}}
        </div>
        @if ($errors->has('name'))
            <p class="text-danger form-error-msg">{{ $errors->first('name') }}</p>
        @endif

        
        <div class="text-xs-center mt-2">
            <button class="btn btn-default">@lang('messages.Submit')</button>
        </div>

    </form>

@endsection
