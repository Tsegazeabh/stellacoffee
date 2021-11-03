<?php

namespace App\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Config;

class CustomValidatorServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Cross site script attack prevention
         *
         * The custom validator Closure receives four arguments:
         *      the name of the $attribute being validated,
         *      the $value of the attribute,
         *      an array of $parameters passed to the rule,
         *      and the Validator instance.
         */
        Validator::extend('without_xss', function ($attribute, $value, $parameters, $validator) {
            $xss_tags=Config::get('custom_config.xss_tags');
            foreach($xss_tags as $xss_tag)
            {
                $tag_reg_exp='|\</?('.$xss_tag.')(\s[^>]*)?(\s?/)?\>|i';
                if(preg_match($tag_reg_exp,html_entity_decode($value)))
                {
                    return false;
                }
            }
            return true;
        });

        /***
         * Video file validation
         *
         */

        Validator::extend('supported_video_type', function ($attribute, $file, $parameters, $validator) {

            /**
             * Media element js supported video mime types(formats)
             */
            $supported_video_mime_types=
                [
                    'video/webm','video/wmv','video/wmv','video/ogg','video/mp4',
                ];
            $file_mime_type=$file->getMimeType();
            return in_array($file_mime_type,$supported_video_mime_types);
        });

        /***
         * Audio file validation
         *
         */

        Validator::extend('supported_audio_type', function ($attribute, $file, $parameters, $validator) {

            /**
             * Media element js supported audio mime types(formats)
             */
            $supported_audio_mime_types=
                [
                    'audio/mp3','audio/mpeg','audio/ogg'
                ];
            $file_mime_type=$file->getMimeType();
            return in_array($file_mime_type,$supported_audio_mime_types);
        });

        /***
         * Audio/Video file validation
         *
         */

        Validator::extend('supported_video_or_audio_type', function ($attribute, $file, $parameters, $validator) {

            /**
             * Media element js supported video/audio mime types(formats)
             */
            $supported_video_or_audio_mime_types=
                [
                    'video/webm','video/wmv','video/wmv','video/ogg','video/mp4','audio/mp3','audio/mpeg','audio/ogg'
                ];
            $file_mime_type=$file->getMimeType();
            return in_array($file_mime_type,$supported_video_or_audio_mime_types);
        });

        /***
         * Valid Attachment file types
         *
         */

        Validator::extend('supported_image_types', function ($attribute, $file, $parameters, $validator) {

            /**
             * Media element js supported video/audio mime types(formats)
             */
            $supported_image_types= validImageMimeTypes();
            [
                'image/bmp','image/gif','image/jpeg','image/jpeg'
            ];
            $file_mime_type=$file->getMimeType();
            return in_array($file_mime_type,$supported_image_types);
        });

        /***
         * Valid Attachment file types
         *
         */

        Validator::extend('supported_attachment_types', function ($attribute, $file, $parameters, $validator) {

            /**
             * Media element js supported video/audio mime types(formats)
             */
            $supported_attachment_types=
                [
                    'file/pdf', 'image/jpeg', 'image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/bmp'
                ];
            $file_mime_type=$file->getMimeType();
            return in_array($file_mime_type,$supported_attachment_types);
        });
    }
}
