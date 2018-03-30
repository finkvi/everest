@extends('layouts.app')

@section('content')

    <h1 class="h1-responsive">{{ $project->name }} - @lang('messages.Users')</h1>

    Укажите сотрудников, кототорых необходимо включить в проект &laquo;{{ $project->name }}&raquo;
    <br>
    Здесь отображены потоки, которые прикреплены к проекту
    <br><br>

    {{Form::model($project,['route' => ['project.storeusers'], 'files'=>false])}}

        {{ csrf_field() }}
        {{Form::hidden('_method','post')}}
        {{Form::hidden('project_id',$project->id)}}

        @foreach ($projectFlows as $f)

            <h2 class='mt-3 mb-2'>{{ $f->name }}</h2>
            @foreach ($f->users()->orderBy('name','asc')->get() as $u)
            <?
                $flowProfiles = $f->profiles()->orderBy('grade','asc')->orderBy('order','asc')->pluck('name','id')->toArray();
                $flowProfiles = ['0'=>'Роль на проекте']+$flowProfiles;
            ?>
                <div class='row mb-0'>
                    <fieldset class="form-group col-sm-3 mt-1">
                        {{Form::checkbox('users['.$u->id.']',$u->id,in_array($u->id,$projectUsersIDs),array('class' => 'form-control', 'id'=>'chk'.$u->id))}}
                        {{Form::label('chk'.$u->id, $u->name)}}
                    </fieldset>
                    <fieldset class="form-group col-sm-5">
                        {{Form::select('profiles['.$u->id.']',$flowProfiles,$projectUsers[$u->id] ?? $u->current_profile_id,['class'=>'mdb-select colorful-select dropdown-info profile-selector','user_id'=>$u->id])}}
                        
                    </fieldset>
                </div>
            @endforeach
        @endforeach
        
        <div class="text-xs-center">
            <button class="btn btn-default waves-effect">@lang('messages.Submit')</button>
        </div>

    {{Form::close()}}

<script type="text/javascript">
    $('.profile-selector').change(function(){
        if ($(this).val() > 0)
            $('#chk'+$(this).attr('user_id')).prop('checked',true);
        else
            $('#chk'+$(this).attr('user_id')).prop('checked',false);
    });
</script>

@endsection
