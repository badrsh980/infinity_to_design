<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Extra;
use App\Models\Gig;
use App\Models\Scopes\MineScope;
use App\Notifications\GigApproved;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Inertia\Inertia;
use Illuminate\Support\Str;

class GigsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->gig && $request->page) {

            switch ($request->page) {
                case 'approve':
                    $gig = Gig::withoutGlobalScope(new MineScope)->where([
                        'id' => $request->gig,
                        'status' => 'pending'
                    ])->firstOrFail();

                    $gig->user->notify(new GigApproved($gig));

                    $gig->status = 'active';
                    $gig->save();

                    break;
            }

            return to_route('admin.gigs.index');
        }

        $gigs = Gig::withoutGlobalScope(new MineScope)->with(['user', 'category'])->paginate(10);

        return Inertia::render('Admin/Gig/index', compact('gigs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sts = [
            "pending" => __('Pending'),
            'active' => __('Active'),
            'inactive' => __('Inactive'),
        ];

        $categories = Category::get();

        $prices = [
            5 => price_format(5),
            10 => price_format(10),
        ];
        $languages = [
            'ar' => __('Arabic'),
            'en' => __('English'),
        ];

        $times = array_of_times();
        $extras_prices = array_of_extras_prices();
        $extras_times = [
            'yes' => __('Time will be increased'),
            'no' => __('Time will not be increased'),
        ];

        return Inertia::render('Admin/Gig/create', compact("sts", "categories", "prices", "times", "extras_prices", "extras_times", "languages"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $sts = [
            "pending" => __('Pending'),
            'active' => __('Active'),
            'inactive' => __('Inactive'),
        ];
        $prices = [
            5 => price_format(5),
            10 => price_format(10),
        ];
        $languages = [
            'ar' => __('Arabic'),
            'en' => __('English'),
        ];
        $times = array_of_times();
        $extras_prices = array_of_extras_prices();

        $request->validate([
            'status' => 'required|in:' . implode(',', array_keys($sts)),
            'title' => 'required|max:200|string',
            'category' => 'required|numeric|exists:categories,id',
            'user_id' => 'required|numeric|exists:users,id',
            'description' => 'required|max:5000',
            'thumbnails' => 'required|array|between:1,5',
            'thumbnails.*' => 'required|max:2048|mimes:png,gif,jpg,jpeg',
            'price' => 'required|in:5,10',
            'language' => 'required|in:' . implode(',', array_keys($languages)),
            'delivery_time' => 'required|in:' . implode(',', array_keys($times)),
            'extras' => 'nullable|array|between:1,10',
            'extras.*' => 'nullable|array:title,price,change_gig_date,time',
            'extras.*.title' => 'required|max:200|string',
            'extras.*.price' => 'required|in:' . implode(',', array_keys($extras_prices)),
            'extras.*.change_gig_date' => 'required|in:yes,no',
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
            'status' => $request->status,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'thumbnails' => $thumbnails,
            'delivery_time' => $request->delivery_time,
            'instructions'  => $request->instructions,
            'price'  => $request->price,
            'user_changes' => null,
            'language' => app()->getLocale(),
            'user_id' => $request->user_id,
            'category_id' => $request->category,
        ]);

        if ($request->extras) {
            foreach ($request->extras as $extra) {
                Extra::create([
                    'title' => $extra['title'],
                    'price' => $extra['price'],
                    'change_gig_date' => $extra['change_gig_date'],
                    'extra_time' => $extra['time'],
                    'gig_id' => $gig->id
                ]);
            }
        }

        return to_route('admin.gigs.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $gig = Gig::withoutGlobalScope(new MineScope)->with(['user', 'extras', 'category'])->where('id', $id)->firstOrFail();

        $languages = [
            'ar' => __('Arabic'),
            'en' => __('English'),
        ];

        $times = array_of_times();
        $extras_prices = array_of_extras_prices();
        $extras_times = [
            'yes' => __('Time will be increased'),
            'no' => __('Time will not be increased'),
        ];

        return Inertia::render('Admin/Gig/show', compact("gig", "times", "extras_prices", "extras_times", "languages"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $gig = Gig::withoutGlobalScope(new MineScope)->with(['user', 'extras'])->where('id', $id)->firstOrFail();

        $sts = [
            "pending" => __('Pending'),
            'active' => __('Active'),
            'inactive' => __('Inactive'),
        ];

        $categories = Category::get();

        $prices = [
            5 => price_format(5),
            10 => price_format(10),
        ];
        $languages = [
            'ar' => __('Arabic'),
            'en' => __('English'),
        ];

        $times = array_of_times();
        $extras_prices = array_of_extras_prices();
        $extras_times = [
            'yes' => __('Time will be increased'),
            'no' => __('Time will not be increased'),
        ];

        return Inertia::render('Admin/Gig/edit', compact("gig", "sts", "categories", "prices", "times", "extras_prices", "extras_times", "languages"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $gig = Gig::withoutGlobalScope(new MineScope)->with(['user', 'extras'])->where('id', $id)->firstOrFail();

        $sts = [
            "pending" => __('Pending'),
            'active' => __('Active'),
            'inactive' => __('Inactive'),
        ];
        $times = array_of_times();
        $extras_prices = array_of_extras_prices();
        $thumbnails = [];

        $languages = [
            'ar' => __('Arabic'),
            'en' => __('English'),
        ];

        $request->validate([
            'status' => 'required|in:' . implode(',', array_keys($sts)),
            'title' => 'required|max:200|string',
            'category' => 'required|numeric|exists:categories,id',
            'user_id' => 'required|numeric|exists:users,id',
            'thumbnails' => 'required|array|between:1,5',
            'description' => 'required|max:5000',
            'price' => 'required|in:5,10',
            'language' => 'required|in:' . implode(',', array_keys($languages)),
            'delivery_time' => 'required|in:' . implode(',', array_keys($times)),
            'extras' => 'nullable|array|between:1,10',
            // 'extras.*' => 'nullable|array:title,price,change_gig_date',
            'extras.*.title' => 'required|max:200|string',
            'extras.*.price' => 'required|in:' . implode(',', array_keys($extras_prices)),
            'extras.*.change_gig_date' => 'required|in:yes,no',
            'extras.*.time' => 'requiredif:extras.*.change_gig_date,yes|in:' . implode(',', array_keys($times)),
        ]);

        // 'thumbnails' => 'required|array|between:1,5',
        // 'thumbnails.*' => 'required|max:2048|mimes:png,gif,jpg,jpeg',

        foreach ($request->thumbnails as $index => $thumbnail) {

            if ($thumbnail instanceof UploadedFile) {

                $request->validate([
                    'thumbnails.' . $index => 'required|max:2048|mimes:png,gif,jpg,jpeg',
                ]);

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
            'delivery_time' => $request->delivery_time,
            'instructions'  => $request->instructions,
            'price'  => $request->price,
            'user_changes' => null,
            'language' => $request->language,
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
                        'change_gig_date' => $extra['change_gig_date'],
                        'extra_time' => $extra['time'],
                    ]);
                } else {
                    Extra::create([
                        'title' => $extra['title'],
                        'price' => $extra['price'],
                        'change_gig_date' => $extra['change_gig_date'],
                        'extra_time' => $extra['time'],
                        'gig_id' => $gig->id
                    ]);
                }
                // }
            }

            // $gig->user->notify(new GigApproved($gig));
        }


        return to_route('admin.gigs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gig = Gig::withoutGlobalScope(new MineScope)->where('id', $id)->firstOrFail();

        $gig->delete();

        return to_route('admin.gigs.index')->with('message', __('Gig has been deleted'));
    }
}
