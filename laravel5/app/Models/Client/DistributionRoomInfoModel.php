<?php
/**
 * This file is created by hanzhiwei using _example_template_remote_XXXModel.php
 *
 * @Copyright
 *      @user: hanzhiwei
 *      @Email: bigosprite@163.com
 *      @GitHub: https://github.com/BigoSprite
 */

namespace App\Models\Client;
use Illuminate\Database\Eloquent\Model;

/** Concrete Model extents Model */
class DistributionRoomInfoModel extends Model
{
    /**
     * The connection name for the model.
     *
     * @var string
     * @NOTE 'mysql_client'corresponding to config/database.php/connections['mysql_client'].
     *       If you wanna configure model's connection at runtime, you have to assign $connection to 'mysql_client'.
     */
    protected $connection = 'mysql_client';

    /**
     * The table associated with the model.
     *
     * @var string
     * @NOTE Don't forget to change $table's value corresponding to the right table!
     */
    protected $table = 'distribution_room_info';

    protected $primaryKey = 'serialId';

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
    protected $guarded = ['serialId', 'registerDate'];

}