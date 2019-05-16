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
        $this->log('Run date');

        $this->exec(function($row) {

            if ($this->isDate($row[$this->getfield])) {
                $date = date($this->format, strtotime($row[$this->getfield] . $this->datestring));
            } else {
                $date = date($this->format, strtotime($this->datestring));
            }

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