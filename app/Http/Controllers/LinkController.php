<?php

namespace App\Http\Controllers;

use App\Services\LinkService;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    private $linkService;

    public function __construct(LinkService $linkService)
    {
        $this->linkService = $linkService;
    }

    public function transform(Request $request)
    {
        $response = $this->linkService->transform($request);

        $message = $response ? 'success' : 'error';

        return response()->json([
            'data' => $response,
            'message' => $message
        ]);
    }
}
