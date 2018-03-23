<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TxTimestamp extends Model
{
	public $timestamps = false;

	protected static function boot()
	{
		parent::boot();

		static::saving(function()
		{
			static::creating( function ($model) {
		    	$model->setCreatedAt($model->freshTimestamp());
		    });
		});
	}
}