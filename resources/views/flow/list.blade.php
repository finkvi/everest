@extends('layouts.app')

@section('content')

    <h1 class="h1-responsive">@lang('messages.Flows')</h1>

    <div style="position:fixed; bottom:45px; right:24px;">
        <a href='/admin/flow/store' class="btn-floating btn-large red" title='@lang('messages.Add')'>
            <i class="fa fa-plus"></i>
        </a>
    </div>

    <table class='table table-stripe2d table-hover'>
    <thead class='table-info'>
        <tr>
            <th>ID</th>
            <th>BU</th>
            <th>Поток</th>
            <th>FLP</th>
            <th>Сотрудники</th>
            <th>Компетенции</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($flows as $flow)
        <tr>
            <td>{{ $flow->id }}</td>
            <td>{{ $flow->bu->name }}</td>
            <td>{{ $flow->name }}</td>

            <td>
                @if (isset($flow->flp->name))
                <div class="chip">
                    @if ($flow->flp->avatar)
                        <img src="{{ $flow->flp->avatar }}" alt="{{ $flow->flp->name }}">
                    @endif
                    {{ $flow->flp->name }}

                </div>
                @else
                    не задан
                @endif
            </td>
            <td><a href='/admin/flow/users/{{ $flow->id }}' class="blue-grey-text"><i class="fa fa-users"></i> &nbsp; {{ $flow->users->count() }}</a></td>
            <td><a href='/admin/flow/competences/{{ $flow->id }}' class="blue-grey-text"><i class="fa fa-certificate"></i> &nbsp; {{ $flow->competences->count() }}</a></td>
            <td>
                <a href='/admin/flow/store/{{ $flow->id }}' class="teal-text"><i class="fa fa-pencil"></i></a>
                <a href='/admin/flow/delete/{{ $flow->id }}' class="link2delete red-text"><i class="fa fa-times"></i></a>
            </td>
        </tr>
    @endforeach
    </tbody>
    </table>

@endsection