@extends('layouts.main')
@section('content')

    <section class="card my-2 container">
        <div>
            <h1>{{ Auth::user()->name }}</h1>
            <p>{{ Auth::user()->email }}</p>

        </div>
        <div>
            <h2>{{ Auth::user()->wallet }} р.</h2>
            <p>Кошелек</p>
            <button class="btn btn-warning my-2">Пополнить</button>
        </div>
    </section>

@endsection