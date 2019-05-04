<?php 

class Data
{

	public $data;
	public $file;
    public $header;
    public $types;

	public function __construct($file)
	{
		$this->file = $file;
	}

	public function import()
	{
		$fp = fopen($this->file, 'r');
		$this->header = fgetcsv($fp);
		$data = array();
		while ($row = fgetcsv($fp)) {
			$arr = array();
			foreach ($this->header as $i => $col) {
				$arr[] = $row[$i];
			}
			$data[] = $arr;
		}
		$this->data = $data;
    }

    public function setColumn($id, $column) 
    {
        $this->header[$id] = $column;
    }

    public function getCount() 
    {
        return count($this->data);
    }
    
    public function types($types) 
    {
        $this->types = $types;
    }

	public function getColumnIndex($field) 
	{
		foreach($this->header as $i => $column) {
			if($column === $field) {
				return $i;
			}
		}
	}

	public function getColumnName($field) {		
		foreach($this->header as $i => $column) {
			if($column === $field) {
				return $column;
			}
		}
	}

	public function getData() 
	{
		return $this->data;
	}

	public function setData($data) 
	{
		$this->data = $data;
	}
	
	public function table() 
	{
		echo '<table>';
		echo '<tr>';
		foreach($this->header as $column) {
			echo '<th>'.$column.'</th>';
		}
		echo '</tr>';
		foreach($this->data as $rows) {
			echo '<tr>';
			foreach($rows as $row) {
				echo '<td>'.$row.'</td>';
			}
			echo '</tr>';
		}
		echo '</table>';
	}
}