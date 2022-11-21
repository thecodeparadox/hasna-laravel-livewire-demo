<?php

namespace App\Http\Requests;

use App\Traits\AppAuthTrait;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
  use AppAuthTrait;

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   * if api not working then add remove App\Exceptions\Handler files response ajax option
   * @return array
   */
  public function rules()
  {
    if ($this->isMethod('GET')) {
      return [];
    }

    return $this->getLoginValidationRules();
  }
}
