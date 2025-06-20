<?php

namespace App\Http\Controllers;

use App\Models\having_books;
use App\Models\having_physical_books;
use Auth;
use Illuminate\Http\Request;
use App\Models\genre;
use App\Models\books;
use App\Models\physical_books;
use App\Models\Cart;
use App\Models\Review;
use SplFileInfo;
use Storage;

class bookController extends Controller
{
    public function home(){
        $genres = genre::all();

        $books = books::all()->toArray();
        $physical_books = physical_books::all()->toArray();

        return view('home', [
            'genres' => $genres,
            'books' => $books,
            'physical_books' => $physical_books
        ]);
    }

// buying

    public function see_cart(){
        $user_books = cart::where('user_id', Auth::user()->id)->get();
        $wallet = Auth::user()->wallet;
        $books = [];
        $physical_books = [];
        $total_price = 0;
        foreach($user_books as $user_book){
            if($user_book['book_id']){
                $current_book = books::where('id', $user_book['book_id'])->get();
                // dd($current_book);
                array_push($books, $current_book);
            }else{
                $current_book = physical_books::where('id', $user_book['physical_book_id'])->get();
                array_push($physical_books, $current_book);
            }
            
            $total_price += $current_book[0]['price'];
        };
        return view('profile_settings.cart', compact('books', 'physical_books', 'total_price', 'wallet'));
    }
    public function add_to_cart_physical($book){
        cart::create([
            'user_id' => Auth::user()->id,
            'physical_book_id' => $book
        ]);
        return back();
    }
    public function add_to_cart($book){
        cart::create([
            'user_id' => Auth::user()->id,
            'book_id' => $book
        ]);
        return back();
    }

    public function buy_books(){
        $user_books = cart::where('user_id', Auth::user()->id)->get();
        $books = [];
        $physical_books = [];
        $total_price = 0;
        foreach($user_books as $user_book){
            if($user_book['book_id']){
                $current_book = books::where('id', $user_book['book_id'])->get();
                array_push($books, $current_book[0]);
            }else{
                $current_book = physical_books::where('id', $user_book['physical_book_id'])->get();
                array_push($physical_books, $current_book[0]);
            }
            $total_price += $current_book[0]['price'];
        };
        if(Auth::user()->wallet > $total_price){

            Auth::user()->update([
                'wallet' => Auth::user()->wallet-$total_price
            ]);
            foreach($books as $book){
                having_books::create([
                    'user_id' => Auth::user()->id,
                    'books_id' => $book['id']
                ]);
                Cart::where('book_id', $book['id'])
                    ->where('user_id', Auth::id())
                    ->delete();
            }
            foreach($physical_books as $physical_book){
                
                having_physical_books::create([
                    'user_id' => Auth::user()->id,
                    'physical_books_id' => $physical_book['id']
                ]);
                Cart::where('physical_book_id', $physical_book['id'])
                    ->where('user_id', Auth::id())
                    ->delete();
            }
            Auth::user()->decrement('wallet', $total_price);
        }else {
        
            return back()->withErrors([
                'purchasing' => 'Не хватает средств'.Auth::user()->wallet.' '.$total_price
            ]);
        }
        return redirect()->route('home');
        // dd(Cart::find($physical_book['id'], 'physical_book_id')->delete());
    }   



