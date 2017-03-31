<?php
/**
 * Created by PhpStorm.
 * User: davy
 * Date: 3/31/17
 * Time: 10:49 AM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bug extends Model {

    use SoftDeletes;

    protected $fillable = ['supposed', 'happening', 'reproduce', 'client_os', 'game_version', 'created_at', 'updated_at', 'deleted_at'];

    protected $hidden = ['deleted_at'];

    protected $dates = ['deleted_at'];

}