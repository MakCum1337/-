@extends('layouts.main')
@section('content')
<section class="container">
    <h1>При удалении жанра "{{ $current_genre[0]['name'] }}", будут удалены следующие книги:</h1>
    <div class="my-2">
        <div>
            <h2>Электронные книги:</h2>
            <div>
                @foreach($books as $book)
                    <div class="card p-2 my-2">
                
                        <h1>{{ $book['title'] }}</h1>
                        <p>{{ $book['description'] }}</p>
                        <p>{{ $book['author'] }}</p>
                    </div>
                @endforeach

            </div>
        </div>
        <div>
            <h2>Физические книги:</h2>
            <div>
                @foreach($physical_books as $physical_book)
                    <div class="card p-2 my-2">
                
                        <h1>{{ $physical_book['title'] }}</h1>
                        <p>{{ $physical_book['description'] }}</p>
                        <p>{{ $book['author'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="my-2">
        <a class="btn btn-danger" href="{{ route('home') }}">Отмена</a>
        <a class="btn btn-dark" href="{{ route('deleting_genre', $current_genre[0]['id']) }}">Удалить</a>
    </div>
</section>

@endsection