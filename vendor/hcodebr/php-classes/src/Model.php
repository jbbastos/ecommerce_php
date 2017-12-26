<?php

namespace Hcode;

/* Essa classe foi criada para otimizar a criação de getters e setters nas classes */
class Model
{
	private $values = [];
	
	// Monta os métodos get e set
	public function __call($name, $args)
	{
		$method = substr($name, 0, 3);
		$fieldname = substr($name, 3, strlen($name));
		
		//var_dump($method, $fieldname);
		//exit;
		
		switch($method)
		{
			case "get":
				return (isset($this->values[$fieldname])) ? $this->values[$fieldname] : NULL;
				break;
			case "set":
				$this->values[$fieldname] = $args[0];
		}
	}
	
	// Retorna um array com todos os campos do banco e os valores correspondentes
	public function setData($data = array())
	{
		foreach($data as $key => $value)
		{
			$this->{"set".$key}($value);
		}
	}
	
	public function getValues()
	{
		return $this->values;
	}
}

?>