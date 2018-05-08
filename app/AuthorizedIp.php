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

    public static function create (\Illuminate\Http\Request $request, $wallet_id)
    {
        // check if exists already
        $aip = AuthorizedIp::where('wallet_id', $wallet_id)->where('ip', $request->ip())->first();
        if ($aip)
        {
            if ($aip->authorized)
                return false;
            else
                return $aip;;
        }
        else
        {
            $aip = new AuthorizedIp();
            $aip->ip = $request->ip();
            $aip->wallet_id = $wallet_id;
            $aip->authorized = false;
            $aip->rand_id = hash('sha256', $wallet_id . $request->ip() . time() . rand(0, 100000));
            $aip->expires = time() + 3600 * 2;
            $aip->info = $request->header('User-Agent');
            $aip->save();
            return $aip;
        }
    }

    public static function updateExpiration ($ip, $wallet_id)
    {
        $aip = AuthorizedIp::where('wallet_id', $wallet_id)->where('ip', $ip)->first();
        if ($aip)
        {
            $aip->expires = time() + 3600 * 24 * 30;
            $aip->save();
        }
    }

    public static function updateExpired ()
    {
        AuthorizedIp::where('expires', '<', time())->delete();
    }
}
