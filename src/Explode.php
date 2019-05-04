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

    public function setfields(array $columns) {
        $this->setfields = $columns;
    }

	public function explode(string $delimiter) {
        $this->result = [];
        $this->delimiter = $delimiter;

        $this->exec(function($row) {
            $exploded = explode($this->delimiter, $row[$this->getfield]);
            for($i = 0; $i < min(count($exploded), count($this->setfields)); $i++) {
                $row[$this->setfields[$i]] = $exploded[$i];
            }
            return $row;
        });
		
		$this->data->setData($this->result);
    }
}