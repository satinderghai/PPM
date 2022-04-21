<?php
/*
* TokenRegistryModel.php - Model file
*
* This file is part of the Token Registry component.
*-----------------------------------------------------------------------------*/

namespace App\Exp\Services\YesTokenAuth\TokenRegistry\Models;

use App\Exp\Base\BaseModel;

class TokenRegistryModel extends BaseModel
{

    /**
     * The custom primary key.
     *
     * @var string
     *----------------------------------------------------------------------- */

    protected $primaryKey = '_uid';

    /**
     * @var  string $table - The database table used by the model.
     */
    protected $table = "token_registry";

    /**
     * The generate UID or not
     *
     * @var string
     *----------------------------------------------------------------------- */
    
    protected $isGenerateUID = false;

    /**
     * Does it has has Entity Ownership ID
     *
     * @var bool
     *----------------------------------------------------------------------- */
    protected $hasEoId = false;    
  
    /**
     * @var  array $casts - The attributes that should be casted to native types.
     */
    protected $casts = [
    	'_uid' =>  'string', 
        "status" => "integer",
        "user_authorities__id" => "integer",
    ];

    /**
     * @var  array $fillable - The attributes that are mass assignable.
     */
    protected $fillable = [
    	'_uid', 
    	'jwt_token', 
    	'user_authorities__id',
    	'expiry_at'
    ];

    
}
