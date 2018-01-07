<?php

namespace Mado\QueryBundle\Queries\Objects;

use Mado\QueryBundle\Services\StringParser;
use Mado\QueryBundle\Dictionary;

/** @since class available since release 2.2.1 */
final class FilterObject
{
    const FIELD = 0;

    const OPERATOR = 1;

    private $rawFilter;

    private $fieldName;

    private $operatorName;

    private function __construct(string $rawFilter)
    {
        $this->setRawFilter($rawFilter);

        $explodedRawFilter = explode('|', $rawFilter);
        if (!isset($explodedRawFilter[self::OPERATOR])) {
            $explodedRawFilter[self::OPERATOR] = Dictionary::DEFAULT_OPERATOR;
        }

        $fieldName = $explodedRawFilter[self::FIELD];
        $parser = new StringParser();
        $this->fieldName = $parser->camelize($fieldName);

        $this->operatorName = $explodedRawFilter[self::OPERATOR];
    }

    public static function fromRawFilter(string $filter) : FilterObject
    {
        return new self($filter);
    }

    public function getFieldName() : string
    {
        return $this->fieldName;
    }

    public function getOperatorName() : string
    {
        return $this->operatorName;
    }

    public function isListType() : bool
    {
        return $this->getOperatorName() == 'list'
            || $this->getOperatorName() == 'nlist';
    }

    public function isFieldEqualityType()
    {
        return $this->getOperatorName() == 'field_eq';
    }

    public function getOperatorMeta() : string
    {
        return Dictionary::getOperators()[$this->getOperatorName()]['meta'];
    }

    public function haveOperatorSubstitutionPattern() : bool
    {
        $operator = Dictionary::getOperators()[$this->getOperatorName()];

        return isset($operator['substitution_pattern']);
    }

    public function getOperatorsSubstitutionPattern() : string
    {
        $operator = Dictionary::getOperators()[$this->getOperatorName()];

        return $operator['substitution_pattern'];
    }

    public function setRawFilter(string $rawFilter)
    {
        $this->rawFilter = $rawFilter;
    }

    public function getRawFilter() : string
    {
        return $this->rawFilter;
    }

    public function getOperator()
    {
        return $this->operatorName;
    }
}