<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;


class Feed extends BaseModel
{
  protected $table = "toplink_feeds";
  protected $primaryKey = "feed_id";
  public $timestamps = false;
}
