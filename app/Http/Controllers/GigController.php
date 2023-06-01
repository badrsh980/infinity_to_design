<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Extra;
use App\Models\Gig;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Inertia\Inertia;
use Illuminate\Support\Str;

class GigController extends Controller
{

    public function index()
    {
        $categories = Category::get();

        $gigs = Gig::with('category')->where('user_id', user()->id)->get();

        return Inertia::render('Gig/Index', compact('gigs', 'categories'));
    }

    public function create()
    {
        $categories = Category::get();

        $prices = [
            5 => price_format(5),
            10 => price_format(10),
        ];

        $times = array_of_times();
        $extras_prices = array_of_extras_prices();
        $extras_times = [
            'yes' => __('Time will be increased'),
            'no' => __('Time will not be increased'),
        ];

        return Inertia::render('Gig/Create', compact('categories', 'prices', 'times', 'extras_prices', 'extras_times'));
    }

    public function store(Request $request)
    {
        $times = array_of_times();
        $extras_prices = array_of_extras_prices();
        $thumbnails = [];

        $request->validate([
            'title' => 'required|max:200|string',
            'category' => 'required|numeric|exists:categories,id',
            'description' => 'required|max:5000',
            'thumbnails' => 'required|array|between:1,5',
            'thumbnails.*' => 'required|max:2048|mimes:png,gif,jpg,jpeg',
            'price' => 'required|in:5,10',
            'time' => 'required|in:' . implode(',', array_keys($times)),
            'extras' => 'nullable|array|between:1,10',
            'extras.*' => 'nullable|array:title,price,increased_time,time',
            'extras.*.title' => 'required|max:200|string',
            'extras.*.price' => 'required|in:' . implode(',', array_keys($extras_prices)),
            'extras.*.increased_time' => 'required|in:yes,no',
            'extras.*.time' => 'required|in:' . implode(',', array_keys($times)),
        ]);

        foreach ($request->thumbnails as $thumbnail) {

            try {
                $name = unique_str() . $thumbnail->getClientOriginalName();

                $thumbnail->storeAs('/public/images/gigs/', $name);

                $thumbnails[] =  $name;
            } catch (\Throwable $th) {
                return false;
            }
        }

        $gig = Gig::create([
            'status' => 'pending',
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'thumbnails' => $thumbnails,
            'delivery_time' => $request->time,
            'instructions'  => $request->instructions,
            'price'  => $request->price,
            'user_changes' => null,
            'language' => app()->getLocale(),
            'user_id' => user()->id,
            'category_id' => $request->category,
        ]);

        if ($request->extras) {
            foreach ($request->extras as $extra) {
                Extra::create([
                    'title' => $extra['title'],
                    'price' => $extra['price'],
                    'change_gig_date' => $extra['increased_time'],
                    'extra_time' => $extra['time'],
                    'gig_id' => $gig->id
                ]);
            }
        }

        return to_route('gigs.index');
    }

    public function edit($id)
    {
        $gig = Gig::where('user_id', user()->id)->with(['category', 'extras'])->where('id', $id)->firstOrFail();

        $categories = Category::get();

        $prices = [
            5 => price_format(5),
            10 => price_format(10),
        ];

        $times = array_of_times();
        $extras_prices = array_of_extras_prices();
        $extras_times = [
            'yes' => __('Time will be increased'),
            'no' => __('Time will not be increased'),
        ];

        return Inertia::render('Gig/Edit', compact('categories', 'prices', 'times', 'extras_prices', 'extras_times', 'gig'));
    }

    public function update($id, Request $request)
    {
        $gig = Gig::with(['extras'])->where('user_id', user()->id)->where('id', $id)->firstOrFail();

        $times = array_of_times();
        $extras_prices = array_of_extras_prices();
        $thumbnails = [];

        $request->validate([
            'title' => 'required|max:200|string',
            'category' => 'required|numeric|exists:categories,id',
            'description' => 'required|max:5000',
            'thumbnails' => 'required|array|between:1,5',
            // 'thumbnails.*' => 'nullable|image|max:2048|mimes:png,gif,jpg,jpeg',
            'price' => 'required|in:5,10',
            'time' => 'required|in:' . implode(',', array_keys($times)),
            'extras' => 'nullable|array|between:0,10',
            'extras.*' => 'nullable|array:id,title,price,increased_time,time',
            'extras.*.title' => 'required|max:200|string',
            'extras.*.price' => 'required|in:' . implode(',', array_keys($extras_prices)),
            'extras.*.increased_time' => 'required|in:yes,no',
            'extras.*.time' => 'required|in:' . implode(',', array_keys($times)),
        ]);


        foreach ($request->thumbnails as $thumbnail) {

            if ($thumbnail instanceof UploadedFile) {

                if (!in_array($thumbnail->extension(), ['png', 'gif', 'jpg', 'jpeg'])) {
                    return;
                }

                try {
                    $name = unique_str() . $thumbnail->getClientOriginalName();

                    $thumbnail->storeAs('/public/images/gigs/', $name);

                    $thumbnails[] =  $name;
                } catch (\Throwable $th) {
                    return false;
                }
            } else {
                $thumbnails[] =  $thumbnail;
            }
        }

        $gig->update([
            'status' => 'pending',
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'thumbnails' => $thumbnails,
            'delivery_time' => $request->time,
            'instructions'  => $request->instructions,
            'price'  => $request->price,
            'user_changes' => null,
            'language' => app()->getLocale(),
            'category_id' => $request->category,
        ]);

        if ($request->extras) {
            foreach ($request->extras as $extra) {
                // if (isset($extra['id'])) {
                if ($extra['id']) {
                    $e = $gig->extras->where('id', $extra['id'])->first();

                    $e->update([
                        'title' => $extra['title'],
                        'price' => $extra['price'],
                        'change_gig_date' => $extra['increased_time'],
                        'extra_time' => $extra['time'],
                    ]);
                } else {
                    Extra::create([
                        'title' => $extra['title'],
                        'price' => $extra['price'],
                        'change_gig_date' => $extra['increased_time'],
                        'extra_time' => $extra['time'],
                        'gig_id' => $gig->id
                    ]);
                }
                // }
            }
        }


        return to_route('gigs.index');
    }

    public function deleteExtra($extra, $gig)
    {
        $gig = Gig::with(['extras'])->where('user_id', user()->id)->where('id', $gig)->first();

        if ($gig) {
            $extra = $gig->extras->where('id', $extra)->first();

            if ($extra) {
                $extra->delete();
            }
        }
    }

    public function show($id)
    {
        $gig = Gig::with(['category', 'extras'])->where('user_id', user()->id)->where('id', $id)->firstOrFail();

        $categories = Category::get();

        $prices = [
            5 => price_format(5),
            10 => price_format(10),
        ];

        $times = array_of_times();
        $extras_prices = array_of_extras_prices();
        $extras_times = [
            'yes' => __('Time will be increased'),
            'no' => __('Time will not be increased'),
        ];

        return Inertia::render('Gig/Show', compact('categories', 'prices', 'times', 'extras_prices', 'extras_times', 'gig'));
    }

    public function destroy($id)
    {
        $gig = Gig::with(['extras'])->where('user_id', user()->id)->where('id', $id)->firstOrFail();

        if ($gig) {
            $gig->delete();

            foreach ($gig->extras as $extra) {
                $extra->delete();
            }
        }

        return to_route('gigs.index');
    }
}
