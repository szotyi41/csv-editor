<?php 

abstract class Query {

	public $data;
    public $result;
    public $getfield;
    public $setfield;
    public $query;

	public function __construct($data) {
        $this->data = $data;
        $this->query = [];
	}

    public function where(int $columnIndex, string $type, $value) {
        $query = new stdClass();
        $query->or = false;
        $query->columnIndex = $columnIndex;
        $query->type = $type;
        $query->value = $value;
        $this->query[] = $query;
        return $this;
    }

    public function orWhere(int $columnIndex, string $type, $value) {
        $query = new stdClass();
        $query->or = true;
        $query->columnIndex = $columnIndex;
        $query->type = $type;
        $query->value = $value;
        $this->query[] = $query;
        return $this;
    }

    public function getColumn($field) {
        $this->getfield = $field;
        return $this;
    }

    public function setColumn($field) {
        $this->setfield = $field;
        return $this;
    }

    public function exec($callback) {
        $count = 0;
        foreach ($this->data->getData() as $row) {

            $condition = new Condition();

            foreach ($this->query as $cond) {
                $condition->{$cond->type}($cond->or, $row[$cond->columnIndex], $cond->value);
            }

            if ($condition->get() === true) {
                $row = $callback($row);
                $count++;
            }

            if (!empty($row)) {
                $this->result[] = $row;
            }
        }

        $this->logResults($count);

    }

    private function logResults($count) {
        foreach ($this->query as $cond) {
            echo  (($cond->or) ? ' Or ' : ' And ') . ' where ' . $this->data->header[$cond->columnIndex] . ' ' . $cond->type . ' ' . $cond->value . '<br>';
        }

        echo 'Touched rows: ' . $count . '<br><br>';
    }
}