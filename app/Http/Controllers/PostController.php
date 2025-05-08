<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStore;
use App\Http\Requests\PostUpdate;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PostsExport;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('posts.index');

        $requestAll = Arr::except($request->all(), ['page', '_pjax']);

        $postStatus = Post::STATUS;

        $posts = Post::filter($request->all())
            ->withoutGlobalScope('published')
            ->with('categories')
            ->orderByDesc('id')
            ->paginate();
        return view('posts.index', compact('posts', 'requestAll', 'postStatus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return mixed
     */
    public function create(Request $request)
    {
        if (!$request->user()->can('posts.store')) {
            throw new AccessDeniedHttpException;
        }
        return view('posts.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\PostStore $request
     *
     * @return mixed
     */
    public function store(PostStore $request)
    {
        $data = $request->validated();


        $post = Post::create($data);

        if (!empty($data['products'])) {
            $post->products()->attach($data['products']);
        }

        $this->storeExtraData($post, $data);
        // return redirect()->route('posts.index')->with('success', __('Created post: :title', ['title' => $post->title]));
        return redirect()->route('posts.edit', ['post' => $post->id])->with('success', __('Created success'));
    }

    /**
     * Store product extra data
     *
     * @param \App\Models\Post $post
     * @param array            $data
     *
     * @return void
     */
    public function storeExtraData(Post $post, array $data): void
    {
        if (!empty($data['categories'])) {
            $post->categories()->sync($data['categories']);
        }
        // SEO
        if (!empty($post->seo)) {
            $post->seo->update($data['seo']);
        } else {
            $post->seo()->create($data['seo']);
        }
        // Tag
        $post->postTags()->sync($data['post_tags'] ?? []);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Post         $post
     *
     * @return mixed
     */
    public function edit(Request $request, Post $post)
    {
        if (!$request->user()->can('posts.update')) {
            throw new AccessDeniedHttpException;
        }

        return view('posts.form', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdatePost $request
     * @param \App\Models\Post              $post
     *
     * @return mixed
     */
    public function update(PostUpdate $request, Post $post)
    {
        $data = $request->all();
        if ($post->update($data)) {
            $post->products()->sync($data['products'] ?? []);
            $this->storeExtraData($post, $data);
        }

        //return redirect()->route('posts.index')->with('success', __('Updated post: :title', ['title' => $post->title]));
        return redirect()->route('posts.edit', ['post' => $post->id])->with('success', __('Edited success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Post         $post
     *
     * @return void
     * @throws \Exception
     */
    public function destroy(Request $request, Post $post): void
    {
        if (!$request->user()->can('posts.destroy')) {
            throw new AccessDeniedHttpException;
        }
        if (!$post->delete()) {
            throw new AccessDeniedHttpException;
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function quickUpdate(Request $request): JsonResponse
    {
        $this->authorize('posts.update');
        $type = $request->input('type');
        $value = $request->input('value');
        $id = $request->input('id');
        $dataUpdate = [$type => $value];
        $result = Post::where('id', '=', $id)
            ->withoutGlobalScope('published')
            ->update($dataUpdate);

        if ($result) {
            return response()->json(['status' => 1]);
        } else {
            return response()->json(['status' => 0]);
        }
    }

    public function getPostForProduct(Request $request)
    {
        app()->resolving(LengthAwarePaginator::class, function (LengthAwarePaginator $paginator) use ($request) {
            $paginator->appends($request->all());
        });

        $posts = Post::filter($request->all())
            ->where('title', 'LIKE', '%' . $request->get('q') . '%')
            ->with('categories');

        if (!empty($orders = $request->get('orders'))) {
            $posts->orderByDesc(\DB::raw("FIELD(`id`, $orders)"));
        }

        $posts = $posts->paginate(20, [
            'id',
            'title',
            'product_category_id',
        ]);

        $posts->getCollection()->each->setAppends([]);

        return $posts;
    }

    /**
     * Export products list as excel.
     *
     * @return \Maatwebsite\Excel\BinaryFileResponse|BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export()
    {
        return Excel::download(new PostsExport, 'posts_' . date('Ymd_His') . '.xlsx');
    }
}
