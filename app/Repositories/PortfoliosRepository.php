<?php

namespace Corp\Repositories;

use Corp\Portfolio;
use Config;

class PortfoliosRepository extends Repository {

	public function __construct(Portfolio $portfolio)
    {
    	$this->model = $portfolio;
    }

    public function one($alias, $attr=[])
    {
    	$portfolio = parent::one($alias, $attr);

    	return $portfolio;
    }

    public function get($select = '*', $take = false , $pagination = false, $where=false)
	{
		$builder = $this->model->select($select);

		if($take) {
			$builder->take($take);
		}

		if ($where) {
			$builder->where($where[0], $where[1]);
		}

		if ($pagination) {
			return $this->check_and_decode($builder->paginate(Config::get('settings.portfolios_paginate')));
		}

		return $this->check_and_decode($builder->get());
	}

}