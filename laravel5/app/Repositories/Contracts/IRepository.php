<?php

namespace App\Repositories\Contracts;

interface IRepository
{
    public function isFieldExist($field = 'id', $value = '0');
    public function all($columns = array('*'));
    public function find($id, $columns = array('*'));
    public function findBy($field, $value, $columns = array('*'));
//    public function create(array $data, $primaryKey = 'id', $value = "0");
    public function create_Ex(array $data, $primaryKey = 'id', $value = "0");
//    public function update(array $data, $field, $value);
    public function update_Ex(array $data, $field, $value);
}