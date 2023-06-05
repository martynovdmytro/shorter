<?php

namespace App\Http\Controllers;

use App\Services\LinkService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LinkController extends Controller
{
    private $linkService;

    public function __construct(LinkService $linkService)
    {
        $this->linkService = $linkService;
    }

    public function transform(Request $request)
    {
        $validated = $request->validate([
            'url' => 'required|url|min:8|max:255'
        ]);

        $response = $this->linkService->transform($validated);

        $message = $response ? 'success' : 'error';

        return response()->json([
            'data' => $response,
            'message' => $message
        ]);
    }

    public function redirect(Request $request)
    {
        $validated = $request->validate([
            'link' => 'required|url|min:8|max:255'
        ]);

        $link = $this->linkService->getLink($validated);

        if (!empty($link)) {
            $data = json_encode([
                'link' => $validated['link'],
                'click' => $link->click_count
            ]);

            $cookie = cookie('click_counter', $data, 60);

            return redirect($link->url)->cookie($cookie);
        } else {
            return response()->json(['error' => 'Not Found'], 404);
        }
    }

    public function getClickCounter(Request $request)
    {
        return json_decode($request->cookie('click_counter'));
    }
}
