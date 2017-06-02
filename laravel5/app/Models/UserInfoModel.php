<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfoModel extends Model
{
    protected $connection = 'mysql';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'userinfo';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable, which means to make method create() enable.
     *
     * @var array
     */
    protected $fillable = array('userName', 'loginPassword');

}
