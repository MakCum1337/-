@extends('layouts.main')
@section('content')
    <section class="container">
        <form method="post" action="{{ route('adding_genre') }}">
            @csrf
            <div class="form-group my-2"><label for="name">Название жанра:</label><input class="form-control" class="form-" type="text" name="name" id="name"></div>
            <div class="form-group my-2"><label for="description">Описание:</label><textarea class="form-control" name="description" id="description"></textarea></div>
            <button class="btn btn-success" type="submit">Добавить</button>
        </form>
    </section>
@endsection