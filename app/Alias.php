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
					$to_insert[] = ['alias' => $aliases[$i]['alias'], 'account' => $aliases[$i]['account']];
				}

				if(count($to_insert) > 0) // just in case
					DB::table('aliases')->insert(array_reverse($to_insert));
			}
		}
		else
		{
			Log::info("Unable to load alias file.");
		}
    }
}
