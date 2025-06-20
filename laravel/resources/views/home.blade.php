@extends('layouts.main')
@section('content')

    <section class="container">
        <nav class="d-flex justify-content-center">
            <ul class="nav">
                @foreach ($genres as $genre)
                    <li class="card mx-2">
                            <a class="btn btn-danger" href="{{ route('select_genre', $genre['id']) }}">{{ $genre['name'] }}</a>
                            @auth
                                @if(Auth::user()->admin == true)
                                    <a class="text-decoration-none" href="{{ route('edit_genre', $genre['id']) }}">Редактировать</a>
                                    <a class="text-decoration-none" href="{{ route('delete_genre', $genre['id']) }}">Удалить</a>
                                @endif
                            @endauth
                    </li>
                @endforeach
            </ul>
        </nav>
        <div class="d-flex flex-column align-content-center flex-wrap my-2">
            <div class="w-100 d-flex flex-column align-content-center flex-wrap">
                <h1 class="text-center">Популярные книги</h1>
                <div class="w-100 d-flex justify-content-center">
                    @foreach ($physical_books as $phys_book)
                        <div class="card p-2 mx-2 ">
        
                            <h1>{{ $phys_book['title'] }}</h1>
                            <p>{{ $phys_book['description'] }}</p>
                            <p>Осталось: {{ $phys_book['count'] }}</p>
                            <a class="btn btn-success" href="{{ route('select_physical_book', $phys_book['id']) }}">Перейти</a>
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
            </div>
            
            </div>
        </div>
    </section>
    <section id = 'about'>
        <h1 class="text-align center">О нас</h1>
        <p class="text-align center text-indent: 25px ">SimpleBooks — ваш гид в мире литературы!
            SimpleBooks — это небольшой, но уютный сайт, где вы можете: <br>
            - прочитать книги; <br>
            - арендовать литературу; <br>
            - оставить отзывы и комментарии. <br>
            Мы создали SimpleBooks, чтобы помочь вам найти интересные книги и поделиться впечатлениями с другими читателями. Присоединяйтесь к нам и откройте для себя новые горизонты литературы!</p>
    </section>

@endsection