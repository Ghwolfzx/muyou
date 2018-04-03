<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Handlers\ImageUploadHandler;

class ResourceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function show(Request $request, Resource $resource)
    {
        $resource = $resource->where('type', $resource->type)->get();

        return view('resource.show', compact('resource'));
    }
}
