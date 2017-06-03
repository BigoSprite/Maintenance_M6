<?php

/**
 * This file is created by hanzhiwei using _example_template_XXXModel.php
 *
 * @Copyright
 *      @user: hanzhiwei
 *      @Email: bigosprite@163.com
 *      @GitHub: https://github.com/BigoSprite
 */

namespace App\Models\Node;
use Illuminate\Database\Eloquent\Model;

/** Concrete Model extents Model */
class Real_Estate_Info_Model extends Model
{
    /**
     * The connection name for the model.
     *
     * @var string
     * @NOTE You can change the connect by changing the value of $connection.
     */
    protected $connection = 'mysql_cloud_node';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'real_estate_info';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     *
     * @NOTE 如果想使用Mass Assignable，那么需要"显式"设置，或$guarded置为空数组（全部字段均可批量赋值）
     * 且二者只可设置其一，切记！它们决定create()是否可用！
     */
    protected $guarded = [];

}