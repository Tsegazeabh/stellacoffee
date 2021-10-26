<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Config;

class XSSValidator implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $xss_tags=Config::get('custom_config.xss_tags');
        foreach($xss_tags as $xss_tag)
        {
            $tag_reg_exp='|\</?('.$xss_tag.')(\s[^>]*)?(\s?/)?\>|i';
            if(preg_match($tag_reg_exp, html_entity_decode($value)))
            {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Your input contains data that could expose the application for XSS attack.';
    }
}
