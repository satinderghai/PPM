<?php

namespace App\Exp\Components\User\Models;

use App\Exp\Base\BaseModel;

class UserEncounter extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
	protected $table = 'user_encounters';

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [];
}
