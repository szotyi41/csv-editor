<?php 

class Condition {

    public $result = true;

    public function contains($or, $value, $statement) {
        $this->cond($or, (strstr($value, $statement) !== false));
    }

    public function notContains($or, $value, $statement) {
        $this->cond($or, (strstr($value, $statement) === false));
    }

    public function equal($or, $value, $statement) {
        $this->cond($or, ($value === $statement));
    }

    public function notEqual($or, $value, $statement) {
        $this->cond($or, ($value !== $statement));
    }

    public function largerThan($or, $value, $statement) {
        $this->cond($or, ($value > $this->toNumber($statement)));
    }

    public function smallerThan($or, $value, $statement) {
        $this->cond($or, ($value < $this->toNumber($statement)));
    }

    public function equalSmallerThan($or, $value, $statement) {
        $this->cond($or, ($value <= $this->toNumber($statement)));
    }

    public function equalLargerThan($or, $value, $statement) {
        $this->cond($or, ($value >= $this->toNumber($statement)));
    }

    public function cond($or, $condition) {
        if ($or === true) {
            return $this->result = $this->result || $condition;
        }
            
        return $this->result = $this->result && $condition;
    }

    private function toNumber($value) {
        return (float) preg_replace('/[^0-9.]/', '', $value);
    }

    public function get() {
        return $this->result;
    }

}