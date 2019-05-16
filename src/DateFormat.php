<?php

class DateFormat extends Query
{
    public $format;

    public function __construct($data)
    {
        parent::__construct($data);
    }

    public function format(string $format) {
        $this->format = $format;

        return $this;
    }

	public function date(string $datestring) {
        $this->result = [];
        $this->datestring = $datestring;
        echo 'Run date<br>';
        $this->exec(function($row) {
            $date = $this->isDate($row[$this->getfield]) ? date($this->format, strtotime($row[$this->getfield].$this->datestring)) : date($this->format, strtotime($this->datestring));
            $row[$this->setfield] = $date;
            return $row;
        });
        $this->data->setData($this->result);
        
        return $this;
    }

    private function isDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
}