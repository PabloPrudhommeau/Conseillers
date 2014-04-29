<?php

class TableComponent extends BaseComponent {

	private $data_header = array();
	private $data_row = array();
	
	public function setDataRow($arr = array()) {
		$this->data_row = $arr;
	}

	public function setDataHeader($arr = array()) {
		$this->data_header = $arr;
	}

	public function addRow() {

	}

	public function addHeader() {

	}

	public function getHeader() {
		return $this->data_header;
	}

	public function getRow() {
		return $this->data_row;
	}

	public function createView($template = 'table_default') {
		$this->table_header = $this->data_header;
		$this->table_data = $this->data_row;
		return parent::createView($template);
	}

}

?>