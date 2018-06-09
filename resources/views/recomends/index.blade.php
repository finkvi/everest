@extends('layouts.app')

@section('content')

    <h1 class="h1-responsive">@lang('messages.Recomends')</h1>

    <div style="position:fixed; bottom:45px; right:24px;">
        <a href='/recomend/store' class="btn-floating btn-large red" title='@lang('messages.Add')'>
            <i class="fa fa-plus"></i>
        </a>
    </div>

    <table class='table table-stripe2d table-hover'>
    <thead class='table-info'>
        <tr>
            <th>Пользователь</th>
            <th>Фамилия</th>
            <th>Имя</th>            
            <th>Телефон</th>
            <th>Email</th>
            <th>Работодатель</th>
            <th>Доп. инфо</th>
            <th>Комментарии</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($recomends as $r)
        <tr>
            <td>
                @if (isset($r->user->name))
                <div class="chip">
                    <img src="{{ $r->user->avatar }}" alt="{{ $r->user->name }}"> {{ $r->user->name }}
                </div>
                @else
                    не задан
                @endif            
            </td>
            <td>{{ $r->last_name }}</td>
            <td>{{ $r->first_name }}</td>      
            <td>{{ $r->phone }}</td>
            <td>{{ $r->email }}</td>
            <td>{{ $r->account }}</td>
            <td>{{ $r->notes }}</td>
            <td>{{ $r->comments }}</td>
            <td>
                <a href='/recomend/store/{{ $r->id }}' class="teal-text"><i class="fa fa-pencil"></i></a>
                <a href='/recomend/delete/{{ $r->id }}' class="link2delete red-text"><i class="fa fa-times"></i></a>
            </td>
        </tr>
    @endforeach
    </tbody>
    </table>

@endsection