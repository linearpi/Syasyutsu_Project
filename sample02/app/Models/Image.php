<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
	use HasFactory;
	protected $table = "Images";
	protected $guarded = array('id');
	public static $rules = array(
		'title' => 'required',
		'picture' => 'mimes:jpeg,jpg|max:2048',
	);
}
