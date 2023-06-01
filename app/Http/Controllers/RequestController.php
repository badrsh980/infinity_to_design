<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Request as ModelsRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RequestController extends Controller
{
    public function requests()
    {
        $requests = ModelsRequest::with([
            'user',
            'lastComment' => function ($q) {
                return $q->with('user');
            },
        ])
            ->where('status', 'active')
            ->paginate(20);
        $categories = Category::get();

        return Inertia::render('Requests', compact('requests', 'categories'));
    }

    public function requests_show($slug, Request $r)
    {
        $categories = Category::get();
        $request = ModelsRequest::where('slug', $slug)
            ->with([
                'user',
                'comments' => function ($q) {
                    return $q->with('user');
                },
            ])
            ->withCount([
                'comments',
            ])
            ->where('status', 'active')
            ->firstOrFail();

        if ($r->isMethod('post')) {

            if (auth()->check()) {
                $r->validate([
                    'content' => 'required|string|max:1000'
                ]);

                if (!$request->comments->where('user_id', user()->id)->first()) {
                    if ($request->user_id != user()->id) {
                        $comment = Comment::create([
                            'content' => $r->content,
                            'user_id' => user()->id,
                            'request_id' => $request->id,
                        ]);

                        return to_route('requests.show', [
                            'slug' => $slug,
                        ]);
                    } else {
                        return to_route('requests.show', [
                            'slug' => $slug,
                        ])->with('message', __('لا يمكنك التعليق على موضوعك'));
                    }
                } else {
                    return to_route('requests.show', [
                        'slug' => $slug,
                    ])->with('message', __('لديك تعليق سابق على هذا الطلب'));
                }
            } else {
                return to_route('requests.show', [
                    'slug' => $slug,
                ])->with('message', __('المرجو تسجيل الدخول قبل إضافة أية تعليق'));
            }
        }


        return Inertia::render('Request', compact('request', 'categories'));
    }

    public function index()
    {
        $requests = \App\Models\Request::where('user_id', user()->id)->get();
        $categories = Category::get();

        return Inertia::render('Request/Index', compact('requests', 'categories'));
    }

    public function create()
    {
        $categories = Category::get();

        return Inertia::render('Request/Create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'content' => 'required|string|max:1500'
        ]);

        \App\Models\Request::create([
            'status' => 'active',
            'title' => $request->title,
            'slug' => str()->slug($request->title),
            'content' => $request->content,
            'user_id' => user()->id,
        ]);

        return to_route('member.requests.index')->with('message', __('Request has been created!'));
    }

    public function edit($id)
    {
        $request = \App\Models\Request::where([
            'id' => $id,
            'user_id' => user()->id
        ])->firstOrFail();

        $categories = Category::get();

        return Inertia::render('Request/Edit', compact('request', 'categories'));
    }

    public function update($id, Request $request)
    {
        $r = \App\Models\Request::where([
            'id' => $id,
            'user_id' => user()->id
        ])->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:200',
            'content' => 'required|string|max:1500'
        ]);

        $r->update([
            'title' => $request->title,
            'slug' => str()->slug($request->title),
            'content' => $request->content,
        ]);

        return to_route('member.requests.index')->with('message', __('Request has been updated!'));
    }

    public function destroy($id)
    {
        $r = \App\Models\Request::where([
            'id' => $id,
            'user_id' => user()->id
        ])->firstOrFail();

        $r->delete();

        return to_route('member.requests.index')->with('message', __('Request has been deleted!'));
    }
}
