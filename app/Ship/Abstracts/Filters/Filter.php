<?php
namespace App\Ship\Abstracts\Filters;


abstract class Filter
{
    protected $builder;
    protected $request;
    protected $resource;

    public function __construct($builder, $request)
    {
        $this->builder = $builder;
        $this->request = $request;
    }

    /**
     * Applies filters to the query builder.
     *
     * For each filter that has a corresponding method in this class,
     * that is not in the base class, the method will be called with the filter value.
     *
     */
    public function apply()
    {
        $baseClassMethods = get_class_methods(self::class);

        foreach ($this->filters() ?? [] as $filter => $value) {
            if (method_exists($this, $filter) && !in_array($filter, $baseClassMethods)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    protected function filters()
    {
        return $this->request->all();
    }
}
