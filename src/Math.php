<?php 

class Math extends Query
{
    public $equation;
    public $decimals;
    public $decimalpoint;
    public $separator;
    public $prefix;
    public $suffix;
    public $min;
    public $max = 999999999999999;
    public $round;

    public function __construct($data)
    {
        parent::__construct($data);
    }

    public function calc(string $equation, array $params = []) {
        $this->result = [];
        $this->equation = $equation;
        $this->params = $params;
        $this->log('Run math');

		$this->exec(function($row) {
            $equation = vsprintf($this->equation, $this->getParams($row));
            $equation = max(min(eval('return '.$equation.';'), $this->max), $this->min);
            $equation = number_format($equation, $this->decimals, $this->decimalpoint, $this->separator);
            $equation = $this->round === true ? round($equation, $this->roundprecision, $this->roundmode) : $equation;
            $row[$this->setfield] = $this->prefix . $equation . $this->suffix;
            
            return $row;
        });
        
		$this->data->setData($this->result);
    }

    public function format(int $decimals, string $decimalpoint, string $separator) {
        $this->decimals = $decimals;
        $this->decimalpoint = $decimalpoint;
        $this->separator = $separator;

        return $this;
    }

    public function prefix(string $prefix) {
        $this->prefix = $prefix;

        return $this;
    }

    public function suffix(string $suffix) {
        $this->suffix = $suffix;

        return $this;
    }

    public function min(int $min) {
        $this->min = $min;

        return $this;
    }

    public function max(int $max) {
        $this->max = $max;

        return $this;
    }

    public function round($precision = 0, $mode = PHP_ROUND_HALF_UP) {
        $this->round = true;
        $this->roundprecision = $precision;
        $this->roundmode = $mode;

        return $this;
    }

    private function toNumber($value) {
        return (float) preg_replace('/[^0-9.]/', '', $value);
    }

    private function getParams($row) {
        $params = [];
        foreach ($this->params as $param) {
            if (is_numeric($param)) {
                $params[] = $this->toNumber($row[$param]);
            } else {
                $params[] = $param;
            }
        }
        return $params;
    }
}