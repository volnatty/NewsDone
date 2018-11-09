<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use App\Models\Tag;

class NewsController extends Controller
{
    public function __construct()
    {
        if (!in_array(app('router')->currentRouteName(), ['app.news.index', 'app.news.show']) && !auth()->check()) {
            $this->middleware('auth');
        }
    }

    public function index()
    {
        $newslist = News::query();

        if (request()->has('tag')) {
            $newslist = $newslist->whereHas('tags', function ($q)
            {
                $q->where('tag_id', request('tag'));
            });
        }

        return view('app.news.index', [
            'newslist' => $newslist->paginate(10),
        ]);

    }

    public function create()
    {
        return view('app.news.create', [
            'categories' => Category::orderBy('title')->get(),
            'tags' => Tag::orderBy('title')->get(),
        ]);
    }

    public function store()
    {
        request()->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $news = News::create(request()->all());

        $news->tags()->attach(request('tags'));

        return redirect()->route('app.news.show', $news);
    }

    public function update(News $news)
    {
        request()->validate([
            'title' => 'required',
            'body' => 'required',
//            'description' => 'description',
        ]);
        $news->update(request()->all());
        $news->tags()->sync(request('tags'));
        return redirect()->route('app.news.show', $news);

    }
    public function show(News $news)
    {
        return view('app.news.show', compact('news'));
    }


    /**
     * @param News $news
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit (News $news)
    {
        return view('app.news.edit', compact('news') , [
            'news' => News::query(),
            'categories' => Category::orderBy('title')->get(),
            'tags' => Tag::orderBy('title')->get(),
        ]);
    }

    public function destroy(News $news)
    {
        $news->delete();
        $news->tags()->delete();
        return redirect()->route('app.news.index');
    }
}
