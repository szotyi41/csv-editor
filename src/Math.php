<?php 

class Math extends Query
{
    public $calc;
    public $equation;
    public $decimals;
    public $decimalpoint;
    public $separator;
    public $prefix;
    public $suffix;
    public $min;
    public $max = 999999999999999;

    public function __construct($data)
    {
        parent::__construct($data);
    }

    public function calc(string $equation, array $params = []) {

        $this->result = [];
        $this->equation = $equation;
        $this->params = $params;
		$this->exec(function($row) {
            $equation = vsprintf($this->equation, $this->getparams($row));
            $this->calc = max(min(eval('return '.$equation.';'), $this->max), $this->min);
            $row[$this->setfield] = $this->prefix . number_format($this->calc, $this->decimals, $this->decimalpoint, $this->separator) . $this->suffix;
            return $row;
		});
		$this->data->setData($this->result);
    }

    public function format(int $decimals, string $decimalpoint, string $separator) {
        $this->decimals = $decimals;
        $this->decimalpoint = $decimalpoint;
        $this->separator = $separator;
    }

    public function prefix(string $prefix) {
        $this->prefix = $prefix;
    }

    public function suffix(string $suffix) {
        $this->suffix = $suffix;
    }

    public function min(int $min) {
        $this->min = $min;
    }

    public function max(int $max) {
        $this->max = $max;
    }

    private function toNumber($value) {
        return (float) preg_replace('/[^0-9.]/', '', $value);
    }

    private function getparams($row) {
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