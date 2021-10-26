<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Log;

class ValidImageType implements Rule
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
        /**
         * Media element js supported video/audio mime types(formats)
         */
        $supported_image_types = validImageMimeTypes();
        $file_mime_type=$value->getMimeType();
        return in_array($file_mime_type,$supported_image_types);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $valid_mime_types = join(', ', validImageMimeTypes());
        return 'The file you selected has invalid file format. The only supported file formats are '. $valid_mime_types;
    }
}
