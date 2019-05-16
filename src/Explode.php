<?php

class Explode extends Query
{
    public $setfields;
    public $delimiter;
    public $columns;

    public function __construct($data)
    {
        parent::__construct($data);
    }

    public function setColumns(array $columns) {
        $this->setfields = $columns;

        return $this;
    }

	public function explode(string $delimiter) {
        $this->result = [];
        $this->delimiter = $delimiter;
        echo 'Run exploding with delimiter: ' . $delimiter . ' <br>';
        $this->exec(function($row) {
            $exploded = explode($this->delimiter, $row[$this->getfield]);
            for($i = 0; $i < min(count($exploded), count($this->setfields)); $i++) {
                $row[$this->setfields[$i]] = $exploded[$i];
            }
            return $row;
        });
        $this->data->setData($this->result);
        
        return $this;
    }
}