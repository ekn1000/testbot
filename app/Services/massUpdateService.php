<?php

namespace App\Services;

use App\Models\Project;
use App\Models\ProjectKey;


class massUpdateService
{
    private string $updateType;
    private array $conditions;

    public function massUpdate($formData)
    {
        $form = $formData['data'];
        $projectKeys = ProjectKey::query() -> where('project_id', $form['project_id']);
        if(isset($formData['conditions'])) {
            if(count($formData['conditions']) > 0) {
                $this -> conditions = $formData['conditions'];
                $projectKeys = $this -> filterConditions($projectKeys);
            }
        } elseif (isset($formData['selectionIds'])) {
            $projectKeys = $projectKeys->whereIn('id', $formData['selectionIds']);
        }
        $keys_count = $projectKeys->count();
        $projectKeys = $projectKeys -> update($form);

        return $keys_count;
    }

    private function filterConditions($projectKeys)
    {
        foreach ($this -> conditions as $key => $condition) {

           switch ($condition['type']){
               case 'contains':
                   $projectKeys -> where($key, 'like', '%' . $condition['value'] . '%');
                   break;
               case 'equal':
                   $projectKeys -> where($key, '=', $condition['value']);
                   break;
               case 'notEmpty':
                   $condition['value'] ? $projectKeys -> whereNotNull($key) : $projectKeys -> whereNull($key);
                   break;
               case 'active':
                   $projectKeys -> where($key, '=', $condition['value'] );
                   break;
               case 'range':
                   $projectKeys -> where($key , '>=', $condition['value']['from'])
                   ->where($key, '<=', $condition['value']['to']);
                   break;
               default:
                   break;
           }
        }
        return $projectKeys;
    }

}
