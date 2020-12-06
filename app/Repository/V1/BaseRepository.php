<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BaseRepository
 *
 * @author carlosfernandes
 */

namespace App\Repository\V1;

class BaseRepository
{

    protected $obj;

    protected function __construct(object $obj)
    {
        $this->obj = $obj;
    }

    public function all(): object
    {
        return $this->obj->all();
    }

    public function find(int $id): object
    {
        return $this->obj->find($id);
    }

    public function findByColumn(string $column, $value): object
    {
        return $this->obj->where($column, $value)->get();
    }

    public function save(array $attributes): object
    {
        return $this->obj->create($attributes);
    }

    public function update(int $id, array $attributes): object
    {
        return $this->obj->find($id)->update($attributes);
    }
    
    public function delete(int $id): bool
    {
        return $this->obj->destroy($id);
    }

}
