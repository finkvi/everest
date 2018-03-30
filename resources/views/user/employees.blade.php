@extends('layouts.app')

@section('content')

    <h1 class="h1-responsive">@lang('messages.MyEmployees')</h1>

    @if (count($apprantices)==0)
        У вас нет подопечных :)
    @else

        <h4>Я ответственный за развитие сотрудников</h4>
        
    	<table class='table table-hover user-tbl'>
        <thead class='table-info'>
            <tr>
                <th>ID</th>
                <th>Аватар</th>
                <th>Имя</th>
                <th>Текущий профиль</th>
                <th>Целевой профиль</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>

    	@foreach ($apprantices as $u)
    	<tr>
    		<td>{{ $u->id }}</td>
    		<td>
            @if ($u->avatar)
                <a href='/myemployees/{{ $u->id }}' class="black-text ml-0"><img src="{{ $u->avatar }}" alt="{{ $u->name }}" class='rounded-circle avatar'></a>
            @else
                &nbsp;
            @endif
            </td>
    		<td>
    			<a href='/myemployees/{{ $u->id }}' class="black-text ml-0">{{ $u->name }}</a>
    		</td>
    		<td>{!! $u->currentProfile->name or "<span style='color:#888'>не задан</span>" !!}</td>
    		<td>{!! $u->targetProfile->name or "<span style='color:#888'>не задан</span>" !!}</td>
            <td><a href='/admin/user/store/{{ $u->id }}' class="teal-text"><i class="fa fa-pencil"></i></a></td>
    	</tr>
    	@endforeach
    	</table>

    @endif

@endsection