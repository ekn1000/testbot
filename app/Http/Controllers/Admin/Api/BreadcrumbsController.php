<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Services\GetModelService;
use Illuminate\Http\Request;

class BreadcrumbsController extends Controller
{
    private GetModelService $getModelService;

    public function __construct(GetModelService $getModelService) {
        $this->getModelService = $getModelService;
    }

    public function index(Request $request)
    {
       $modelClass = $this->getModelService->getModel($request->get('type'));
       $model = $modelClass::findOrFail($request->get('id'));
       return $model->name;
    }
}
