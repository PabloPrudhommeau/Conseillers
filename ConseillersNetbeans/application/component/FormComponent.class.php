<?php

class FormComponent extends BaseComponent {

	private $original_fields = array();
	private $request = array();
	private $syntax_errors = array();
	private $requested = false;

	public function init($method, $action) {
		$this->method = $method;
		$this->action = $action;
		return $this;
	}

	public function addField($type, $label, $name, $data = array()) {
		$this->original_fields[$name]['type'] = $type;
		$this->original_fields[$name]['label'] = $label;
		$this->original_fields[$name]['name'] = $name;
		$this->original_fields[$name]['data'] = $data;
		$this->original_fields[$name]['rules'] = array();
		return $this;
	}

	public function addFieldRule($name, $type, $value, $bool = true) {
		$this->original_fields[$name]['rules'][] = array('name' => $name, 'type' => $type, 'value' => $value, 'bool' => $bool_val);
		return $this;
	}

	public function getFieldValue($name) {
		return $this->request[$name];
	}

	private function addSyntaxError($fieldName, $reason) {
		$this->syntax_errors[] = array('fieldName' => $fieldName, 'reason' => $reason);
	}

	public function isValid() {
		if(!empty($_POST)){
			$this->requested = true;
			foreach ($_POST as $key => $val) {
				$this->request[$key] = $val;
			}
			foreach ($this->original_fields as $key => $field) {
				foreach ($field['rules'] as $rule) {
					$fieldValue = $this->getFieldValue($key);
					if ($rule['type'] == 'regex') {
						$condition = preg_match($rule['value'], $fieldValue);
						if (!$rule['bool']) {
							$condition = !$condition;
						}
						if (!$condition) {
							$this->addSyntaxError($val['name'], 'Le champ ' . $val['name'] . ' est syntaxiquement mauvais');
						}
					} elseif ($rule['type'] == 'operator') {
						switch ($rule['value']) {
							case 'empty':
								$condition = empty($fieldValue);

								if (!$rule['bool']) {
									$condition = !$condition;
								}
								if (!$condition) {
									$this->addSyntaxError($rule['name'], 'Le champ ' . $rule['name'] . ' ne doit pas être vide');
								}
								break;
							default:
								break;
						}
					}
				}

				if (empty($this->syntax_errors)) {
					return true;
				}
			}
		}
		return false;
	}

	public function createView($template = 'form_default') {
		$temp_fields = array();
		foreach ($this->original_fields as $key => $val) {
			$label = '<label for = "' . $this->original_fields[$key]['name'] . '">' . $this->original_fields[$key]['label'] . '</label>';
			$field = '<input type = "' . $this->original_fields[$key]['type'] . '" name = "' . $this->original_fields[$key]['name'] . '" placeholder = "' . strtolower($this->original_fields[$key]['label']) . '" value = "' . $this->getFieldValue($this->original_fields[$key]['name']) . '" id = "' . $this->original_fields[$key]['name'] . '"/>';
			array_push($temp_fields, array('label' => $label, 'field' => $field));
		}
		$this->fields = $temp_fields;
		if($this->requested){
			foreach($this->syntax_errors as $val){
				$this->errors .= 'Erreur au niveau du champ <b>'.$val['fieldName'].'</b> : '.$val['reason'].'<br/>';
			}
		}
		return parent::createView($template);
	}

}
