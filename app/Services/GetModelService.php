<?php

namespace App\Services;


class GetModelService
{
    public $models = [
        'Project' => \App\Models\Project::class,
        'ProjectGroup' => \App\Models\ProjectGroup::class,
        'ProjectKey' => \App\Models\ProjectKey::class,
    ];

    public function getModel($modelNane)
    {
        $class = $this->models[$modelNane];

        return new $class;
    }
}
