<?php

namespace Naoray\LaravelHarvest\Models;

class Task extends BaseModel
{
    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'external_id', 'name', 'billable_by_default', 'default_hourly_rate',
        'is_default', 'is_active',
    ];

    /**
     * Task constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(
            config('harvest.table_prefix').config('harvest.table_names.tasks')
        );
    }
}