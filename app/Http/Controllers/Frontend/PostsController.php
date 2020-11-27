<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPostRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class PostsController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        $selectedCategories = $request->input('categories', []);
        $posts = Post::with('categories')
            ->where(function ($query) use ($selectedCategories) {
                $query->when(!empty($selectedCategories), function ($query) use ($selectedCategories) {
                    $query->whereHas('categories', function ($query) use ($selectedCategories) {
                        $query->whereIn('id', array_keys($selectedCategories));
                    })->orWhereDoesntHave('categories');
                });
            })
            ->where('end_date', '>', now())
            ->get();

        $categories = Category::pluck('name', 'id');

        return view('frontend.posts.index', compact('posts', 'categories', 'selectedCategories'));
    }

    public function create()
    {
        abort_if(Gate::denies('post_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::all()->pluck('name', 'id');

        return view('frontend.posts.create', compact('categories'));
    }

    public function store(StorePostRequest $request)
    {
        $post = Post::create(['ip_address' => $request->ip()] + $request->all());

        if (!in_array(0, $request->input('categories', []))) {
            $post->categories()->sync($request->input('categories', []));
        }

        if ($request->input('attachment', false)) {
            $post->addMedia(storage_path('tmp/uploads/' . $request->input('attachment')))->toMediaCollection('attachment');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $post->id]);
        }

        return redirect()->route('frontend.posts.index');
    }

    public function show(Post $post)
    {
        $post->load('categories');

        return view('frontend.posts.show', compact('post'));
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('post_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Post();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
