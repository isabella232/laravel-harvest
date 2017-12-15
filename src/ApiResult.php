<?php

namespace Naoray\LaravelHarvest;

use Naoray\LaravelHarvest\Traits\CanConvertDateTimes;

class ApiResult
{
    use CanConvertDateTimes;
    
    /**
     * @var
     */
    protected $data;

    /**
     * @var
     */
    protected $jsonResult;

    /**
     * @var Model
     */
    protected $model;

    /**
     * ApiResult constructor.
     * @param $data
     * @param $modelName
     */
    public function __construct($data, $modelName)
    {
        $this->data = $data;
        $this->jsonResult = $this->data->json();
        $this->model = $modelName;
    }

    /**
     * Transform results to json.
     *
     * @return mixed
     */
    public function toJson()
    {
        return $this->jsonResult;
    }

    /**
     * Transforms results into collection.
     *
     * @return Illuminate\Support\Collection
     */
    public function toCollection()
    {
        if ($this->countResults() == 1) {
            return $this->transformToModel([$this->jsonResult]);
        }

        return $this->transformToModel($this->jsonResult[$this->getResultsKey()]);
    }

    /**
     * Transform results to collection.
     *
     * @return mixed
     */
    public function toPaginatedCollection()
    {
        $this->jsonResult[$this->getResultsKey()] = $this->toCollection();

        return $this->jsonResult;
    }

    /**
     * @return int
     */
    private function countResults()
    {
        if (array_key_exists('total_entries', $this->jsonResult)) {
            return $this->jsonResult['total_entries'];
        }

        return 1;
    }

    /**
     * @param $data
     * @return mixed
     */
    private function transformToModel($data)
    {
        return $this->convertDateTimes($data)->map(function ($data) {
//            if (array_has($data, 'id')) {
//                $data['external_id'] = $data['id'];
//                unset($data['id']);
//            }

            $transformerName = '\Naoray\LaravelHarvest\Transformer\\'.class_basename($this->model);

            return (new $transformerName)->transformModelAttributes($data);
        });
    }

    /**
     * Get results key.
     */
    private function getResultsKey()
    {
        return snake_case(
            str_plural(
                class_basename($this->model)
            )
        );
    }
}