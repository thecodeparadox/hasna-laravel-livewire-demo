<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait UtilTrait
{
  /**
   * Return Slugify string
   *
   * @param string $target
   * @return string
   */
  public function slugify($target = '')
  {
    return Str::slug($target);
  }

  /**
   * Auth use Id
   * @return mixed
   */
  public function authId()
  {
    return  Auth::user()->id;
  }

  /**
   * Now time
   *
   * @return Carbon
   */
  public function now()
  {
    return Carbon::now();
  }
}
