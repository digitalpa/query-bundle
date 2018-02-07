<?php

namespace Mado\QueryBundle\Objects;

class Filter
{
    private $rawFilter;

    private $ids;

    private $operator;

    public static function box(array $params)
    {
        $rawIds    = $params['ids'];
        $operator  = key($rawIds);
        $ids       = join(',', current($rawIds));
        $rawFilter = $params['path'] . '.id|' . $operator;

        return new self([
            'raw_filter' => $rawFilter,
            'ids'        => $ids,
            'operator'   => $operator,
        ]);
    }

    private function __construct(array $params)
    {
        $this->rawFilter = $params['raw_filter'];
        $this->ids       = $params['ids'];
        $this->operator  = $params['operator'];
    }

    public function getRawFilter()
    {
        return $this->rawFilter;
    }

    public function getIds()
    {
        return $this->ids;
    }

    public function getOperator()
    {
        return $this->operator;
    }
}
