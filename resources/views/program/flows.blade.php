@extends('layouts.app')

@section('content')

    <h1 class="h1-responsive">{{ $program->name }} - @lang('messages.Flows')</h1>

    Укажите потоки, кототорые необходимо включить в программу &laquo;{{ $program->name }}&raquo;
    <br><br>

    {{Form::model($program,['route' => ['program.storeflows'], 'files'=>false])}}

        {{ csrf_field() }}
        {{Form::hidden('_method','post')}}

        @if (isset($program->id))
            {{Form::hidden('program_id',$program->id)}}
        @endif

        @foreach ($allflows as $f)
        <?
            if (!isset($pfPL[$f->id]))
                $pfPL[$f->id] = 0;
        ?>
        <div class='row mb-4'>
            <fieldset class="form-group col-sm-3 mt-1">
                {{Form::checkbox('flow['.$f->id.']',$f->id,in_array($f->id,$pflowsIDs),array('class' => 'form-control', 'id'=>'chk'.$f->id))}}
                {{Form::label('chk'.$f->id, $f->name)}}
            </fieldset>
            <fieldset class="form-group col-sm-5">
                {{Form::select('pl['.$f->id.']',$users,$pfPL[$f->id],['class'=>'mdb-select colorful-select dropdown-info'])}}
                
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
