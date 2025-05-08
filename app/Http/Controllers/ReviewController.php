<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminReviewStore;
use App\Http\Requests\ReviewAdminStoreRequest;
use App\Http\Requests\ReviewUpdate;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        $this->authorize('reviews.index');
        $requestAll = Arr::except($request->all(), ['page', '_pjax']);
        $reviews = Review::when($request->approved, function ($query) use ($request) {
            $query->where('approved', '=', $request->approved);
        })
            ->when($request->body, function ($query) use ($request) {
                $query->where('body', 'LIKE', '%' . $request->body . '%');
            })
            ->when($request->created_at, function ($query) use ($request) {
                $query->whereBetween('created_at', dateRangePicker($request->created_at));
            })
            ->with(['user', 'product', 'getDiscussionHasApproved'])
            ->orderBy('id', 'desc')
            ->paginate();
        return view('reviews.index', compact('reviews', 'requestAll'));
    }

    public function create()
    {
        return view('reviews.form');
    }

    public function store(ReviewAdminStoreRequest $request)
    {
        Review::create($request->validated());
        return redirect()->route('reviews.index')->with('success', __('Success'));
    }

    public function edit(Request $request, Review $review)
    {
        if (!$request->user()->can('reviews.update')) {
            throw new AccessDeniedHttpException;
        }

        return view('reviews.form', compact('review'));
    }

    public function update(ReviewUpdate $request, Review $review)
    {
        $data = $request->validated();
        $review->update($data);
        return redirect()
            ->route('reviews.index')
            ->with('success', __('Updated review: :title', ['title' => $review->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Review       $review
     *
     * @return void
     * @throws \Exception
     */
    public function destroy(Request $request, Review $review): void
    {
        if (!$request->user()->can('reviews.destroy')) {
            throw new AccessDeniedHttpException;
        }
        if (!$review->delete()) {
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
        $this->authorize('products.update');
        $type = $request->input('type');
        $value = $request->input('value');
        $id = $request->input('id');
        $dataUpdate = [$type => $value];
        $result = Review::where('id', '=', $id)->update($dataUpdate);
        if ($result) {
            return response()->json(['status' => 1]);
        } else {
            return response()->json(['status' => 0]);
        }
    }
}
