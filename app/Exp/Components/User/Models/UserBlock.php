<?php

namespace App\Exp\Components\User\Models;

use App\Exp\Base\BaseModel;

class UserBlock extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
	protected $table = 'user_block_users';

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [];
}
