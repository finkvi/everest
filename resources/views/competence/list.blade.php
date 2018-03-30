@extends('layouts.app')

@section('content')

    <h1 class="h1-responsive mb-3">@lang('messages.Competences')</h1>

    <div style="position:fixed; bottom:45px; right:24px;">
        <a href='/admin/competence/store' class="btn-floating btn-large red" title='@lang('messages.Add')'>
            <i class="fa fa-plus"></i>
        </a>
    </div>

    @foreach ($competences as $c)
    <div id='block{{$c->id}}'><br>
        <div class='row mt-2' style='background:linear-gradient(to bottom,#f7f7f5,#fff);'>
            <div class='col-sm-3 mt-1'>
                <h4 style="display:inline-block; vertical-align:middle;">{{ $c->name }}</h4>
                <div style='display:inline-block; vertical-align:middle; white-space:nowrap; margin-right:20px; '>
                    <a href='/admin/competence/store/{{ $c->id }}' class="teal-text" style='margin-left:5px;'><i class="fa fa-pencil"></i></a>
                    <a href='/admin/competence/delete/{{ $c->id }}' class="link2delete red-text" style='margin-left:5px;'><i class="fa fa-times"></i></a>
                    <a href='#collapse{{$c->id}}' class="collapseBtn" data-toggle="collapse" data-target="#collapse{{$c->id}}" aria-controls="collapse{{$c->id}}" style='margin-left:5px;'>
                        <i class='arrow fa fa-caret-right'></i>
                    </a>
                </div>

                @if ($c->sublevels)                        
                    <div class='chip mt-1 brown-text' style='display:inline-block; vertical-align:middle; max-width:100%; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; '>Включена детализация</div>
                @endif

            </div>
            <div class='col-sm-9 collapse' id='collapse{{$c->id}}'>
                <table class='table'>
                @foreach ($c->levels as $cl)
                <tr>
                    <td><h5><span class="tag info-color">{{ $cl->level }}</span></h5></td>
                    <td style='font-si2ze:15px;'>{!! nl2br($cl->description) !!}</td>
                    <td style='white-space:nowrap;'>
                        <a href='/admin/clevel/store/{{ $c->id }}/{{ $cl->id }}' class="teal-text"><i class="fa fa-pencil"></i></a>
                        <a href='/admin/clevel/delete/{{ $cl->id }}' class="link2delete red-text"><i class="fa fa-times"></i></a>
                    </td>
                </tr>
                @endforeach
                </table>
                <a href="/admin/clevel/store/{{ $c->id }}" class="btn btn-cyan btn-sm"><i class="fa fa-plus left"></i> Добавить уровень</a>

                @if ($c->sublevels)
                    <div class='mt-2'>
                        <h4>
                            Детализация
                            <a href='/admin/subcompetence/{{ $c->id }}' class="btn-floating btn-sm red" title='@lang('messages.Add')'>
                                <i class="fa fa-plus"></i>
                            </a>
                        </h4>
                        @if (count($c->subcompetences)>0)
                            @foreach ($c->subcompetences()->orderBy('name','asc')->get() as $sc)

                                <div style='display:inline-block; float:none; margin-right:40px;'>
                                    <h6 style="display:inline-block;">{{ $sc->name }}</h6>
                                    <div style='display:inline-block; white-space:nowrap;'>
                                        <a href='/admin/subcompetence/{{ $c->id }}/{{ $sc->id }}' class="teal-text" style='margin-left:5px;'><i class="fa fa-pencil"></i></a>
                                        <a href='/admin/subcompetence-delete/{{ $sc->id }}' class="link2delete red-text" style='margin-left:5px;'><i class="fa fa-times"></i></a>
                                    </div>
                                </div>

                                    <? /*
                                    <div class='col-sm-9'>
                                        <table class='table'>
                                        @foreach ($sc->levels()->orderBy('level','asc')->get() as $scl)
                                        <tr>
                                            <td><h6><span class="tag info-color">{{ $scl->level }}</span></h6></td>
                                            <td style='font-si2ze:15px;'>{!! nl2br($scl->description) !!}</td>
                                            <td style='white-space:nowrap;'>
                                                <a href='/admin/subclevel/store/{{ $sc->id }}/{{ $scl->id }}' class="teal-text"><i class="fa fa-pencil"></i></a>
                                                <a href='/admin/subclevel/delete/{{ $scl->id }}' class="link2delete red-text"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </table>
                                        <a href="/admin/subclevel/store/{{ $sc->id }}" class="btn btn-cyan btn-sm"><i class="fa fa-plus left"></i> Добавить уровень субкомпетенции</a>                                        
                                    </div>
                                    */ ?>

                            @endforeach
                        @endif
                    </div>
                @endif

            </div>

        </div>        
    </div>
    @endforeach

    <script type="text/javascript">
    $(function()
    {
        function updateBtnArrow(obj,cl)
        {
            $(obj).removeClass('fa-caret-down').removeClass('fa-caret-right').addClass(cl);
        }

        var hash = window.location.hash;
        //alert(hash);
        if (hash)
        {
            $(hash).find('.collapse').collapse('show');
            updateBtnArrow($(hash).find('.collapseBtn>i.fa'),'fa-caret-down');
        }

        $('.collapseBtn').click(function(){
            var id = $(this).attr('href');
            if ($(id).hasClass('in'))
                updateBtnArrow($(this).find('i.fa'),'fa-caret-right');
            else
                updateBtnArrow($(this).find('i.fa'),'fa-caret-down');
        });
    });    
    </script>

@endsection