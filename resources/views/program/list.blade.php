@extends('layouts.app')

@section('content')

    <h1 class="h1-responsive">@lang('messages.Programs')</h1>

    <div style="position:fixed; bottom:45px; right:24px;">
        <a href='/admin/program/store' class="btn-floating btn-large red" title='@lang('messages.Add')'>
            <i class="fa fa-plus"></i>
        </a>
    </div>

    <table class='table table-stripe2d table-hover'>
    <thead class='table-info'>
        <tr>
            <th>ID</th>
            <th>BU</th>
            <th>Программа</th>            
            <th>ДП</th>
            <th>Потоки</th>
            <th>Сотрудники</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($programs as $p)
        <tr>
            <td>{{ $p->id }}</td>
            <td>{{ $p->bu->name }}</td>
            <td>{{ $p->name }}</td>            
            <td>
                @if ($p->dp)
                <div class="chip">
                    <img src="{{ $p->dp->avatar }}" alt="{{ $p->dp->name }}"> {{ $p->dp->name }}
                </div>
                @else
                    не задан
                @endif            

            </td>
            <td><a href='/admin/program/flows/{{ $p->id }}' class="blue-grey-text"><i class="fa fa-sitemap"></i> &nbsp; {{ $p->flows->count() }}</a></td>
            <td><a href='/admin/program/users/{{ $p->id }}' class="blue-grey-text"><i class="fa fa-users"></i> &nbsp; {{ $p->users->count() }}</a></td>
            <td>
                <a href='/admin/program/store/{{ $p->id }}' class="teal-text"><i class="fa fa-pencil"></i></a>
                <a href='/admin/program/delete/{{ $p->id }}' class="link2delete red-text"><i class="fa fa-times"></i></a>
            </td>
        </tr>
    @endforeach
    </tbody>
    </table>

@endsection