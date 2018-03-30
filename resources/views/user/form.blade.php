@extends('layouts.app')

@section('content')

    <h1 class="h1-responsive">@lang('messages.User')</h1>

    {{Form::model($user,['route' => ['user.store'], 'files'=>false,'class'=>'','id'=>'user-form'])}}
    <div class='row'>

        <div class='col-sm-5'>

            {{ csrf_field() }}
            {{Form::hidden('_method','PUT')}}
            {{Form::hidden('backTo',URL::previous()) }}

            @if (isset($user->id))
                {{Form::hidden('id',$user->id)}}
            @endif

            <div class="md-form input-group">
                {{Form::text('login',null,array('class' => 'form-control user-login-ldap-loader', 'id'=>'login'))}}
                {{Form::label('login', 'Логин')}}
                <span class="input-group-addon" id="basic-addon2">{{ config('app.domain') }}</span>
            </div>
            @if ($errors->has('login'))
                <p class="text-danger form-error-msg">{{ $errors->first('login') }}</p>
            @endif

            <div class="md-form">
                {{Form::text('name',null,array('class' => 'form-control', 'id'=>'name'))}}
                {{Form::label('name', 'Имя пользователя')}}
            </div>
            @if ($errors->has('name'))
                <p class="text-danger form-error-msg">{{ $errors->first('name') }}</p>
            @endif

            <div class="md-form">
                {{Form::text('rusname',null,array('class' => 'form-control', 'id'=>'rusname'))}}
                {{Form::label('rusname', 'Русскоязычное имя пользователя')}}
            </div>
            @if ($errors->has('rusname'))
                <p class="text-danger form-error-msg">{{ $errors->first('rusname') }}</p>
            @endif

            <div class="md-form">
                {{Form::text('title',null,array('class' => 'form-control', 'id'=>'title'))}}
                {{Form::label('title', 'Должность')}}
            </div>
            @if ($errors->has('title'))
                <p class="text-danger form-error-msg">{{ $errors->first('title') }}</p>
            @endif

            <div class="md-form">
                {{Form::text('department',null,array('class' => 'form-control', 'id'=>'department'))}}
                {{Form::label('department', 'Отдел')}}
            </div>
            @if ($errors->has('department'))
                <p class="text-danger form-error-msg">{{ $errors->first('department') }}</p>
            @endif

            <div class="md-form">
                {{Form::text('employeenumber',null,array('class' => 'form-control', 'id'=>'employeenumber'))}}
                {{Form::label('employeenumber', 'Код сотрудника')}}
            </div>
            @if ($errors->has('employeenumber'))
                <p class="text-danger form-error-msg">{{ $errors->first('employeenumber') }}</p>
            @endif

            <div class="md-form">
                {{Form::text('phone',null,array('class' => 'form-control', 'id'=>'phone'))}}
                {{Form::label('phone', 'Телефонный номер')}}
            </div>
            @if ($errors->has('phone'))
                <p class="text-danger form-error-msg">{{ $errors->first('phone') }}</p>
            @endif

            <div class="switch">
                <label>
                  Off
                  {{Form::checkbox('admin',1,$user->admin,array('class' => 'form-control', 'id'=>'user_admin'))}}
                  <span class="lever"></span>
                  On
                </label>   
                <label for='user_admin' class='ml-2' style='font-size:15px;'>Функция администрирования системы</label>
            </div>

        </div>
                
        <div class='col-sm-1'>
            <img src="/img/loader.gif" id='loader'>
        </div>

        <div class='col-sm-6'>

            {{Form::hidden('avatar',$user->avatar,array('id'=>'avatar'))}}            
            <img src='{{ $user->avatar or '' }}' id='imgavatar' class='rounded-circle mb-3'>
           
            <div class="md-form">
                {{Form::select('flow_id',$flows,$user->flow_id,['class'=>'mdb-select colorful-select dropdown-info','id'=>'flow_id'])}}
                {{Form::label('flow_id', 'Поток пользователя')}}
            </div>


            <div class="md-form">
                <input type="text" id="mentor-autocomplete" class="form-control mdb-autocomplete" name="mentor" autocomplete="off" value="{{ old('mentor') ?? $user->mentor->name ?? '' }}">
                <label for="mentor-autocomplete" class="active">Отвественный за аттестацию</label>
            </div>


            <!--div class="md-form">
                {{Form::select('mentor_user_id',$users,$user->mentor_user_id,['class'=>'mdb-select colorful-select dropdown-info','id'=>'mentor_user_id'])}}
                {{Form::label('mentor_user_id', 'Отвественный за аттестацию')}}
            </div-->

            <div class="md-form">
                {{Form::select('current_profile_id',$profiles,$user->current_profile_id,['class'=>'mdb-select','id'=>'current_profile_id'])}}
                {{Form::label('current_profile_id', 'Текущий профиль')}}
            </div>

            <div class="md-form">
                {{Form::select('target_profile_id',$profiles,$user->target_profile_id,['class'=>'mdb-select','id'=>'target_profile_id'])}}
                {{Form::label('target_profile_id', 'Целевой профиль')}}
            </div>

        </div>

    </div>
    <div class='row mt-2'>
        <div class='col-sm-5'>
            <div class="text-xs-center">
                <button class="btn btn-default">@lang('messages.Submit')</button>
            </div>
        </div>
    </div>
    {{Form::close()}}

    <!-- Modal -->
    <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title w-100" id="myModalLabel"></h4>
                </div>
                <!--Body-->
                <div class="modal-body">
                    
                </div>
                <!--Footer-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Ok. Ясно</button>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>

    <script type="text/javascript">
    
    $(function() {

        var users = [
        @foreach ($users as $u)
            "{{ $u }}"
            @if (!$loop->last)
                ,
            @endif
        @endforeach
        ];

        $('#mentor-autocomplete').autoComplete({
            minChars: 2,
            source: function(term, suggest){
                term = term.toLowerCase();
                var choices = users;
                var matches = [];
                for (i=0; i<choices.length; i++)
                if (~choices[i].toLowerCase().indexOf(term)) matches.push(choices[i]);
                    suggest(matches);
                }
        });

    });
    
    </script>

@endsection
