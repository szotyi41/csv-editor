<?php 

class Duplicate extends Query
{

    public function __construct($data)
    {
        parent::__construct($data);
    }

    public function duplicate() {        
        $this->result = [];
        $this->log('Run duplicating');

        $this->exec(function($row) {
            $this->result[] = $row;
            return $row;
        });
        
        $this->data->setData($this->result);
        
        return $this;
    }
}