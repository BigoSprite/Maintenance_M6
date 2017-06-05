<?php

/**
 * This file is created by hanzhiwei using _example_template_XXXModel.php
 *
 * @Copyright
 *      @user: hanzhiwei
 *      @Email: bigosprite@163.com
 *      @GitHub: https://github.com/BigoSprite
 */

namespace App\Models\Client;
use App\Http\Controllers\Api\RealEstateInfoApi;
use Illuminate\Database\Eloquent\Model;

/** Concrete Model extents Model */
class DistributionRoomInfoModel extends Model
{
    /**
     * The connection name for the model.
     *
     * @var string
     * @NOTE Remote mysql connection. Configure it in constructor.
     */
    protected $connection;

    public function __construct(array $attributes = [])
    {
        $this->connection = 'mysql_client_jinyehotel';

        parent::__construct($attributes);
    }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'distribution_room_info';

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


    /**
     * @param $dbName
     * @return array map | null
     */
    private function __getRemoteConnection($dbName)
    {
        $arr = RealEstateInfoApi::create()->getRealEstateDBInfo($dbName);
        $map = $arr['data'];

        return $map;
    }

}