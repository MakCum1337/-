@extends('layouts.main')
@section('content')

    <section>
        <div>
            <button>

                <a href="{{ route('sign_in') }}">Вход</a>
            </button>
            <button disabled>
                <a href="" >Регистрация</a>

            </button>
        </div>
        @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <form action="{{ route('register') }}" method="post">
            @csrf
            <div>
                <label for="name">Имя:</label>
                <input type="text" id="name" name="name">
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email">
            </div>
            <div>
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password">
            </div>
            <div>
                <label for="password_confirmation">Повтор пароля:</label>
                <input type="password" id='password_confirmation' name="password_confirmation">
            </div>
            <button type="submit">Регистрация</button>
        </form>
    </section>

@endsection