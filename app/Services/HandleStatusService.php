<?php

namespace App\Services;

class HandleStatusService
{
    protected object $model;
    protected int $id;
    protected bool $batch;
    protected bool $status;
    protected string $modelName;
    protected array $modelNames = [
        'key' => 'ProjectKey',
        'project' => 'Project'
    ];

    protected array $parentModelNames = [
        'key' => 'Project',
        'project' => 'ProjectGroup'
    ];
    protected getModelService $getModelService;


    protected ReCalculateValuesService $reCalculateValuesService;
    public function __construct(
        GetModelService $getModelService,
        ReCalculateValuesService $reCalculateValuesService)
    {
        $this -> getModelService = $getModelService;
        $this -> reCalculateValuesService = $reCalculateValuesService;
    }

    public function action($id,  $type, $status, $batch)
    {
        $this->id = $id;
        $this -> batch = $batch;
        $this -> status = $status;
        $this->modelName = $batch ? $this -> parentModelNames[$type] : $this -> modelNames[$type];
        $this -> model =  $this -> getModelService ->getModel($this->modelName);
        $modelObject = $this -> model::findOrFail($this->id);
      if ($this -> batch) {
           $this -> handleBatchStatus($modelObject);
      }  else {
            $this -> handleStatus($modelObject);
      }
        $this->reCalculateValuesService->action($modelObject);


    }
    private function handleStatus($itemObject)
    {
        $itemObject -> active = $this -> status;
        $itemObject -> save();
    }

    private function handleBatchStatus(object $objectItem)
    {
        $items = [];
        if ($this-> modelName === 'Project') {
            $items = $objectItem -> keys() -> get();
        } elseIf($this-> modelName === 'ProjectGroup') {
            $items  =  $objectItem -> projects() ->get();
        }
        foreach ($items as $itemObject) {
            $this -> handleStatus($itemObject);
        }
    }
}
