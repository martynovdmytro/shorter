<?php

namespace App\Jobs;

use App\Services\LinkService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

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
        $urlCollection = $this->linkService->getAllLinks();

        foreach ($urlCollection as $item) {
            $active = $this->checkLinkAvailability($item->url);
            if (!$active) {
                DB::table('links')->where('id', $item->id)->update([
                    'active' => false
                ]);
            }
        }
    }
}
