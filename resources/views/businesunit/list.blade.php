@extends('layouts.app')

@section('content')

    <h1 class="h1-responsive">@lang('messages.BusinessUnits')</h1>

    <div style="position:fixed; bottom:45px; right:24px;">
        <a href='/admin/bu/store' class="btn-floating btn-large red" title='@lang('messages.Add')'>
            <i class="fa fa-plus"></i>
        </a>
    </div>

    <table class='table table-stripe2d table-hover'>
    <thead class='table-info'>
        <tr>
            <th>ID</th>
            <th>Бизнес юнит</th>
            <th>Руководитель</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($BUs as $bu)
        <tr>
            <td>{{ $bu->id }}</td>
            <td>{{ $bu->name }}</td>
            <td>
                @if (isset($bu->head->name))
                <div class="chip">
                    <img src="{{ $bu->head->avatar }}" alt="{{ $bu->head->name }}"> {{ $bu->head->name }}
                </div>
                @else
                    не задан
                @endif            
            </td>
            <td>
                <a href='/admin/bu/store/{{ $bu->id }}' class="teal-text"><i class="fa fa-pencil"></i></a>
                <a href='/admin/bu/delete/{{ $bu->id }}' class="link2delete red-text"><i class="fa fa-times"></i></a>
            </td>
        </tr>
    @endforeach
    </tbody>
    </table>

@endsection