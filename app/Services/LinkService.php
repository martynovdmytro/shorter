<?php

namespace App\Services;

use App\Models\Link;
use Illuminate\Support\Facades\DB;

class LinkService
{
    public function transform($request)
    {
        $url = $request['url'];
        $parsedUrl = parse_url($url);
        $address = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
        $code = $this->generateCode();
        $link = $address . $code;

        Link::create([
            'address' => $address,
            'url' => $url,
            'code' => $code,
            'link' => $link
        ]);

        return $link;
    }

    public function getLink($request)
    {
        $link = Link::where('link', $request['link'])->firstOrFail();

        $link->increment('click_count');
        $link->refresh();

        return $link;
    }

    private function generateCode()
    {
        $shortCode = '';

        // use regulars
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        for ($i = 0; $i < 8; $i++) {
            $randomIndex = rand(0, strlen($characters) - 1);
            $shortCode .= $characters[$randomIndex];
        }

        return '/' . $shortCode;
    }

    public function getAllLinks ()
    {
        return Link::all();
    }
}
