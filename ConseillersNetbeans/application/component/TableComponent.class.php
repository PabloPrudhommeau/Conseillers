<?php

class TableComponent extends BaseComponent {

	private $data_header = array();
	private $data_row = array();
	
	public function addDataRow($data) {
		$this->data_row[] = $data;
	}

	public function addDataHeader($label) {
		$this->data_header = $label;
	}

	public function getHeader() {
		return $this->data_header;
	}

	public function getRow() {
		return $this->data_row;
	}

	public function createView($template = 'table_default') {
		$this->header = $this->data_header;
		$this->data = $this->data_row;
		return parent::createView($template);
	}

}

?>