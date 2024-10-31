<?php

namespace App\Services;
use App\Models\Project;
use App\Models\ProjectGroup;
use App\Models\ProjectKey;
use ReflectionClass;
class ReCalculateValuesService
{
    protected object $model;

    protected string $modelName;

    public function action($model)
    {
        $this -> model  = $model;

        $this -> modelName = (new ReflectionClass($this -> model))->getShortName();

        if($this -> modelName === 'Project') {
            $this -> recalculateProjectValues($this -> model->id);
        } elseif ($this -> modelName === 'ProjectGroup') {
            $this -> recalculateProjectGroupsValues($this -> model->id);
        } elseif($this -> modelName === 'ProjectKey') {
            $this -> recalculateProjectValues($this -> model->project_id);
        }
    }

    public function recalculateProjectGroupsValues($id)
    {
        $project_group = ProjectGroup::findOrFail($id);
        $projects_ids = $project_group->projects()->pluck('id');

        $project_group->active_projects =  $project_group
            ->projects()->where('active', 1)->count();
        $project_group->stopped_projects = $project_group
            ->projects()->where('active', 0)->count();
        $project_group->active_keys =  ProjectKey::whereIn('project_id', $projects_ids)
            ->where('active', 1)->count();
        $project_group->stopped_keys =  ProjectKey::whereIn('project_id', $projects_ids)
            ->where('active', 0)->count();
        $project_group->active_frequency =  ProjectKey::whereIn('project_id', $projects_ids)
            ->where('active', 1)->sum('frequency');
        $project_group->stopped_frequency =  ProjectKey::whereIn('project_id', $projects_ids)
            ->where('active', 0)->sum('frequency');
        $project_group->save();
    }

    public function recalculateProjectValues($id)
    {

        $project = Project::findOrFail($id);
        $project->active_keys =  $project->keys()->where('active', 1)->count();
        $project->stopped_keys =  $project->keys()->where('active', 0)->count();
        $project->daily_volume_of_keys = $project->keys()->where('active', 1)->sum('frequency_of_cheating');
        $project->save();
        $this->recalculateProjectGroupsValues($project->group_id);
    }

    public function recalculateProjectKeysFrequencyOfCheating($project_id)
    {
        $project_keys = ProjectKey::where('project_id', $project_id)->chunk(100,function ($project_keys){
            foreach ($project_keys as $project_key) {
                $project_key -> frequency_of_cheating =
                    round( $project_key -> frequency * $project_key -> coefficient / 30, 4);
                $project_key->save();
            }
        });
        $this->recalculateProjectValues($project_id);
    }
}
