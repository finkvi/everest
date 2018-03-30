@extends('layouts.app')

@section('content')

    <h1 class="h1-responsive">@lang('messages.Profiles')</h1>

    <!--div style="position:fixed; bottom:45px; right:24px;">
        <a href='/admin/profile/store' class="btn-floating btn-large red" title='@lang('messages.Add')'>
            <i class="fa fa-plus"></i>
        </a>
    </div-->

    @foreach ($tbl as $f)

    <div id='flow{{ $f['id'] }}'>

        <div style='overflow:hidden;'>
            <h3 class='mt-4' style='display:inline-block;'>
                {{ $f['name'] }}
                <span class="tag info-color ml-1" style='font-size:18px;'>{{ count($f['competences']) }}</span>
                <a href='#collapse{{$f['id']}}' class="collapseBtn arrow-r" data-toggle="collapse" data-target="#collapse{{$f['id']}}" aria-controls="collapse{{$f['id']}}" style='margin-left:5px; display:inline-block; vertical-align:middle; outline:none;'>
                    {{-- <i class='arrow fa fa-caret-right'></i> --}}
                    <i class="fa fa-angle-down rotate-icon"></i>
                </a>
            </h3>
            <a href='/admin/profile/store/{{ $f['id'] }}' class='btn btn-cyan btn-sm ml-2'><i class='fa fa-plus left'></i> Добавить профиль к потоку</a>
        </div>
        @if (isset($f['profiles']))
            <table class='table competence-tbl tbl-flow{{ $f['id'] }}'>
            <thead class="table-info">
            <tr>
                <th>Компетенция/Профиль</th>
                @foreach ($f['profiles'] as $p)
                    <th style='text-align:center;'>
                    {{ $p['name'] }}
                    <a href='/admin/profile/store/{{ $f['id'] }}/{{ $p['id'] }}' class="teal-text"><i class="fa fa-pencil"></i></a>
                    <a href='/admin/profile/delete/{{ $p['id'] }}' class="link2delete red-text"><i class="fa fa-times"></i></a>
                    </th>
                @endforeach
            </tr>
            </thead>

            <tr class='grey lighten-4'>
                <th>Грейд</th>
                @foreach ($f['profiles'] as $p)
                    <th style='text-align:center;'><h5><span class="tag success-color">{{ $p['grade'] }}</span></h5></th>
                @endforeach
            </tr>

            <tbody class='collapse' id='collapse{{$f['id']}}'>
            @foreach ($f['competences'] as $carr)
            <tr class='competence-row'>                
                <th>{{ $carr[0]['competence'] }}</th>

                @foreach ($carr as $c)
                    <td style='text-align:center;'><h5><span class="tag info-color" @if ($c['description']) style='cursor:pointer' tabindex="0" data-toggle="popover" data-placement="top" data-trigger="focus" title='{{ $c['competence'] }}' data-content="{{ $c['description'] or 'нет описания' }}" @endif>{{ $c['level'] }}</span></h5></td>
                @endforeach
            </tr>
            @endforeach
            </tbody>
            </table>
        @endif

    </div>
    
    @endforeach

    <script type="text/javascript">
    $(function()
    {

        var hash = window.location.hash;
        //alert(hash);
        if (hash)
        {
            $(hash).find('.collapse').collapse('show');
            $(hash).find('.collapseBtn .rotate-icon').removeClass('fa-angle-down').addClass('fa-angle-up');
        }

    });    
    </script>


@endsection