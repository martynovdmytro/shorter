<?php

namespace App\Services;

use App\Models\Link;

class LinkService
{
    public function transform($request)
    {
        $url = $request['url'];
        $link = $this->generateLink();

        // $address = parse url
        // адрес должен быть выделен в отдельнуя ячейку
        // url должен быть выделен в другую ячейку
        // возврат линка в виде: $address . $link

        $response = Link::create([
            // 'address' => $address,
            'url' => $url,
            'link' => $link
        ]);

        return $response;
    }

    public function redirect($code)
    {
        // $address . $link redirect to $address . $url

        $link = Link::where('link', $code)->firstOrFail();

        return redirect($link->url);
    }

    private function generateLink()
    {
        $shortCode = '';

        // use regulars
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        for ($i = 0; $i < 8; $i++) {
            $randomIndex = rand(0, strlen($characters) - 1);
            $shortCode .= $characters[$randomIndex];
        }

        return $shortCode;
    }
}
