<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

	public static $rules = array(
		"description" => "required|max:150",
		"judgment" => "required"
	);
}
