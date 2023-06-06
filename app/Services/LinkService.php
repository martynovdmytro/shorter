<?php

namespace App\Services;

use App\Models\Link;

class LinkService
{
    public function transform($request)
    {
        $url = $request['url'];

        $issetUrl = Link::where('url', $url)->first();

        if (!$issetUrl) {
            $active = $this->checkLinkAvailability($url);
            $parsedUrl = parse_url($url);
            $address = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
            $code = $this->generateCode();
            $link = $address . $code;

            Link::create([
                'address' => $address,
                'url' => $url,
                'code' => $code,
                'active' => $active,
                'link' => $link
            ]);

        } else {
            $link = $issetUrl->link;
        }

        return $link;
    }

    public function getLink($request)
    {
        $link = Link::where('link', $request['link'])->firstOrFail();

        if ($link->active) {
            $link->increment('click_count');
            $link->refresh();

            return $link;
        } else {
            return false;
        }
    }

    private function generateCode()
    {
        $shortCode = '';

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

    public function checkLinkAvailability($url)
    {
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);

        $response = curl_exec($curl);
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        return $statusCode == 200;
    }
}
