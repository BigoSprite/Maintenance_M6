<?php
/**
 * Created by PhpStorm.
 * User: fm
 * Date: 2017/5/27
 * Time: 21:12
 */

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\IRepository;
use Illuminate\Container\Container as App;

abstract class AbstractRepository implements IRepository
{
    private $app;
    protected $model;

    public function __construct(App $app) {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    abstract function model();

    private function makeModel() {
        $model = $this->app->make($this->model());

        //if (!$model instanceof Model)
            //throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        return $this->model = $model;
    }


    /**
     * @function if the field of table exists, using for the primary key too.
     *
     * @param string $field. It maybe a primary key.
     * @param string $value
     * @return bool
     */
    public function isFieldExist($field = 'id', $value = '0')
    {
        $isExist = true;

        $model = $this->model->where($field,'=', $value)->first([$field]);
        if($model == null){
            $isExist = false;
        }

        return $isExist;
    }


    /**
     * @function Get all of the models from the database.
     *
     * @param array $columns
     * @return mixed
     *
     * @NOTE the return value format : [stdClass, ...]
     */
    public function all($columns = array('*'))
    {
        return $this->model->get($columns);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     *
     * @NOTE MAKE SURE that you needn't a $primaryKey in corresponding data model
     *       and you should TABLE has a field of 'id' which is the primary key.
     */
    public function find($id, $columns = array('*'))
    {
        return $this->model->find($id, $columns);
    }

    /**
     * @function Get a Model
     *
     * @param $field table field
     * @param $value: the value of field
     * @param array $columns: field array you want to get
     *
     * @return array: one line data with format MAP(key：field，value:the value of field)
     */
    public function findBy($field, $value, $columns = array('*'))
    {
        return $this->model->where($field, '=', $value)->first($columns);
    }


    /**
     * @function get some models based on field.
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function find2NBy($field, $value, $columns = array('*'))
    {
        return $this->model->where($field, '=', $value)->get($columns);
    }



//    /**
//     * @function Mass Assignment with Exception throw, if the primary key has been existed.
//     *
//     * @param array $data: format such as ['fieldName'=>'value', 'anotherFieldName'=>'value2', ...]
//     * @param string $primaryKey
//     * @param string $value: the value of $primaryKey
//     *
//     * @return \Illuminate\Http\JsonResponse
//     *
//     * @NOTE MAKE SURE that you have configured "fillable" array in corresponding data model.
//     */
//    public function create(array $data, $primaryKey = 'id', $value = '0')
//    {
//        // data exists, Exception throw
//        $target = $this->model->where($primaryKey, '=', $value)->first([$primaryKey]);
//        if($target != null){
//            return response()->json(['status'=>'fail', 'isExist'=>'true'], 200);
//        }
//
//        // data doesn't exist; insert it right now.
//        $m = $this->model::create($data);// use the static method create of Model
//        if($m != null){
//            return response()->json(['status'=>'success', 'isExist'=>'false'], 200);
//        }else{
//            return response()->json(['status'=>'fail', 'isExist'=>'false'], 200);
//        }
//    }

    /**
     * @function Mass Assignment with Exception throw, if the primary key has been existed.
     *
     * @param array $data: format such as ['fieldName'=>'value', 'anotherFieldName'=>'value2', ...]
     * @param string $primaryKey
     * @param string $value: the value of $primaryKey
     *
     * @return array ['status'=>'', 'isExist'=>'']
     *
     * @NOTE MAKE SURE that you have configured "fillable" array in corresponding data model.
     */
    public function create_Ex(array $data, $primaryKey = 'id', $value = "0")
    {
        // data exists, Exception throw
//        $target = $this->model->where($primaryKey, '=', $value);
//        if($target != null){
//            return ['status'=>'fail', 'isExist'=>'true'];
//        }

        $isExist = $this->isFieldExist($primaryKey, $value);
        if($isExist){
            return ['status'=>'fail', 'isExist'=>'true'];
        }

        // data doesn't exist; insert it right now.
        $m = $this->model::create($data);// use the static method create of Model
        if($m != null){
            return ['status'=>'success', 'isExist'=>'false'];
        }else{
            return ['status'=>'fail', 'isExist'=>'false'];
        }
    }


//    /**
//     * @function Update Model
//     * @param array $data: format such as ['fieldName'=>'value', 'anotherFieldName'=>'value2', ...]
//     *
//     * @param $field
//     * @param $value
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function update(array $data, $field, $value) {
//
//        $target = $this->model->where($field, '=', $value);
//
//        if($target == null){
//            return response()->json(['status'=>'fail', 'isExist'=>'false'], 200);
//        }else{
//            $affected  = $target->update($data);
//            if($affected > 0){
//                return response()->json(['status'=>'success', 'isExist'=>'true'], 200);
//            }else{
//                return response()->json(['status'=>'fail', 'isExist'=>'true'], 200);
//            }
//        }
//    }

    /**
     * @function Update Model
     * @param array $data: format such as ['fieldName'=>'value', 'anotherFieldName'=>'value2', ...]
     *
     * @param $field
     * @param $value
     * @return array
     */
    public function update_Ex(array $data, $field, $value)
    {
        $model = $this->model->where($field, '=', $value);

        if($model->first([$field]) == null){
            return ['status'=>'fail', 'isExist'=>'false'];
        }

        $affected  = $model->update($data);
        if($affected > 0){
            return ['status'=>'success', 'isExist'=>'true'];
        }else{
            return ['status'=>'fail', 'isExist'=>'true'];
        }
    }

}