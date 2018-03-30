@extends('layouts.app')

@section('content')

    <h1 class="h1-responsive">{{ $H1 }}</h1>

    {{Form::model($evaluation,['route' => ['evaluate.store'], 'files'=>false,'class'=>'mt-2'])}}
    <div class='row'>
        <div class='col-sm-12'>
    
            {{ csrf_field() }}
            {{Form::hidden('_method','post')}}

            @if (isset($evaluation->id))
                {{Form::hidden('id',$evaluation->id)}}
            @endif

            {{Form::hidden('user_id',$user->id)}}

            @foreach ($competences as $c)
            <div class='row mb-2'>
                <div class='col-sm-5'>
                    <fieldset class="form-group">
                        <div class="range-field">
                            <label>{{ $c->name }}</label>
                            <input name='levels[{{ $c->id }}]' id='control{{$c->id}}' competence_id='{{$c->id}}' class='range-control' type="range" min="0" max="{{ config('everest.max_competence_level') }}" value='{{ $last_evaluation['values'][$c->id] or '0' }}'>
                        </div>
                    </fieldset>

                    @if ($c->sublevels)
                    <div style='background:linear-gradient(to bottom,#fafafa,#eee); padding:10px 20px 10px 40px; margin-left:-40px;'>
                        Детализация компетенции
                        <a href='#block{{ $c->id }}' class="collapseBtn arrow-r" data-toggle="collapse" data-target="#block{{ $c->id }}" aria-controls="block{{ $c->id }}" style='margin-left:5px; display:inline-block; vertical-align:middle; outline:none; font-size:21px;'>
                            <i class="fa fa-angle-down rotate-icon"></i>
                        </a>
                        <div class='collapse @if (isset($last_evaluation['subvalues'])) in @endif mb-0 mt-1' id='block{{ $c->id }}'>
                        @if ($c->subcompetences)
                            @foreach($c->subcompetences as $sc)
                            <div class='row' style='font-size:0;'>
                                <div class='col-sm-10 pb-1 mb-1' style='border-bottom:1px solid #ccc; display:inline-block; vertical-align:bottom; float:none; font-size:16px;'>
                                    {{ $sc->name }}
                                </div>
                                <div class='col-sm-2' style='display:inline-block; float:none;'>
                                    {{Form::selectRange('sublevels['.$sc->id.']', 0, config('everest.max_competence_level'),$last_evaluation['subvalues'][$sc->id] ?? '0',['class'=>'mdb-select dropdown-info','id'=>'control'.$sc->id])}}
                                </div>
                            </div>
                            @endforeach
                        @endif
                        </div>
                    </div>
                    @endif
                </div>
                <div class='col-sm-5 offset-sm-1'>
                    <p id='description{{$c->id}}'>
                        {!! isset($last_evaluation['description'][$c->id]) ? nl2br($last_evaluation['description'][$c->id]) : '-' !!}
                    </p>
                </div>
            </div>
            @endforeach

            <div class="md-form">
                {{Form::textarea('comment',$evaluation->comment,['id'=>'comment','class'=>'md-textarea'])}}
                {{Form::label('comment','Комментарий')}}
            </div>


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

    <script type="text/javascript">
        $('.range-control').change(function(){
            var url = "/competence-level/"+$(this).attr('competence_id')+"/"+$(this).val();
            //alert(url);
            $('#description'+$(this).attr('competence_id')).html("<img src='/img/loader.gif'>");
            $('#description'+$(this).attr('competence_id')).load(url);
        });
    </script>

@endsection
