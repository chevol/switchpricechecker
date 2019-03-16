<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class US_Game extends Model
{
  /**
  * The table associated with the model.
  *
  * @var string
  */
  protected $table = 'us_games';
  protected $guarded = ['id'];
  //protected $fillable = array('nsuid','title','eshop_price','sale_price','front_box_art');
}
