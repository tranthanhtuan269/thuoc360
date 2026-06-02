<?php

namespace App\Http\Controllers;

use App\Support\PublicImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EditorImageController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpeg,jpg,png,webp,gif', 'max:5120'],
        ]);

        $userId = auth()->id();
        $path = PublicImage::storeForUser(
            $request->file('image'),
            $userId,
            'editor'
        );

        return response()->json([
            'url' => PublicImage::url($path),
        ]);
    }
}
