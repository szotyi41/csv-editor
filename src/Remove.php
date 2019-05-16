<?php 

class Remove extends Query
{

    public function __construct($data)
    {
        parent::__construct($data);
    }

    public function remove() {        
        $this->result = [];
        $this->log('Removing');
        
        $this->exec(function() {
            return [];
        });
		
        $this->data->setData($this->result);

        return $this;
    }

}