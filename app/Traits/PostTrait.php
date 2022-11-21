<?php

namespace App\Traits;

use App\Enums\PostStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;
use Illuminate\Validation\Rules\Unique;

trait PostTrait
{
    /**
     * Get Post Create/edit validation rules
     *
     * @param Request $request
     * @return ((string|Unique)[]|string|(string|In)[]|string[])[]
     */
    public function getPostValidationRules()
    {
        $rules = [
            'title' => [
                'required',
                'min:5',
                'max:255'
            ],
            'slug' => 'required|min:5|max:255',
            'content' =>  'required',
            'status' => ['required', Rule::in(PostStatus::getEnumValues())],
        ];

        return $rules;
    }
}
