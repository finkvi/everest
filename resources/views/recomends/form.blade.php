@extends('layouts.app')

@section('content')

    <h1 class="h1-responsive">@lang('messages.Recomends')</h1>

    {{Form::model($rec,['route' => ['recomend.store'], 'files'=>false,'class'=>'col-sm-6'])}}
        {{ csrf_field() }}
        {{Form::hidden('_method','PUT')}}

        @if (isset($rec->id))
            {{Form::hidden('id',$rec->id)}}
        @endif

        <div class="md-form recomends-input">
            {{Form::text('last_name', $rec->last_name, array('class' => 'form-control', 'id'=>'last_name'))}}
            {{Form::label('last_name', 'Фамилия')}}
        </div>
        @if ($errors->has('last_name'))
            <p class="text-danger form-error-msg">{{ $errors->first('last_name') }}</p>
        @endif

        <div class="md-form recomends-input">
            {{Form::text('first_name', $rec->first_name, array('class' => 'form-control', 'id'=>'first_name'))}}
            {{Form::label('first_name', 'Имя')}}
        </div>
        @if ($errors->has('first_name'))
            <p class="text-danger form-error-msg">{{ $errors->first('first_name') }}</p>
        @endif

        <div class="md-form recomends-input">
            {{Form::text('email', $rec->email, array('class' => 'form-control', 'id'=>'email'))}}
            {{Form::label('email', 'Почта')}}
        </div>
        @if ($errors->has('email'))
            <p class="text-danger form-error-msg">{{ $errors->first('email') }}</p>
        @endif
 
        <div class="md-form recomends-input">
            {{Form::text('account', $rec->account, array('class' => 'form-control', 'id'=>'account'))}}
            {{Form::label('account', 'Текущий работодатель')}}
        </div>
        @if ($errors->has('account'))
            <p class="text-danger form-error-msg">{{ $errors->first('account') }}</p>
        @endif

        <div class="md-form recomends-input">
            {{Form::text('phone', $rec->phone, array('class' => 'form-control suggestions-input', 'id'=>'phone'))}}
            {{Form::label('phone', 'Телефон')}}
        </div>
        @if ($errors->has('phone'))
            <p class="text-danger form-error-msg">{{ $errors->first('phone') }}</p>
        @endif

       <div class="md-form recomends-input">
            {{Form::text('notes', $rec->notes, array('class' => 'form-control', 'id'=>'notes'))}}
            {{Form::label('notes', 'Доп. инфо')}}
        </div>
        @if ($errors->has('notes'))
            <p class="text-danger form-error-msg">{{ $errors->first('notes') }}</p>
        @endif
        
        <div class="md-form recomends-input">
            {{Form::text('comments', $rec->comments, array('class' => 'form-control', 'id'=>'comments'))}}
            {{Form::label('comments', 'Комментарий')}}
        </div>
        @if ($errors->has('comments'))
            <p class="text-danger form-error-msg">{{ $errors->first('comments') }}</p>
        @endif
        
        <div class="text-xs-center">
            <button class="btn btn-default">Сохранить</button>
        </div>

    </form>
    
    <script type="text/javascript" src="/js/jquery.suggestions.min.js"></script>
    <script type="text/javascript" src="/js/jquery.maskedinput.min.js"></script>
    
    <script type="text/javascript">
    
    $(function() {
        
        // Инициализирует подсказки по ФИО на указанном элементе
        function init($surname, $name) {
          var self = {};
          self.$surname = $surname;
          self.$name = $name;
          var fioParts = ["SURNAME", "NAME"];
          $.each([$surname, $name], function(index, $el) {
            var sgt = $el.suggestions({
              token: "afa670b1162fe440388d5e23d3cac96f8e3d7fde",
              type: "NAME",
              triggerSelectOnSpace: false,
              hint: "",
              noCache: true,
              params: {
                // каждому полю --- соответствующая подсказка
                parts: [fioParts[index]]
              }
            });
          });
        };
        
        init($("#last_name"), $("#first_name"));
        
        $("#email").suggestions({
            token: "afa670b1162fe440388d5e23d3cac96f8e3d7fde",
            type: "EMAIL",
            count: 5,
            triggerSelectOnSpace: false,
            hint: "",
            noCache: true
        });
        
        $("#account").suggestions({
            token: "afa670b1162fe440388d5e23d3cac96f8e3d7fde",
            type: "PARTY",
            count: 5,
            triggerSelectOnSpace: false,
            hint: "",
            noCache: true
        });
       
       $("#phone").mask("+7(999) 999-9999");
       
    });
    
    </script>

@endsection
