<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewStoreRequest;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function postRatingImage(Request $request)
    {
        $image    = $request->file('formData');
        $newImage = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('storage/images/testimonial'), $newImage);

        return response()->json(['url' => $request->getSchemeAndHttpHost() . '/storage/images/testimonial/' . $newImage]);
    }

    public function submitRatingComment(ReviewStoreRequest $request)
    {
        $data = $request->validated();
        Review::create($data);

        return response()->json(['success' => 1], 200);
    }

}
