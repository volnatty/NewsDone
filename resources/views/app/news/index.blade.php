@extends('layouts.app')

@section('content')
<class class="row">
    <h4>
        <a href="{{ route('app.categories.index') }}"
               class="ml-2 btn btn-success">
                Категории:
        </a>
    </h4>
    @foreach ($newslist as $news)
        <h4>
            <a href="{{ route('app.categories.show', $news->category->getKey()) }}" class="bg-light text-green px-2 py-1 mr-2 rounded">
                {{ $news->category->title }}
            </a>
        </h4>

    @endforeach
</class>
    <div class="row">
        @forelse($newslist as $news)

            <div class="jumbotron">
                <h2>
                    <a href="{{ route('app.news.show', ['news'=>$news]) }}">
                        {{ $news->title }}
                    </a>
                </h2>
                <p> by {{$news->user->name}}</p>
                @if ($news->description)
                    <p>{{ $news->description }}</p>
                @else
                    <p>{{ str_limit(strip_tags($news->body), 50) }}</p>
                @endif

                <p class="mb-0">{{ $news->created_at->diffForHumans() }} создана</p>
                <p class="mb-0">{{ $news->updated_at->diffForHumans() }} обновлена</p>

            </div>

        @empty
            <div class="col">
                <p>Новости пока не добавлены.</p>
                @auth
                    <a href="{{ route('app.news.create') }}"
                       class="btn btn-primary">
                        Добавить новость
                    </a>

                    <a href="{{ route('app.tags.create') }}"
                       class="ml-3 btn btn-secondary">
                        Добавить тег
                    </a>
                @endauth
            </div>
        @endforelse
    </div>

    @if ($news->tags->count())
        <h4><class class="row">Поиск по тэгам</class></h4>
    <p class="mt-5 mb-2">
        @foreach($news->tags as $tag)
            <a href="{{ route('app.news.index', ['tag' => $tag->getKey()]) }}" class="bg-dark text-white px-2 py-1 mr-2 rounded">
              {{ $tag->title }}
            </a>
        @endforeach
    </p>
    @endif
    @auth
        <a href="{{route('app.news.create')}}">
            <class class="btn btn-primary">
                Добавить еще новость?
            </class>
        </a>
    @endauth
@endsection
