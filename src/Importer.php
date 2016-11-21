<?php namespace Buchin\Jl;
use RedBeanPHP\R;
/**
* Package
*/
class Importer
{
	private $source;

	public function import($source, $dsn = null, $user = null, $password = null)
	{
		if(!$this->setSource($source)){
			return false;
		}
		if(!$this->setR($dsn, $user, $password)){
			return false;
		}

		$file = fopen($this->source, "r");
		while(($line = fgets($file)) !== false){
			$record = json_decode($line, true);

			$record = $this->flatten($record);

			$bean = R::dispense($record['_type']);

			foreach ($record as $key => $value) {
				if($key[0] !== '_'){
					$bean->{$key} = $value;
				}
			}

			R::store($bean);
		}

		fclose($file);
		R::close();

		return true;
	}

	public function flatten($record)
	{
		foreach ($record as $key => $value) {
			$record[$key] = is_array($value) ? $value[0] : $value;
		}

		return $record;	
	}

	public function setSource($source)
	{
		if(file_exists($source)){
			$this->source = $source;
			return true;
		}
		else{
			return false;
		}
	}

	public function setR($dsn, $user, $password)
	{
		if($dsn == null && $user == null && $password == null){
			return R::setup();
		}

		return R::setup($dsn, $user, $password);
	}
}