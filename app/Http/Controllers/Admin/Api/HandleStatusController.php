<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Services\HandleStatusService;
use Illuminate\Http\Request;

class HandleStatusController extends Controller
{
    private HandleStatusService $handleStatusService;

    public function __construct(HandleStatusService $handleStatusService)
    {
        $this->handleStatusService = $handleStatusService;
    }
    public function handleStatus(Request $request)
    {
        $this -> handleStatusService -> action(
            $request->get('id'),
            $request->get('type'),
            $request->get('status'),
            false
        );
        return $request->get('status');
    }

    public function handleBatchStatus(Request $request)
    {
        $this -> handleStatusService -> action(
            $request->get('parent_id'),
            $request->get('type'),
            $request->get('status'),
            true
        );
    }


}
