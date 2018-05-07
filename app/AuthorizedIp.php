<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuthorizedIp extends Model
{
    public $timestamps = false;
    protected $table = 'authorized_ips';

    public static function isAuthorized ($ip, $wallet_id)
    {
    	$found = AuthorizedIp::where('ip', $ip)->where('wallet_id', $wallet_id)->where('expires', '>', time())->where('authorized', true)->first();
    	if ($found)
    		return true;
    	return false;
    }
}
