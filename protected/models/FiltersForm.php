<?php
/**
 * Filterform to use filters in combination with CArrayDataProvider and CGridView
 */
class FiltersForm extends CFormModel
{
    public $filters = array();
    public $fullMatch=false;
 
    /**
     * Override magic getter for filters
     */
    public function __get($name)
    {
        if(!array_key_exists($name, $this->filters))
            $this->filters[$name] = null;
        return $this->filters[$name];
    }
 
    /**
     * Filter input array by key value pairs
     * @param array $data rawData
     * @return array filtered data array
     */
    public function filter(array $data)
    {
        foreach($data AS $rowIndex => $row) {
            foreach($this->filters AS $key => $value) {
                // unset if filter is set, but doesn't match
                if(array_key_exists($key, $row) AND !empty($value)) {
                    if($this->fullMatch)
                    {
                        //full match - return one match only. Ex 77=77
                        if($row[$key] != $value)
                            unset($data[$rowIndex]);
                    }
                    else
                    {
                        //partial match. Ex 77=77=177=377 e.t.c.
                        if(stripos($row[$key], $value) === false)
                            unset($data[$rowIndex]);
                    }
                }
            }
        }
        return $data;
    }
}