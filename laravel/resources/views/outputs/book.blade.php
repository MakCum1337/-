@extends('layouts.main')
@section('content')

<section class="container card my-2">
    <h1>{{ $book[0]['title'] }}</h1>
    <p>{{ $genre[0]['name'] }}</p>
    <div>
        <p>{{ $book[0]['price'] }}р. | </p>
        <p>{{ $book[0]['price_for_rent'] }}р./день</p>
        @if(isset($book[0]->count))
            <p>Осталось: {{ $book[0]['count'] }}</p>
            @if($mine_physical_books)
                <a href="">Читать</a>
            @elseif(!$in_cart)
                <a class="btn btn-primary" href="{{ route('add_to_cart_physical', $book[0]) }}">В корзину</a>
            @else
                <p>Уже в корзине</p>
            @endif
        @else
            @if($mine_books)
                <a href="{{ route('read_book', [$book[0]['id'], $book[0]['file']]) }}">Читать</a>
            @elseif(!$in_cart)
                <a class="btn btn-primary" href="{{ route('add_to_cart', $book[0]) }}">В корзину</a>
            @else
                <p>Уже в корзине</p>
            @endif
            
        @endif
    </div>
    <p>
        {{ $book[0]['description'] }}
    </p>
</section>
<section class="container">
    <h2>Коментарии:</h2>
    <div class="my-2">
        <form method='post'action="{{ route('send_review') }}" class="card">
            @csrf
            <input type="text" hidden value="{{ Auth::user()->id }}" name="user_id">
            <input type="text" name="physical_book" value="{{ $book[0]['count'] }}" hidden>
            <input type="text" name="book_id" value="{{$book[0]['id']}}" hidden>
            <div class="form-group my-2 mx-auto">
                <label for="">Оценка:</label>
                <input class="form-control" type="number" max="5" min="0" name="rating">
            </div>
            <div class="form-group my-2 mx-2">
                <label for="">Комментарий:</label>
                <textarea class="form-control" name="review" id=""></textarea>
            </div>
            <button class="btn btn-info my-2 mx-auto" type="submit">Отправить</button>
        </form>
    </div>
    <div class="card">
        @foreach($reviews as $review)
            <div class="card my-2 mx-2">
                <p>{{ $review['rating'] }}/5</p>
                <p>{{ $review['review'] }}</p>
            </div>
        @endforeach
    </div>
</section>

@endsection
