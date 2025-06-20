<?php
$physical = false;
?>
@extends('layouts.main')
@section('content')
    <section class="container">
        <form method="post" enctype="multipart/form-data" action="{{ route('adding_book') }}">
            @csrf
            <div class="form-group my-2">
                <label for="title">Название книги:</label>
                <input type="text" name="title" id="title" class="form-control">
            </div>
            <div class="form-group my-2">
                <label for="description">Описание:</label>
                <textarea name="description" id="description" class="form-control"></textarea>
            </div>
            <div class="form-group my-2">
                <label for="author">Автор:</label>
                <input type="text" id='author' name="author" class="form-control">
            </div>
            <div class="form-group my-2">
                <label for="genre_id">Жанр:</label>
                <select name="genre_id" id="genre_id" class="form-control">
                    @foreach ($genres as $genre)
                        <option class="form-control" value="{{ $genre['id'] }}">{{ $genre['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group my-2">
                <label for="count">Количество книг:</label>
                <input type="number" id="count" name="count" class="form-control">
                <label>Если имеются физические копии</label>
            </div>
            <div class="form-group my-2">
                <label for="file">Файл книги:</label>
                <input type="file" id='file' name="file" class="form-control">
                <label>Если имеется электронная копия</label>
            </div>
            <div class="form-group my-2">
                <label for="price">Цена за шт:</label>
                <input type="number" id='price' name="price" step="any" class="form-control">
            </div>
            <div class="form-group my-2">
                <label for="price_for_rent">цена за аренду:</label>
                <input type="number" id='price_for_rent' name="price_for_rent" step="any" class="form-control">
            </div>
            <button class="btn btn-success my-2" type="submit">Добавить</button>
        </form>
        @error('file')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </section>
@endsection