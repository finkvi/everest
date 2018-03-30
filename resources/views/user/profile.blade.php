@extends('layouts.app')

@section('content')

    <a href='/user/sync-ad/{{ $user->id }}' class='btn btn-info btn-md pull-right'><i class='fa fa-refresh left'></i> &nbsp; Синхронизировать с AD</a>
    <h1 class="h1-responsive">{{ $H1 }}</h1>

    <div class='row mt-3'>
        <div class='col-sm-2' style='text-align:center;'>

            <img src='{{ strlen($user->avatar)>5 ? $user->avatar : "/img/icon_user_256.png"}}' class='rounded-circle'>

            @if ($myProfile)
                <br><br>
                <a href="#" class='show-form'><i class='fa fa-pencil'></i> Изменить</a>

                <form action="/user/avatar" method="post" enctype="multipart/form-data" class='mt-2' id='form2show' style='display:none'>
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="file-field">
                        <div class="btn btn-primary btn-sm" style='line-height:20px; display:inline-block; margin:0 auto; float:none;'>
                            <span>Выберите файл</span>
                            <input type="file" name="avatar" onChange=" $('#file-path').val( $(this).val() ); $('.show-after-select').slideDown(300); ">
                        </div>

                        <div class="file-path-wrapper show-after-select" id="file-path-wrapper" style='display:none;'>
                            <input class="file-path validate" type="text" placeholder="Загрузите аватар" id='file-path' style='text-align:center;'>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-cyan btn-sm show-after-select" style='display:none;'>Загрузить</button>
                </form>

                <script type="text/javascript">
                    $('.show-form').click(function(){
                        $('#form2show').slideDown(300);
                        $(this).hide();
                    });
                </script>
            @endif
        </div>
        <div class='col-sm-4'>
            <h2>{{ $user->name }}</h2>
            <h5>{{ $user->rusname }}</h5>

            <dl class='mt-2'>
                <dt>Позиция</dt>
                <dd>{{ $user->title }}</dd>

                <dt>Отдел</dt>
                <dd>{{ $user->department }}</dd>

                @if ($user->phone)
                    <dt>Телефон</dt>
                    <dd>{{ $user->phone }}</dd>
                @endif

                <dt>Электронный адрес</dt>
                <dd><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></dd>
            </dl>
        </div>
        <div class='col-sm-3'>
            <dl class='mt-0'>
                @if (isset($user->flow->id))
                <dt>Бизнесс юнит</dt>
                <dd>{{ $user->flow->bu->name }}</dd>

                <dt>Поток</dt>
                <dd>{{ $user->flow->name }}</dd>
                @endif

                <dt>Текущий профиль</dt>
                <dd>
                    {{ $user->currentProfile->name or 'не определен'}}
                    @if (isset($user->currentProfile->id)) <span class="tag grey">{{$user->currentProfile->grade}}</span>  @endif
                </dd>

                <dt>Целевой профиль</dt>
                <dd>
                    {{ $user->targetProfile->name or 'не определен'}}
                    @if (isset($user->targetProfile->id)) <span class="tag green">{{$user->targetProfile->grade}}</span>  @endif
                </dd>

                <dt>Ответственный за развитие</dt>
                <dd>
                    @if (isset($user->mentor->id))

                        @if ($user->mentor->avatar)
                            <img src="{{ $user->mentor->avatar }}" alt="{{ $user->mentor->name }}" class='rounded-circle' style='height:32px; width:auto;'>
                        @endif
                        {{ $user->mentor->name }}

                    @else
                        не задан
                    @endif
                </dd>
            </dl>
        </div>
        <div class='col-sm-3'>
            <dl>
                @if (count($user->flpOfFlows) > 0)
                <dt>FLP потока:</dt>
                <dd>
                    @foreach($user->flpOfFlows as $f)
                        {{ $f->name }}<br>
                    @endforeach
                </dd>
                @endif

                @if (count($user->dpOfPrograms) > 0)
                <dt>Директор программы:</dt>
                <dd>
                    @foreach($user->dpOfPrograms as $p)
                        {{ $p->name }}<br>
                    @endforeach
                </dd>
                @endif

                @if (count($user->flow_program) > 0)
                <dt>Лидер программы:</dt>
                <dd>
                    @foreach($user->flow_program as $fp)
                        {{ $fp->program->name }} ({{ $fp->flow->name }})<br>
                    @endforeach
                </dd>
                @endif

                @if (count($user->rpOfProjects) > 0)
                <dt>Руководитель проекта:</dt>
                <dd>
                    @foreach($user->rpOfProjects as $p)
                        {{ $p->name }} <br>
                    @endforeach
                </dd>
                @endif

                @if (count($user->projects) > 0)
                <dt>Участник в проектах:</dt>
                <dd>
                    @foreach($user->projects as $p)
                        {{ $p->name }} <small>{{ App\Profile::find($p->pivot->profile_id)->name }}</small><br>
                    @endforeach
                </dd>
                @endif

                @if (count($user->flow_project) > 0)
                <dt>Тим лидер на проекте:</dt>
                <dd>
                    @foreach($user->flow_project as $fp)
                        {{ $fp->project->name }} <small>({{ $fp->flow->name }})</small><br>
                    @endforeach
                </dd>
                @endif


            </dl>
        </div>
    </div>

    @if ($currentProfileNames && $user->currentProfile)

    <div class='row mt-3'>
        <div class='col-lg-4'>

            <table class='table table-sm table-striped profile-competences-table'>
            <thead class='teal lighten-5'>
            <tr>
                <th style='vertical-align:top;'>Компетенция</th>
                <th class='text-center grey white-text' style='vertical-align:top;'>{{ $user->currentProfile->name }}</th>
                <th class='text-center warning-color-dark white-text' style='vertical-align:top;'>Текущая оценка</th>
                @if (isset($user->targetProfile))
                    <th class='text-center green white-text' style='vertical-align:top;'>{{ $user->targetProfile->name }}</th>
                @endif
            </tr>
            </thead>
            @foreach ($currentProfileNames as $i=>$n)
            <tr>
                <td>{{ $n }}</td>
                <?
                    $c = App\CompetenceLevel::where('competence_id',$i)->pluck('description','level');
                    //dd($c);
                ?>
                <td class='text-center'>
                    <span class='tag grey' style='font-size:13px; cursor:pointer;'
                        @if (isset($c[$currentProfileLevels[$i]]))
                            tabindex="0" data-toggle="popover" data-placement="right" data-trigger="focus"
                            title='{{ $n }}'
                            data-content="{{ $c[$currentProfileLevels[$i]] or 'нет описания' }}"
                        @endif
                    >{{ $currentProfileLevels[$i] }}</span></td>

                <? $last_competence_value = $currentProfileLevels[$i]; ?>

                <td class='text-center'>
                    <span class='tag warning-color-dark' style='font-size:13px; cursor:pointer;'
                        @if (isset($c[$last_evaluation['values'][$i]]))
                            tabindex="0" data-toggle="popover" data-placement="right" data-trigger="focus"
                            title='{{ $n }}'
                            data-content="{{ $c[$last_evaluation['values'][$i]] or 'нет описания' }}"
                        @endif
                    >{{ $last_evaluation['values'][$i] or '-'}}</span>
                </td>
                <? if ($last_evaluation['values'][$i]) { $last_competence_value = $last_evaluation['values'][$i]; } ?>


                @if (isset($user->targetProfile))
                    <td class='text-center @if ($targetProfileLevels[$i]>$last_competence_value) #ef9a9a red lighten-3 @endif'>
                        <span class='tag green' style='font-size:13px; cursor:pointer;'
                            @if (isset($c[$targetProfileLevels[$i]]))
                                tabindex="0" data-toggle="popover" data-placement="right" data-trigger="focus"
                                title='{{ $n }}'
                                data-content="{{ $c[$targetProfileLevels[$i]] or 'нет описания' }}"
                            @endif
                        >{{ $targetProfileLevels[$i] or "-"}}</span>
                    </td>
                @endif
            </tr>
            @endforeach
            </table>

        </div>
        <div class='col-lg-8'>
            <div id="legendDiv"></div>
            <canvas id="PL" class='wow'></canvas>
        </div>
    </div>

        <script type="text/javascript">
        $(function () {

            var data = {
                labels: [ "{!! implode('","',$currentProfileNames) !!}" ],
                datasets: [
                    {
                        label: "{{ $user->currentProfile->name }}",
                        fillColor: "rgba(150,150,150,0.2)",
                        strokeColor: "rgba(150,150,150,1)",
                        pointColor: "rgba(150,150,150,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(150,150,150,1)",
                        data: [ {{ implode(',',$currentProfileLevels) }}]
                    }
                @if (count($last_evaluation)>0)
                <?
                    //$color = "147,65,100"
                    $color = "255,136,0";
                ?>
                    ,
                    {
                        label: "Текущая оценка",
                        fillColor: "rgba({{$color}},0.05)",
                        strokeColor: "rgba({{$color}},1)",
                        pointColor: "rgba({{$color}},1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba({{$color}},1)",
                        data: [
                        @foreach ($targetProfileLevels as $i=>$name)
                            @if (!$loop->first)
                                ,
                            @endif
                            {{ $last_evaluation['values'][$i] or '0' }}
                        @endforeach
                        ]
                    }
                @endif
                @if ($targetProfileLevels)
                <?
                    //$color = "147,65,100"
                    $color = "76,175,80";
                ?>
                    ,
                    {
                        label: "{{ $user->targetProfile->name }}",
                        fillColor: "rgba({{$color}},0.05)",
                        strokeColor: "rgba({{$color}},1)",
                        pointColor: "rgba({{$color}},1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba({{$color}},1)",
                        data: [ {{ implode(',',$targetProfileLevels)}}]
                    }
                @endif
                ]
            };

            var options = {
                animation: true,
                animationSteps: 120,
                responsive: true
            };

            var ctx = document.getElementById("PL").getContext('2d');
            var PL = new Chart(ctx).Radar(data, options);
            document.getElementById("legendDiv").innerHTML = PL.generateLegend();

        });
        </script>

    <div class='row mt-2'>
        <div class='lg-12'>
            <h3>
                Оценка
                <a href='#evaluationBlock' class="collapseBtn arrow-r" data-toggle="collapse" data-target="#evaluationBlock" aria-controls="evaluationBlock" style='margin-left:5px; display:inline-block; vertical-align:middle; outline:none;'>
                    {{-- <i class='arrow fa fa-caret-right rotate-icon'></i> --}}
                    <i class="fa fa-angle-down rotate-icon"></i>
                </a>
            </h3>

            <div class='collapse' id='evaluationBlock'>
            @if (!$targetProfileLevels)
                Необходимо установить целевой профиль, к которому стремиться, для проведения оценки.
            @else

                <table class='table table-sm table-striped profile-competences-table evaluation-table'>
                <thead class='teal lighten-5'>
                <tr>
                    <th></th>
                    @foreach ($currentProfileNames as $i=>$n)
                        <th class='text-center'>{{ $n }}</th>
                    @endforeach
                </tr>
                </thead>
                <? $last_competence_value = []; ?>
                <tr>
                    <th>{{ $user->currentProfile->name}}</th>
                    @foreach ($currentProfileLevels as $i=>$level)
                        <td class='text-center'>{{ $level }}</td>
                        <? $last_competence_value[$i] = $level; ?>
                    @endforeach
                </tr>

                @if (count($evaluations)>0)
                    @foreach ($evaluations as $e)
                    <tr>
                        <th>
                            {{ $e['evaluator'] }} <br><small>{{ $e['date'] }}</small>
                            @if ($e['comment'])
                                <a class='brown-text' style='outline:none;' tabindex="0" data-toggle="popover" data-placement="right" data-trigger="focus" title='{{ $e['evaluator'] }}' data-content="{{ $e['comment'] }}"><i class='fa fa-commenting-o'></i></a>
                            @endif
                        </th>
                        @foreach ($targetProfileLevels as $i=>$level)
                            <td class='text-center'>
                                @if (isset($e['subvalues'][$i]))
                                    <a class='ml-0'>
                                        <span class='tag default-color white-text' style='font-size:12px;'
                                            tabindex="0" data-toggle="popover" data-placement="top" data-trigger="focus"
                                            title='Детализация компетенции'
                                            data-content="
                                            @if (count($e['subvalues'][$i])>0)
                                                <table class='table no-top-border-tbl'>
                                                @foreach ($e['subvalues'][$i] as $sc)
                                                <tr>
                                                    <td>{{ $sc['name'] or '-' }}:</td><td><span class='tag default-color white-text' style='font-size:12px;'>{{ $sc['value'] or '-' }}</span></td>
                                                </tr>
                                                @endforeach
                                                </table>
                                            @else
                                                недоступно
                                            @endif
                                            "
                                        >
                                        {{ $e['values'][$i] or "-"}}
                                        </span>
                                    </a>
                                @else
                                    {{ $e['values'][$i] or "-"}}
                                @endif

                            </td>
                            <? if (isset($e['values'][$i])) { $last_competence_value[$i] = $e['values'][$i]; } ?>
                        @endforeach
                    </tr>
                    @endforeach
                @endif

                <tr>
                @if (isset($user->targetProfile))
                    <th>{{ $user->targetProfile->name}}</th>
                    @foreach ($targetProfileLevels as $i=>$level)
                    <td class='text-center @if ($targetProfileLevels[$i]>$last_competence_value[$i]) #ef9a9a red lighten-3 @endif'>{{ $level or "-"}}</td>
                    @endforeach
                @endif
                </tr>

                </table>

                @if ($myProfile)
                    <a href='/evaluate' class='btn btn-info'>Провести cамооценку</a>
                @else
                    <a href='/evaluate/{{$user->id}}' class='btn btn-info'>Провести оценку сотрудника</a>
                @endif
            @endif
            </div>

        </div>
    </div>
    @endif <? /* if currentProfile */ ?>

    @if (isset($user->targetProfile))
    <div class='row mt-3' id='tasks'>
        <div class='lg-12'>
            <h3>Задачи по развитию компетенций</h3>

            @if (!count($gaps))
                Компетенции соответствуют целевому профилю
                <br><br><br>
            @else
                <table class='table table-sm'>
                <thead class='teal lighten-5'>
                <tr>
                    <th width='20%'>Развитие</th>
                    <th width='60%'><span class='ml-2'>Задачи</span></th>
                    <th width='20%' class='text-center'>Выполнение</th>
                </tr>
                </thead>

                @foreach ($gaps as $c_id=>$gap)
                <?
                    $c = App\CompetenceLevel::where('competence_id',$c_id)->pluck('description','level');
                ?>
                <tr>
                    <th>
                        {{ $gap['competence'] }}<br>
                        <span class='tag grey' style='cursor:pointer;'
                            @if (isset($c[$gap['from']]))
                                tabindex="0" data-toggle="popover" data-placement="right" data-trigger="focus"
                                title='{{ $gap['competence'] }}'
                                data-content="{{ $c[$gap['from']] or 'нет описания' }}"
                            @endif
                        >{{ $gap['from'] }}</span>
                        <i class="fa fa-arrow-right" style='font-size:13px;'></i>
                        <span class='tag green' style='cursor:pointer;'
                            @if (isset($c[$gap['to']]))
                                tabindex="0" data-toggle="popover" data-placement="right" data-trigger="focus"
                                title='{{ $gap['competence'] }}'
                                data-content="{{ $c[$gap['to']] or 'нет описания' }}"
                            @endif
                        >{{ $gap['to'] }}</span>
                    </th>
                    <td>
                        <?
                            $tasks_count = 0;
                            $tasks_confirmed = 0;
                        ?>
                        <div class="accordion" id="accordion{{$c_id}}" role="tablist" aria-multiselectable="true">
                        @foreach($user->tasks()->where('competence_id',$c_id)->orderBy('id','desc')->limit(5)->get() as $t)
                        <?
                            $tasks_count++;
                            $tasks_confirmed += $t->confirmed;
                        ?>

                            <!-- Panel-->
                            <div class="panel panel-default" style='width:100%;'>

                                <!--Panel heading-->
                                <div class="panel-heading" role="tab" id="heading{{$c_id}}_{{$tasks_count}}">
                                    <h5 class="panel-title ml-0" style='width:100%;'>

                                        <span style='float:right;'>
                                        @if (!$t->completed && Auth::user()->id==$t->user_id)
                                            <a title='Пометить задачу выполненной' class='task-marker task-mark-completed' task_id='{{$t->id}}'><i class='fa fa-check-square-o'></i></a>
                                        @endif
                                        @if ($t->completed)
                                            <a title='Сотрудник выполнил задачу' class='task-marker green-text'><i class='fa fa-check-square-o'></i></a>
                                        @endif
                                        @if (!$t->confirmed && $t->completed && Auth::user()->id==$t->creator_user_id)
                                            <a title='Подтвердить выполнение' class='task-marker task-mark-confirmed' task_id='{{$t->id}}'><i class='fa fa-check-square'></i></a>
                                        @endif
                                        @if ($t->confirmed)
                                            <a title='Ответственный подтвердил выполнение' class='task-marker green-text'><i class='fa fa-check-square'></i></a>
                                        @endif
                                        </span>

                                        <a class="arrow-r ml-0" style='outline:none;' data-toggle="collapse" data-parent="#accordion{{$c_id}}" href="#collapse{{$c_id}}_{{$tasks_count}}" aria-expanded="false" aria-controls="collapse{{$c_id}}_{{$tasks_count}}">
                                            {{ $t->title }}
                                        </a>

                                    </h5>
                                </div>

                                <!--Panel body-->
                                <div id="collapse{{$c_id}}_{{$tasks_count}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$c_id}}_{{$tasks_count}}">
                                    <small>{{ $t->creator->name }} / {{ date('d.m.y',strtotime($t->created_at)) }}</small><br>
                                    {!! nl2br($t->task) !!}
                                </div>
                            </div>
                            <!--/.Panel-->

                        @endforeach
                        </div>

                        <br>
                        @if ( (isset($user->mentor) && Auth::user()->id == $user->mentor->id) || Auth::user()->admin )
                            <a href='/task/{{ $user->id }}/{{ $c_id }}' class='btn btn-info btn-sm ml-2'><i class='fa fa-plus left'></i> Добавить задачу</a>
                        @endif
                    </td>
                    <td class='text-center'>
                        <span class="min-chart" id="chart{{ $c_id }}" data-percent="{{ $tasks_count>0 ? $tasks_confirmed/$tasks_count*100 : 0 }}"><span class="percent"></span></span>
                        <!-- <h5><span class="tag green">Выполнение <i class="fa fa-arrow-circle-up"></i></span></h5> -->

                        <script type="text/javascript">
                            $(function () {
                                $('.min-chart#chart{{ $c_id }}').easyPieChart({
                                    barColor: "#4caf50",
                                    onStep: function (from, to, percent) {
                                        $(this.el).find('.percent').text(Math.round(percent));
                                    }
                                });
                            });
                        </script>

                    </td>
                </tr>
                @endforeach

                </table>

                <script type="text/javascript">
                    $('.task-mark-completed').click(function(){
                        if (confirm('Пометить выполнение задачи?'))
                        {
                            var url = "/task-complete/"+$(this).attr('task_id')
                            //alert(url);
                            $.get(url);
                            $(this).addClass('green-text');
                        }
                        return false;
                    });

                    $('.task-mark-confirmed').click(function(){
                        if (confirm('Подтвердить выполнение задачи?'))
                        {
                            var url = "/task-confirm/"+$(this).attr('task_id')
                            //alert(url);
                            $.get(url);
                            $(this).addClass('green-text');
                        }
                        return false;
                    });

                </script>
            @endif
        </div>
    </div>
    @endif


    @if (Auth::user()->admin || Auth::user()->id == $user->mentor_user_id || Auth::user()->id == $user->id)

    <a href='#' id='salaryShow' class='salaryShowSwitcher' style='border-bottom:1px dotted #4ABDE8'><i class='fa fa-eye'></i> Показать историю изменения заработной платы &raquo;</a>
    <br>
    <a href='#' id='salaryHide' class='salaryShowSwitcher' style='border-bottom:1px dotted #4ABDE8; display:none;'><i class='fa fa-eye-slash'></i> Спрятать историю изменения заработной платы &raquo;</a>

    <div class='row mt-3' id='salary'>
        <div class='lg-12'>
            <h3>История изменения заработной платы и грейда</h3>

            @if (isset($user->salary) && count($user->salary)>0)

            <h5>За всё время работы в компании я заработал <b>{{ number_format(array_sum($salary_chart['values']),0,'.',' ') }} ₽</b></h5>

            <div class='row mt-3'>
                <div class='col-lg-4'>

                    <table class='table table-sm table-striped'>
                    <thead class='teal lighten-5'>
                    <tr>
                        <th class='text-center'>Дата</th>
                        <th class='text-center'>Грейд</th>
                        <th class='text-center'>Зарплата</th>
                        @if (Auth::user()->admin || Auth::user()->id == $user->mentor_user_id)
                            <th>&nbsp;</th>
                        @endif
                    </tr>
                    </thead>

                    @foreach ($user->salary()->orderBy('date','desc')->get() as $s)
                    <tr @if ($loop->first) class='deep-orange lighten-4' @endif>
                        <td class='text-center'>{{ date('d.m.Y',strtotime($s->date)) }}</td>
                        <td class='text-center'>{{ $s->grade }}</td>
                        <td class='text-center'>{{ number_format($s->money,0,'.',' ') }} ₽</td>
                        @if (Auth::user()->admin || Auth::user()->id == $user->mentor_user_id)
                            <td><a href='/user/salary/{{ $user->id }}/{{ $s->id }}' class="teal-text"><i class="fa fa-pencil"></i></a></td>
                        @endif
                        <?
                            $salary_months[] = date("F Y",strtotime($s->date));
                            $salary_money[] = $s->money;
                        ?>
                    </tr>
                    @endforeach
                    </table>
                </div>
                <div class='col-lg-8'>

                    <canvas id="Salary"></canvas>


                    <script type="text/javascript">
                    $(function () {

                        var data = {
                        //labels: [ '{!! implode("','",array_reverse($salary_months)) !!}' ],
                        labels: [ '{!! implode("','",$salary_chart['labels']) !!}' ],
                        datasets: [
                            {
                                label: "Заработная плата",
                                fillColor: "rgba(151,187,205,0.2)",
                                strokeColor: "rgba(151,187,205,1)",
                                pointColor: "rgba(151,187,205,1)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(151,187,205,1)",
                                //data: [ {{ implode(",",array_reverse($salary_money))}} ]
                                data: [ {{ implode(",",$salary_chart['values'])}} ]
                            }
                            ]
                        };

                        <?
                            $chart_end = max($salary_chart['values']);
                            $chart_start = min($salary_chart['values']);
                            $chart_steps = abs(intval($chart_end/10000))-abs(intval($chart_start/10000))+2;
                        ?>

                        var option = {
                            responsive: true,
                            scaleBeginAtZero: true,
                            showScale: true,
                            scaleOverride: true,
                            scaleSteps: {{ $chart_steps }}, //10,
                            scaleStepWidth: 10000,
                            scaleStartValue: {{ $chart_start-10000 }}
                        };

                        // Get the context of the canvas element we want to select
                        var salary_ctx = document.getElementById("Salary").getContext('2d');
                        var mySalary = new Chart(salary_ctx).Line(data, option); //'Line' defines type of the chart.
                        //var mySalary = new Chart(salary_ctx).Bar(data, option);
                    });
                    </script>

                </div>
            </div>

            @endif

            @if (Auth::user()->admin || Auth::user()->id == $user->mentor_user_id)
                <a href='/user/salary/{{$user->id}}' class='btn btn-info'>Добавить изменение зарплаты/грейда</a>
            @endif

        </div>
    </div>

    <script type="text/javascript">
    $(function(){
        $('#salary').hide();
    });
        $('.salaryShowSwitcher').click(function(){
            $('#salary').slideToggle(300);
            $('.salaryShowSwitcher').slideToggle(300);
            return false;
        });
    </script>

    @endif

@endsection