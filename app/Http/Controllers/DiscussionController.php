<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class DiscussionController extends Controller
{
    public function quickUpdate(Request $request): JsonResponse
    {
        //$this->authorize('products.update');
        $type = $request->input('type');
        $value = $request->input('value');
        $id = $request->input('id');
        $dataUpdate = [$type => $value];
        $result = Discussion::where('id', '=', $id)->update($dataUpdate);
        if ($result) {
            return response()->json(['status' => 1]);
        } else {
            return response()->json(['status' => 0]);
        }
    }

    public function getData(Request $request)
    {
        $reviewId = $request->id;
        $discussions = Discussion::where('review_id', $reviewId)->paginate();
        return response()->json([
            'view' => view('reviews.elements.discussion', compact('discussions', 'reviewId'))->render(),
        ]);
    }

    public function destroy(Request $request)
    {
        if (!$request->user()->can('reviews.destroy')) {
            throw new AccessDeniedHttpException;
        }
        $discussionId = $request->discussion;
        Discussion::find($discussionId)->delete();
    }
}
