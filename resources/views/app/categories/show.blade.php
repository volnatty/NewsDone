@extends('layouts.app')

@section('content')

    <h1>
        <a href="{{ route('app.categories.index') }}">
            Категория:
        </a>
        {{ $category->title }}

    </h1>
    @foreach ($category->news as $news)
            <div class="row">
                <h2>
                    <div class="ml-3">
                    <a href="{{ route('app.news.show', ['news' => $news->getKey()]) }}">
                         {{ $news->title }}
                    </a>
                        <h5><p> by {{$news->user->name}}</p></h5>
                    </div>

                </h2>

            </div>
    @endforeach
    @auth
        <a href="{{ route('app.news.create') }}"
           class="btn btn-primary">
            Добавить новость
        </a>
    @endauth

@endsection
