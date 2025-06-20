@extends('layouts.main')
@section('content')

    <section>
        <div>
            <button disabled>
                <a href="" >Вход</a>

            </button>
            <button>
                <a href="{{ route('registration') }}">Регистрация</a>

            </button>
        </div>
        <form method='post' action="{{ route("signing") }}">
            @csrf
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email">
            </div>
            <div>
                <label for="password">Пароль:</label>
                <input type="paswword" id="password" name="password">
            </div>
            <button type="submit">Вход</button>
        </form>
    </section>

@endsection