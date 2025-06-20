@extends('layouts.main')
@section('content')

<section class="container">
        <h1>{{ $book_info[0]['title'] }}</h1>
        <form method="post" enctype="multipart/form-data" action="{{ route('update_book') }}">
            @csrf
            <input hidden name="id" type="text" value="{{ $book_info[0]['id'] }}">
            <div class="form-group my-2">
                <label for="title">Название книги:</label>
                <input class="form-control" type="text" name="title" id="title" value="{{ $book_info[0]['title'] }}">
            </div>
            <div class="form-group my-2">
                <label for="description">Описание:</label>
                <textarea class="form-control" name="description" id="description">{{ $book_info[0]['description'] }}</textarea>
            </div>
            <div class="form-group my-2">
                <label for="author">Автор:</label>
                <input class="form-control" type="text" id='author' name="author"value="{{ $book_info[0]['author'] }}">
            </div>
            <div class="form-group my-2">
                <label for="genre_id">Жанр:</label>
                <select class="form-control" name="genre_id" id="genre_id"value="{{ $book_info[0]['genre_id'] }}">
                    @foreach ($genres as $genre)
                        <option value="{{ $genre['id'] }}">{{ $genre['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group my-2">
                <label for="count">Количество книг:</label>
                <input class="form-control" type="number" id="count" name="count"value="{{ $book_info[0]['count'] }}">
            </div>
            <div class="form-group my-2">
                <label for="price">Цена за шт:</label>
                <input class="form-control" type="number" id='price' name="price"value="{{ $book_info[0]['price'] }}" step="any">
            </div>
            <div class="form-group my-2">
                <label for="price_for_rent">цена за аренду:</label>
                <input class="form-control" type="number" id='price_for_rent' name="price_for_rent"value="{{ $book_info[0]['price_for_rent'] }}" step="any">
            </div>
            <button class="btn btn-success" type="submit">Добавить</button>
        </form>
        @error('file')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </section>

@endsection