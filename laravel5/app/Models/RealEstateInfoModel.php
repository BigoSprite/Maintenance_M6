<?php

/**
 * This file is created by hanzhiwei using _example_template_XXXModel.php
 *
 * @Copyright
 *      @user: hanzhiwei
 *      @Email: bigosprite@163.com
 *      @GitHub: https://github.com/BigoSprite
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RealEstateInfoModel extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql';
    /**
     * @var string
     */
    protected $table = 'realestateinfo';
    /**
     * @var bool
     */
    public $timestamps = false;


    /**
     * The attributes that are mass assignable, which means to make method create() enable.
     *
     * @NOTE 如果想使用Mass Assignable，那么需要"显式"设置$fillable，或$guarded置为空数组（全部字段均可批量赋值）
     *       且二者只可设置其一，切记！
     *
     * @var array
     */
    protected $guarded = [];

}