    // genres
    public function adding_genre(Request $request){
        $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);
        genre::create($request->all());
        return redirect()->route('home');
    }
    public function edit_genre($genre_id){
        $genre_info = genre::find($genre_id, 'id')->get();
        return view('admin.edit.genre', compact('genre_info'));
    }
    public function update_genre(Request $request){
        $request->validate([
            'id' => 'required',
           'name' => 'required',
           'description' => 'required' 
        ]);
        
        genre::find($request['id'], 'id')->update([
            'name' => $request['name'],
            'description' => $request['description']
        ]);
        return redirect()->route('home');
    }
    public function delete_genre($genre){
        $books = books::where('genre_id', $genre)->get();
        $physical_books = physical_books::where('genre_id', $genre)->get();
        $current_genre = genre::where('id', $genre)->get();
        return view('admin.special.deleting_genre_message', compact('books', 'physical_books', 'current_genre'));
    }
    public function deleting_genre($genre){
        $books = books::where('genre_id', $genre)->get();
        $physical_books = physical_books::where('genre_id', $genre)->get();

        foreach($books as $book){
            books::find($book['id'], 'genre_id')->delete();
        }
        foreach($physical_books as $physical_book){
            physical_books::find($physical_book['id'], 'genre_id')->delete();
        }
        genre::find($genre, 'id')->delete();
        return redirect()->route('home');
    }


    // books
    public function adding_book(Request $request){
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'author' => 'required',
            'genre_id' => 'required',
            'price' => 'required',
            'price_for_rent' => 'required'
        ]);

        if($request->count != null){
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'author' => 'required',
                'genre_id' => 'required',
                'count' => 'required',
                'price' => 'required',
                'price_for_rent' => 'required'
            ]);
            physical_books::create($request->all());
        }
        if($request->file != null){
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'author' => 'required',
                'genre_id' => 'required',
                'file' => 'mimes:pdf, fb2',
                'price' => 'required',
                'price_for_rent' => 'required'
            ]);
            $file = $request->file('file');
            $extention = $file->getClientOriginalExtension();
            switch ($extention){
                case 'pdf':
                    $path = $request->file('file')->storeAs('books/pdf',($request->title . '.pdf'), 'public');
                    $request->file = $request->title.'.pdf';
                    break;
                case 'fb2':
                    $path = $request->file('file')->storeAs('books/fb2', ($request->title . '.fb2'), 'public');
                    break;

            }
            books::create($request->all());
        }
        return redirect()->route('home');
    }
    public function edit_book($book_id){
        $book_info = books::where('id', $book_id)->get();
        $genres = genre::all();
        return view('admin.edit.book', compact('book_info', 'genres'));
    }
    public function edit_physical_book($book_id){
        $book_info = physical_books::where('id', $book_id)->get();
        $genres = genre::all();
        return view('admin.edit.physical_book', compact('book_info', 'genres'));
    }
    public function update_book(Request $request){
        $request->validate([
            'id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'author' => 'required',
            'genre_id' => 'required',
            'price' => 'required',
            'price_for_rent' => 'required'
        ]);
        $current_book = books::find($request['id'], 'id');
        if($request->file != null){

            $request->validate([
                'id' => 'required',
                'title' => 'required',
                'description' => 'required',
                'author' => 'required',
                'genre_id' => 'required',
                'file' => 'mimes:pdf, fb2',
                'price' => 'required',
                'price_for_rent' => 'required'
            ]);
            $file = $request->file('file');
            $extention = $file->getClientOriginalExtension();
            switch ($extention){
                case 'pdf':
                    $path = $request->file('file')->storeAs('books/pdf',($request->title . '.pdf'), 'public');
                    break;
                case 'fb2':
                    $path = $request->file('file')->storeAs('books/fb2', ($request->title . '.fb2'), 'public');
                    break;

            }
            books::update($request->all());
        }
        return redirect()->route('home');
    }
    public function update_phisical_book(Request $request){
        $request->validate([
            'id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'author' => 'required',
            'genre_id' => 'required',
            'price' => 'required',
            'price_for_rent' => 'required'
        ]);
        $current_book = physical_books::find($request['id'], 'id');
        if($request->count != null){
            $request->validate([
                'id' => 'required',
                'title' => 'required',
                'description' => 'required',
                'author' => 'required',
                'genre_id' => 'required',
                'count' => 'required',
                'price' => 'required',
                'price_for_rent' => 'required'
            ]);
            $current_book::update($request->all());
        }
        return redirect()->route('home');
    }

    public function delete_physical_book($physical_book){
        physical_books::find($physical_book, 'id')->delete();
        return redirect()->route('home');
    }
    public function delete_book($book){
        books::find($book,'id')->delete();
        return redirect()->route('home');
    }
    public function send_review(Request $request){
        $request->validate([
            'user_id' => 'required',
            'book_id' => 'required',
           'rating' => 'required',
           'review' => 'required' 
        ]);
        Review::create($request->all());
        return back();
    }

    // output
    public function select_genre($genre_id){
        $books = books::where('genre_id', $genre_id)->get();
        $physical_books = physical_books::where('genre_id', $genre_id)->get();
        $genre = genre::where('id', $genre_id)->get();

        return view('outputs.genre', compact('books', 'physical_books', 'genre'));
    }
    public function select_physical_book($physical_book){
        $reviews = review::where('book_id', $physical_book)->get();
        $book = physical_books::where('id', $physical_book)->get();
        $genre = genre::where('id', $book[0]['genre_id'])->get();
        $hidden_books = Cart::where('user_id', Auth::user()->id)->where('physical_book_id', $physical_book)->get();
        $in_cart = $hidden_books->isNotEmpty();
        $my_physical_books = having_physical_books::where('user_id', Auth::user()->id)->where('physical_books_id', $physical_book)->get();
        $mine_physical_books = $my_physical_books->isNotEmpty();
        return view('outputs.book', compact('book', 'genre', 'in_cart', 'reviews', 'mine_physical_books'));
    }
    public function select_book($book){
        $reviews = review::where('book_id', $book)->get();
        $book = books::where('id', $book)->get();
        $genre = genre::where('id', $book[0]['genre_id'])->get();
        $hidden_books = Cart::where('user_id', Auth::user()->id)->where('book_id', $book[0]['id'])->get();
        $in_cart = $hidden_books->isNotEmpty();
        $my_books = having_books::where('user_id', Auth::user()->id)->where('books_id', $book[0]['id'])->get();
        $mine_books = $my_books->isNotEmpty();
        return view('outputs.book', compact('book', 'genre', 'in_cart', 'reviews', 'mine_books'));
    }   
    public function see_my_books(){
        $having_books = having_books::where('user_id', Auth::user()->id)->get();
        $having_physical_books = having_physical_books::where('user_id', Auth::user()->id)->get();
        $books = [];
        $physical_books = [];
        foreach($having_books as $having_book){
            array_push($books, books::where('id', $having_book->books_id)->get());
        }
        foreach($having_physical_books as $having_physical_book){
            array_push($physical_books, physical_books::where('id', $having_physical_book->physical_books_id)->get());
        }
        // dd(having_physical_books::where('user_id', Auth::user()->id)->get());
        return view('profile_settings.having_books', compact('books', 'physical_books'));
    }
    public function read_book($book_id){
        $current_book = books::where('id', $book_id)->get();
        $path = Storage::disk('public')->get('books/pdf/'.$current_book[0]['title'].'.pdf'); // Путь к файлу
        // dd($path);
        return Storage::disk('public')->get('books/pdf');
        // dd( $path->exists('books/pdf/'.$current_book[0]['title'].'.pdf'), $path);
        // if ($path->exists('books/pdf/'.$current_book[0]['title'].'.pdf')) {
        // } else {
        //     abort(404, 'PDF not found');
        // }
    }
}
