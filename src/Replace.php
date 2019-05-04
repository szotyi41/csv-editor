<?php 

class Replace extends Query
{
    public $field;
    public $from;
    public $to;

    public function __construct($data)
    {
        parent::__construct($data);
    }

    public function replace(string $from, string $to, array $params = []) 
    {
        $this->result = [];
        $this->from = $from;
        $this->to = $to;
        $this->params = $params;

        $this->exec(function($row) {
            $row[$this->setfield] = str_replace($this->from, vsprintf($this->to, $this->getparams($row)), $row[$this->getfield]);
            return $row;
        });
		
		$this->data->setData($this->result);
    }
    
    public function set(string $to, array $params = []) 
    {
        $this->result = [];
        $this->to = $to;
        $this->params = $params;

        $this->exec(function($row) {
            $row[$this->setfield] = vsprintf($this->to, $this->getparams($row));
            return $row;
        });
		
		$this->data->setData($this->result);
    }

    public function substr(string $from, string $to) 
    {
        $this->result = [];
        $this->from = $from;
        $this->to = $to;

        $this->exec(function($row) {
            $row[$this->setfield] = substr($row[$this->getfield], $this->from, $this->to);
            return $row;
        });
		
		$this->data->setData($this->result);
    }


    private function getparams($row) {
        $params = [];
        foreach ($this->params as $param) {
            if (is_numeric($param)) {
                $params[] = $row[$param];
            } else {
                $params[] = $param;
            }
        }
        return $params;
    }
}