@extends('layouts.main')
@section('content')
<section>
    <div class="d-flex flex-column align-content-center flex-wrap my-2">
            <div class="w-100 d-flex flex-column align-content-center flex-wrap">
                <h1 class="text-center">Физические копии книг</h1>
                <div class="w-100 d-flex justify-content-center">
                    @foreach ($physical_books as $phys_book)
                        <div class="card p-2 mx-2 bg-secondary">
                            <h1>{{ $phys_book[0]['title'] }}</h1>
                            <p>{{ $phys_book[0]['description'] }}</p>
                            <p>Осталось: {{ $phys_book[0]['count'] }}</p>
                            <a class="btn btn-success" href="{{ route('select_physical_book', $phys_book[0]['id']) }}">Перейти</a>
                            @auth
                                @if(Auth::user()->admin)
                                    <div>
                                        <a class="text-decoration-none text-light" href="{{ route('edit_physical_book', $phys_book[0]['id']) }}">Редактировать</a>
                                        <a class="text-decoration-none text-light" href="{{ route('delete_physical_book', $phys_book[0]['id'])}}">Удалить</a>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    @endforeach

                </div>
            </div>
            <div class="w-100 d-flex flex-column align-content-center flex-wrap">
                <h1 class="text-center">Электронные копии книг</h1>
                <div class="w-100 d-flex justify-content-center">
                    @foreach ($books as $book)
                        <div class="card p-2 mx-2 bg-secondary">
        
                            <h1>{{ $book[0]['title'] }}</h1>
                            <p>{{ $book[0]['description'] }}</p>
                            <a class="btn btn-success" href="{{ route('select_book', $book[0]['id']) }}">Перейти</a>
                            @auth
                                @if(Auth::user()->admin)
                                    <div>
                                        <a class="text-light text-decoration-none" href="{{ route('edit_book', $book[0]['id']) }}">Редактировать</a>
                                        <a class="text-light text-decoration-none" href="{{ route('delete_book', $book[0]   ['id'])}}">Удалить</a>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
</section>

@endsection