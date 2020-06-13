<?php

namespace ChemLab\Http\Controllers\Advanced;

use ChemLab\Jobs\Cron\DBBackup;
use ChemLab\Jobs\Cron\RunQueue;
use ChemLab\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class CronController extends Controller
{
    /**
     * Trigger database backup
     *
     * @return JsonResponse
     */
    public function backup(): JsonResponse
    {
        DBBackup::dispatchNow();
        return response()->json(['status' => 'success']);
    }

    /**
     * Trigger queue execution
     *
     * @return JsonResponse
     */
    public function queue(): JsonResponse
    {
        RunQueue::dispatchNow();
        return response()->json(['status' => 'success']);
    }
}
