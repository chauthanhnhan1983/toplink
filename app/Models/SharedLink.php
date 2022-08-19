<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;


class Sharedlink extends BaseModel
{
  protected $table = "toplink_sharedlinks";
  protected $primaryKey = "link_id";
  public $timestamps = false;
}
