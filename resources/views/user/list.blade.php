@extends('layouts.app')

@section('content')

    <div style='overflow:hidden;'>
        <h1 class="h1-responsive" style='float:left;'>@lang('messages.People')</h1>

        <form action="/{{ Request::path() }}" class="form-inline" style='float:right;'>
            <div class="md-form input-group">
                <span class="input-group-addon" id="basic-addon1"><i class='fa fa-search'></i></span>
                <input type="text" name="keyword" class="form-control" placeholder="Поиск" aria-describedby="basic-addon1" value="{{ isset(Request::all()['keyword']) ? Request::all()['keyword'] : '' }}" style='padding-left:5px;'>
            </div>

            <div class="md-form form-group">
                <a href="" class="btn btn-cyan">Искать</a>
            </div>

        </form>

    </div>

    <div style="position:fixed; bottom:45px; right:24px;">
        <a href='/admin/user/store' class="btn-floating btn-large red" title='@lang('messages.Add')'>
            <i class="fa fa-plus"></i>
        </a>
    </div>

    <table class='table table-hover user-tbl'> <!-- table-sm -->
    <thead class='table-info'>
        <tr>
            <th>
                <a href='?sort=id&order={{ $sort=='id' ? $order : 'asc' }}' class='ml-0'>ID</a>
                @if ($sort=='id')
                    <i class="fa {{ $order=='desc' ? 'fa-sort-numeric-asc' : 'fa-sort-numeric-desc' }}"></i>
                @endif                
            </th>
            <th>Аватар</th>
            <th>
                <a href='?sort=name&order={{ $sort=='name' ? $order : 'asc' }}' class='ml-0'>Имя</a>
                @if ($sort=='name')
                    <i class="fa {{ $order=='desc' ? 'fa-sort-alpha-asc' : 'fa-sort-alpha-desc' }}"></i>
                @endif                
            </th>
            <th>Текущий профиль</th>
            <th>Ответственный</th>
            <th>Поток</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($users as $u)
        <tr>
            <td>{{ $u->id }}</td>
            <td>
                @if ($u->avatar)
                    <img src="{{ $u->avatar }}" alt="{{ $u->name }}" class='rounded-circle avatar'>
                @else
                    &nbsp;
                @endif
            </td>
            <td>
                {{-- <a href='/admin/user/store/{{ $u->id }}' class="black-text ml-0">{{ $u->name }}</a> --}}
                <a href='/myemployees/{{ $u->id }}' class="black-text ml-0">{{ $u->name }}</a>
                @if ($u->admin)
                    <i class="fa fa-star red-text" style='margin-left:5px; cursor:pointer;' data-toggle="tooltip" data-placement="right" title='Суперпользователь'></i>
                @endif
            </td>
            <td>{!! $u->currentProfile->name or "<span style='color:#999;'>не задан</span>" !!}</td>
            <td>{!! $u->mentor->name or "<span style='color:#999;'>не задан</span>" !!}</td>
            <td>{!! $u->flow->name or "<span style='color:#999;'>не задан</span>" !!}</td>
            <td>
                <a href='/admin/user/store/{{ $u->id }}' class="teal-text"><i class="fa fa-pencil"></i></a>
                <a href='/admin/user/delete/{{ $u->id }}' class="link2delete red-text"><i class="fa fa-times"></i></a>
            </td>
        </tr>
    @endforeach
    </tbody>
    </table>

    {!! $users->links() !!}

    <script type="text/javascript">
        
        // Tooltips Initialization
        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        })

    </script>

@endsection