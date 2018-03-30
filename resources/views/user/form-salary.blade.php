@extends('layouts.app')

@section('content')

    <h1 class="h1-responsive">Точка изменения зарплаты и грейда</h1>

    {{Form::model($salary,['route' => ['user.salary.store'], 'files'=>false,'class'=>'col-sm-6 mt-3'])}}
        {{ csrf_field() }}
        {{Form::hidden('_method','PUT')}}
        {{Form::hidden('user_id',$user->id)}}

        @if (isset($salary->id))
            {{Form::hidden('id',$salary->id)}}
        @endif

        <div class="md-form">
            {{Form::text('date',null,array('class' => 'form-control datepicker', 'id'=>'date'))}}
            {{Form::label('date', 'Дата изменения зарплаты')}}
        </div>
        @if ($errors->has('date'))
            <p class="text-danger form-error-msg">{{ $errors->first('date') }}</p>
        @endif

            <fieldset class="form-group">
                <div class="range-field">
                    <label for='grade'>Грейд</label>
                    <input name='grade' id='grade' type="range" min="0" max="5" value='{{ $salary->grade or '0' }}'>

                </div>
            </fieldset>
        
        <div class="md-form">
            {{Form::text('money',null,array('class' => 'form-control', 'id'=>'money'))}}
            {{Form::label('money', 'Сумма оклада в рублях (только цифры)')}}
        </div>
        @if ($errors->has('money'))
            <p class="text-danger form-error-msg">{{ $errors->first('money') }}</p>
        @endif

        <div class="text-xs-center">
            <button class="btn btn-default">@lang('messages.Submit')</button>
        </div>

    </form>

    <script type="text/javascript">
    $(function(){
        $('.datepicker').pickadate({'format':'dd.mm.yyyy'});
    });
    </script>
@endsection
