@extends('layouts.main')
@section('content')

<section class="container">
        <h1>{{ $genre_info[0]['name'] }}</h1>
        <form method="post" action="{{ route('update_genre') }}">
            @csrf
            <input name="id" hidden type="text" value="{{ $genre_info['0']['id'] }}">
            <div class="form-group my-2"><label for="name">Название жанра:</label><input class="form-control" type="text" name="name" id="name"></div>
            <div class="form-group my-2"><label for="description">Описание:</label><textarea class="form-control" name="description" id="description"></textarea></div>
            <button class="btn btn-success" type="submit">Обновить</button>
        </form>
    </section>
@endsection