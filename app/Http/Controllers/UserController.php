<?php

namespace App\Http\Controllers;

use App\Models\UserImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Adds a new image to an existing user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uri' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $image_url = $request->uri;

        $response = Http::withBasicAuth(env('API_KEY'), env('API_SECRET'))
            ->get('https://api.imagga.com/v2/categories/personal_photos?image_url=' . $image_url);

        $decoded = json_decode($response);
        $categories = $decoded->result->categories;
        for ($i = 0; $i < count($categories); $i++) {
            UserImages::create([
                'uri' => $image_url,
                'category' => $categories[$i]->name->en,
                'user_id' => auth()->user()->id
            ]);
        }
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Get Images for an existing user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userImages(Request $request)
    {
        $images = auth()->user()->userImages;
        $data = array();
        for($i=0; $i<count($images); $i++){
            if(!array_key_exists($images[$i]->category, $data))
                $data[$images[$i]->category]= array();
            array_push($data[$images[$i]->category], $images[$i]);
        }
        return response()->json($data, 200);
    }
}
