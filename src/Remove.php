<?php 

class Remove extends Query
{

    public function __construct($data)
    {
        parent::__construct($data);
    }

    public function remove() {        
        $this->result = [];

        echo 'Removing<br>';
        $this->exec(function($row) {
            return [];
        });
		
        $this->data->setData($this->result);

        return $this;
    }

}