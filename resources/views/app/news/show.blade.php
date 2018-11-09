@extends('layouts.app')

@section('content')

     <div class="d-flex align-items-center">
        <h1>{{ $news->title }}</h1>
        <div class="ml-3">
            <a href="{{ route('app.categories.show', $news->category->getKey()) }}">
                {{ $news->category->title }}
            </a>
        </div>
    </div>

    @if ($news->description)
        <p class="lead">{{ $news->description }}</p>
    @endif

    {!! $news->body !!}

    @if ($news->tags->count())
        <p class="mt-5 mb-0">
            @foreach($news->tags as $tag)
                <a href="{{ route('app.news.index', ['tag' => $tag->getKey()]) }}" class="bg-dark text-white px-2 py-1 mr-2 rounded">
                    {{ $tag->title }}
                </a>
            @endforeach
        </p>
    @endif
     @auth
         <p class="mt-5">
         <a href="{{route('app.news.edit',$news->getKey())}}">
             <class class="btn btn-warning">
                 Редактировать?
             </class>
         </a>

         <a href="{{route('app.news.destroy',$news->getKey())}}" onclick="onDelete({{ $news->id }})">
             <class class="btn btn-danger">
                 Удалить?
             </class>

             <form action="{{ route('app.news.destroy', $news->getKey()) }}" method="post" style="display: none;" id="delete-form-{{ $news->id }}">
                 @csrf
                 @method('delete')
             </form>
         </a>
         </p>
     @endauth
@endsection

@push('scripts')
    <script>
        function onDelete(id) {
            event.preventDefault();

            var conf = confirm('Уверены?');

            if (conf) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
@endpush
