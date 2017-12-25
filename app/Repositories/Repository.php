<?php 

namespace Corp\Repositories;

use Config;


abstract class Repository {

	//Объект модели получения определенных данных
	protected $model = false;

	public function get($select = '*', $take = false , $pagination = false)
	{
		$builder = $this->model->select($select);

		if($take) {
			$builder->take($take);
		}

		if ($pagination) {
			return $this->check_and_decode($builder->paginate(Config::get('settings.paginate')));
		}

		return $this->check_and_decode($builder->get());
	}
	

	public function check_and_decode($result)
	{
		if ($result->isEmpty()) {
			return false;
		}

		$result->transform(function ($item, $key)
		{
			if (is_string($item->img) && is_object(json_decode($item->img)) && json_last_error() == JSON_ERROR_NONE) {
				$item->img = json_decode($item->img);
			}
			 
			return $item;
		});
		
		return $result;
	}
}