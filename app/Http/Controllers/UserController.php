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
        $api_credentials = array(
            'key' => 'acc_9a38cfea4645d9e',
            'secret' => 'b54a0a9f0591f2bdeed95dc25a6b4e3c'
        );

        $validator = Validator::make($request->all(), [
            'uri' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $image_url = $request->uri;

        $response = Http::withBasicAuth($api_credentials['key'], $api_credentials['secret'])
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
        return response()->json(['images' => auth()->user()->userImages], 200);
    }
}
