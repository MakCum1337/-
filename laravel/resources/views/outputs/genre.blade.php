@extends('layouts.main')
@section('content')


<section class="container">
    <h1>Жанр: {{$genre[0]['name']}}</h1>
    <div>
        <div class="w-100 d-flex flex-column align-content-center flex-wrap">
                    @if(count($books) > 0)
                            <h1 class="text-center">Электронные копии книг</h1>
                            <div class="w-100 d-flex justify-content-center">
                                @foreach ($books as $book)
                                    <div class="card p-2 mx-2 bg-secondary">
                    
                                        <h1>{{ $book['title'] }}</h1>
                                        <p>{{ $book['description'] }}</p>
                                        <a class="btn btn-success" href="{{ route('select_book', $book['id']) }}">Перейти</a>
                                        @auth
                                            @if(Auth::user()->admin)
                                                <div>
                                                    <a class="text-light text-decoration-none" href="{{ route('edit_book', $book['id']) }}">Редактировать</a>
                                                    <a class="text-light text-decoration-none" href="{{ route('delete_book', $book['id'])}}">Удалить</a>
                                                </div>
                                            @endif
                                        @endauth
                                    </div>
                                @endforeach
            
                            </div>
                    @else
                    <h1>По этому жанру не найдено ни одной электронной книги</h1>
                    @endif
        </div>
        <div class="d-flex flex-column align-content-center flex-wrap my-2">
                <div class="w-100 d-flex flex-column align-content-center flex-wrap">
                    @if(count($physical_books) > 0)
                        <h1 class="text-center">Физические копии книг</h1>
                        <div class="w-100 d-flex justify-content-center">
                            @foreach ($physical_books as $phys_book)
                                <div class="card p-2 mx-2 bg-secondary">
                
                                    <h1>{{ $phys_book['title'] }}</h1>
                                    <p>{{ $phys_book['description'] }}</p>
                                    <p>Осталось: {{ $phys_book['count'] }}</p>
                                    <a class="btn btn-success" href="{{ route('select_phisical_book', $phys_book['id']) }}">Перейти</a>
                                    @auth
                                        @if(Auth::user()->admin)
                                            <div>
                                                <a class="text-decoration-none text-light" href="{{ route('edit_physical_book', $phys_book['id']) }}">Редактировать</a>
                                                <a class="text-decoration-none text-light" href="{{ route('delete_physical_book', $phys_book['id'])}}">Удалить</a>
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                            @endforeach

                        </div>
                    @else
                        <h1>По этому жанру не найдено ни одной физической    книги</h1>
                    @endif
                </div>

    </div>
</section>

@endsection