<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;


class SharedLink extends BaseModel
{
  protected $table = "toplink_sharedlinks";
  protected $primaryKey = "link_id";
  public $timestamps = false;
}
