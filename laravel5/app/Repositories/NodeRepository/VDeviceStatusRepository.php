<?php

/**
 * This file is created by hanzhiwei using _example_template_XXXRepository.php
 *
 * @Copyright
 *      @user: hanzhiwei
 *      @Email: bigosprite@163.com
 *      @GitHub: https://github.com/BigoSprite
 */

namespace App\Repositories\NodeRepository;
use App\Repositories\Eloquent\AbstractRepository;
use Illuminate\Container\Container as App;

/** Concrete Repository of AbstractRepository */
class VDeviceStatusRepository extends AbstractRepository
{
    /**
     * Constructor.
     *
     * @param App $app
     * @NOTE you HAVE TO implement constructor and call parent constructor like follow.
     */
    public function __construct(App $app)
    {
        /** Don't forget to call parent constructor. */
        parent::__construct($app);
    }


    /**
     * @return string
     */
    function model()
    {
        /** Don't forget to CHANGE the namespace according to the right Model location! */
        return 'App\Models\Node\VDeviceStatusModel';
    }
}