<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\AuthorizedIp;

class AuthorizedIpsController extends Controller
{
	public function error($msg)
	{
		// return error view
	}

	protected function checkAuthToken($token)
	{
		// get the authorization attempt
    	$attempt = AuthorizedIp::where('rand_id', $token)->where('authorized', false)->first();
    	if(!$attempt)
    		return false;
    	return $attempt;
	}

    public function auth (Request $request, $token)
    {
    	// get the authorization attempt
    	$attempt = $this->checkAuthToken($token);
    	if(!$attempt)
    		return $this->error('Invalid or expired token.');

    	$current = new \stdClass();
    	$current->ip = $request->ip();
    	$current->location = geoip($current->ip)['country'];

    	$attempt->location = geoip($attempt->ip)['country'];
    	// return view with both ips
    	return view('authip')->with(['status' => 'info', 'current' => $current, 'attempt' => $attempt]);
    }

    public function authApprove (Request $request, $token)
    {
    	// get the authorization attempt
    	$attempt = $this->checkAuthToken($token);
    	if(!$attempt)
    		return $this->error('Invalid or expired token.');

    	$attempt->expires = time() + 30 * 24 * 3600;
    	$attempt->authorized = true;
    	$attempt->save();

    	return view('authip')->with(['status' => 'success']);
    }
}
