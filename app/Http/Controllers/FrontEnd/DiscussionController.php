<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiscussionStoreRequest;
use App\Models\Discussion;

class DiscussionController extends Controller
{
    public function submitDiscussion(DiscussionStoreRequest $request)
    {
        $data = $request->validated();
        Discussion::create($data);

        return response()->json(['success' => 1], 200);
    }
}
