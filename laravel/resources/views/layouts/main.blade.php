<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
        <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
        <span class="fs-4">SimpleBooks</span>
      </a>

      <ul class="nav nav-pills">
 
        <li class="nav-item"><a href="cart" class="nav-link">Корзина</a></li>
        <li class="nav-item"><a href="{{ route('see_my_books') }}" class="nav-link">Книги</a></li>
        <li class="nav-item"><a href="#about" class="nav-link">О нас</a></li>
      </ul>
                @auth
                    @if(Auth::user()->admin == true)
                        <li><a class="btn btn-success mx-2" href="{{ route('add_genre') }}">Добавить жанр</a></li>
                        <li><a class="btn btn-success mx-2" href="{{ route('add_book') }}">Добавить книгу</a></li>
                    @endif
                @endauth
            </ul>
            @auth
                <a class="mx-2 ml-auto" href="profile">{{ Auth::user()->name }}</a>
            @endauth
            @guest
                <a class="mx-2 ml-auto" href="{{ route('sign_in') }}">Авторизация</a>
            @endguest
        </nav>
    </header>
</div>
    @yield('content')
    <footer class="py-3 my-4"> 
        <ul class="nav justify-content-center border-bottom pb-3 mb-3"> 
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Home</a></li> 
            <li class="nav-item"><a href="cart" class="nav-link">Корзина</a></li>
            <li class="nav-item"><a href="{{ route('see_my_books') }}" class="nav-link">Книги</a></li>
            <li class="nav-item"><a href="#about" class="nav-link">О нас</a></li>
        </ul> <p class="text-center text-body-secondary">© 2025 Company, Inc</p> 
    </footer>
</body>
</html>