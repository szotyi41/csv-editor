<?php 

abstract class Query {

	public $data;
    public $result;
    public $getfield;
    public $setfield;

    private $wherefield;
    private $wherevalue;
    private $wheretype;

	public function __construct($data) {
		$this->data = $data;
	}

    public function where($field, $type, $value) {
        $this->wherefield = $field;
        $this->wheretype = $type;
        $this->wherevalue = $value;
    }

    public function getfield($field) {
        $this->getfield = $field;
    }

    public function setfield($field) {
        $this->setfield = $field;
    }

    public function exec($callback) {
        switch($this->wheretype) {
            case 'i':  $this->includes($callback); break;
            case '!i': $this->notincludes($callback); break;
            case 'e':  $this->equal($callback); break;
            case '!e': $this->notequal($callback); break;
            case '=':  $this->equalnumber($callback); break;
            case '!=': $this->notequalnumber($callback); break;
            case '>':  $this->largerthan($callback); break;
            case '<':  $this->smallerthan($callback); break;
            default :  $this->all($callback); break;
        }
    }

    private function all($callback) {        
        foreach ($this->data->getData() as $row) {
            $row = $callback($row);
            if(!empty($row)) $this->result[] = $row;
        }
    }

    private function includes($callback) {        
        foreach ($this->data->getData() as $row) {
            if (strstr($row[$this->wherefield], $this->wherevalue) !== false) {
                $row = $callback($row);
            }
            if(!empty($row)) $this->result[] = $row;
        }
    }

    private function notincludes($callback) {        
        foreach ($this->data->getData() as $row) {
            if (strstr($row[$this->wherefield], $this->wherevalue) === false) {
                $row = $callback($row);
            }
            if(!empty($row)) $this->result[] = $row;
        }
    }

    private function equal($callback) {        
        foreach ($this->data->getData() as $row) {
            if ($row[$this->wherefield] === $this->wherevalue) {
                $row = $callback($row);
            }
            if(!empty($row)) $this->result[] = $row;
        }
    }

    private function notequal($callback) {        
        foreach ($this->data->getData() as $row) {
            if ($row[$this->wherefield] !== $this->wherevalue) {
                $row = $callback($row);
            }
            if(!empty($row)) $this->result[] = $row;
        }
    }
    
    private function equalnumber($callback) {        
        foreach ($this->data->getData() as $row) {
            $number = $this->toNumber($row[$this->wherefield]);
            if ($number === $this->wherevalue) {
                $row = $callback($row);
            }
            if(!empty($row)) $this->result[] = $row;
        }
    }

    private function notequalnumber($callback) {        
        foreach ($this->data->getData() as $row) {
            $number = $this->toNumber($row[$this->wherefield]);
            if ($number !== $this->wherevalue) {
                $row = $callback($row);
            }
            if(!empty($row)) $this->result[] = $row;
        }
    }

    private function largerthan($callback) {        
        foreach ($this->data->getData() as $row) {
            $number = $this->toNumber($row[$this->wherefield]);
            if ($number > $this->wherevalue) {
                $row = $callback($row);
            }
            if(!empty($row)) $this->result[] = $row;
        }
    }

    private function smallerthan($callback) {        
        foreach ($this->data->getData() as $row) {
            $number = $this->toNumber($row[$this->wherefield]);
            if ($number < $this->wherevalue) {
                $row = $callback($row);
            }
            if(!empty($row)) $this->result[] = $row;
        }
    }

    private function toNumber($value) {
        return (float) preg_replace('/[^0-9.]/', '', $value);
    }
}