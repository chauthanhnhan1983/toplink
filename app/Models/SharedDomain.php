<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;


class SharedDomain extends BaseModel
{
  protected $table = "toplink_shareddomain";
  protected $primaryKey = "domain_id";
  public $timestamps = false;
}
