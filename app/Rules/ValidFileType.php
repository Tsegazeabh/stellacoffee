<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Log;

class ValidFileType implements Rule
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
        $file_mime_type=$value->getMimeType();
        $supported_file_types= validFileMimeTypes();
        return in_array($file_mime_type,$supported_file_types);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $valid_mime_types = join(', ', validFileMimeTypes());
        return 'The file you selected has invalid mime type. The only supported mime types are '. $valid_mime_types;
    }
}
