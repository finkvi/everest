@extends('layouts.app')

@section('content')

    <h1 class="h1-responsive">@lang('messages.Projects')</h1>

    <div style="position:fixed; bottom:45px; right:24px;">
        <a href='/admin/project/store' class="btn-floating btn-large red" title='@lang('messages.Add')'>
            <i class="fa fa-plus"></i>
        </a>
    </div>

    <table class='table table-stripe2d table-hover'>
    <thead class='table-info'>
        <tr>
            <th>ID</th>
            <th>Программа</th>
            <th>Проект</th>
            <th>Потоки</th>
            <th>Сотрудники</th>
            <th>РП</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($projects as $p)
        <tr>
            <td>{{ $p->id }}</td>
            <td>{{ $p->program->name or 'не задан'}}</td>
            <td>{{ $p->name }}</td>
            <td><a href='/admin/project/flows/{{ $p->id }}' class="blue-grey-text"><i class="fa fa-sitemap"></i> &nbsp; {{ $p->flows->count() }}</a></td>
            <td><a href='/admin/project/users/{{ $p->id }}' class="blue-grey-text"><i class="fa fa-users"></i> &nbsp; {{ $p->users->count() }}</a></td>
            <td>
                @if ($p->rp)
                <div class="chip">
                    @if ($p->rp->avatar)
                        <img src="{{ $p->rp->avatar }}" alt="{{ $p->rp->name }}"> 
                    @endif
                    {{ $p->rp->name }}
                </div>
                @else
                    не задан
                @endif            

            </td>
            <td>
                <a href='/admin/project/store/{{ $p->id }}' class="teal-text"><i class="fa fa-pencil"></i></a>
                <a href='/admin/project/delete/{{ $p->id }}' class="link2delete red-text"><i class="fa fa-times"></i></a>
            </td>
        </tr>
    @endforeach
    </tbody>
    </table>

@endsection