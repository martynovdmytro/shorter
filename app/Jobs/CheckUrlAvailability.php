<?php

namespace App\Jobs;

use App\Services\LinkService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckUrlAvailability implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $linkService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(LinkService $linkService)
    {
        $this->linkService = $linkService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        $urlCollection = $this->linkService->getAllLinks

        // foreach ($urlCollection as $url) {

        // $this->checkLinkAvailability($url)
        // if urlAvailable = false {
        // links where id = id update active = false
        // }
        // }


    }

    public function checkLinkAvailability($url)
    {
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);

        $response = curl_exec($curl);
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        return $statusCode === 200;
    }
}
