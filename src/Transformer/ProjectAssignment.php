<?php

namespace Naoray\LaravelHarvest\Transformer;

use Naoray\LaravelHarvest\Contracts\Transformer;
use \Naoray\LaravelHarvest\Models\ProjectAssignment as ProjectAssignmentModel;

class ProjectAssignment implements Transformer
{
    /**
     * @param $data
     * @return mixed
     */
    public function transformModelAttributes($data)
    {
        $projectAssignment = (new ProjectAssignmentModel())->firstOrNew(['external_id' => $data['id']]);

        $projectAssignment->external_id = $data['id'];
        $projectAssignment->project = $data['project'];
        $projectAssignment->client = $data['client'];
        $projectAssignment->is_active = $data['is_active'];
        $projectAssignment->is_project_manager = $data['is_project_manager'];
        $projectAssignment->hourly_rate = $data['hourly_rate'];
        $projectAssignment->budget = $data['budget'];
        $projectAssignment->task_assignments = $data['task_assignments'];

        return $projectAssignment;
    }
}