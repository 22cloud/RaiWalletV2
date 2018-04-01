<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class Alias extends Model
{
    public $timestamps = false;
    protected $fillable = ['alias', 'account'];

    public static function refreshAliases()
    {
		$aliases = file_get_contents(env("ALIAS_JSON_FILE"));
		$aliases = json_decode($aliases, true);
		if($aliases)
		{
			$count = Alias::count();
			if($count < count($aliases))
			{
				$to_insert = [];
				for($i = $count; $i < count($aliases); $i++)
				{
					Alias::firstOrCreate(['alias' => $aliases[$i]['alias'], 'account' => $aliases[$i]['account']]);
				}
			}
		}
		else
		{
			Log::info("Unable to load alias file.");
		}
    }
}
