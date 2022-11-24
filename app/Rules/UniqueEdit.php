<?php

namespace App\Rules;

use App\Models\Category;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class UniqueEdit implements Rule
{
    public $data;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->data = $request;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */


    public function passes($attribute, $value)
    {

        if ($this->data['category_id_old'] == $this->data['category_id'] && $this->data['category_name_old'] == $this->data['category_name']) {
            return true;
        } else {
            if (Category::where('id', $this->data['category_id'])->exitsts()) {
                return false;
            } else if (Category::where('category_name', $this->data['category_name'])->exitsts()) {
                return false;
            } else {
                return true;
            }
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '';
    }
}
