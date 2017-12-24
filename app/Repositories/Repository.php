<?php 

namespace Corp\Repositories;

use Config;

abstract class Repository {

	//Объект модели получения определенных данных
	protected $model = false;

	public function get()
	{
		$builder = $this->model->select('*');
		return $builder->get();
	}
}