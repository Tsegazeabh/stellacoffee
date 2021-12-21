<?php
/**
 * Created by PhpStorm.
 * User: Haftisha
 * Date: 26-05-2021
 * Time: 2:54 PM
 */

return [
    'default_locale' => 'am',
    'max_login_attempts' => 3,
    'max_login_failed_attempts_lockout_time' => 1, //in minutes
    'password_life_time' => 60, // in days: user will be forced to change his/her password after 60 days
    'paging_size' => 10,
    'related_contents_paging_size'=> 8,
    'default_sorting_method' => 'DESC',
    'default_content_sorting_col' => 'created_at',
    'default_image_path' => 'http://www.eeu.org.et/assets/default-image.jpg',
    'DEFAULT_EMAIL_ADDRESS' => 'mail@eeu.org.et',
    'external_user' => [
        'banning_duration' => 14 // days
    ],
    'feed_back_email' => 'feedback@eeu.org.et',
    'feedback_receiver_name' => 'ETHIOPIAN ELECTRICAL UTILITY',
    'lead_paragraph_words_limit' => 100,
    'cms_lead_paragraph_words_limit' => 10,
    'crud_func_secure_url' => [
        'create_get' => md5('34987987sdkjhy'),
        'create_post' => md5('create_new_post'),
        'edit_get' => md5('edit_entry_get'),
        'edit_post' => md5('edit_entry_post'),
        'delete' => md5('delete_entry'),
        'remove' => md5('remove_entry'),
        'enable' => md5('enable_entry'),
        'disable' => md5('disable_entry'),
        'modify_get' => md5('modify_entry_get'),
        'modify_post' => md5('modify_entry_post'),
        'reset' => md5('reset_entry_post'),
        //index for category; for internal use only. Otherwise for other content index is public
        'index' => md5('index_entry'),
        'manage' => md5('687hgjhgt876'),
        'list' => md5('list_entries'),
        'publish' => md5('publish_content'),
        'unpublish' => md5('unpublish_content'),
        'archive' => md5('archive_content'),
        'restore' => md5('restore_content'),
        'upload' => md5('upload_data'),
        'upload_get' => md5('upload_new_get'),
        'upload_post' => md5('upload_new_post'),
        'lfm' => md5('laravel-file-manager'),
        'auth' => md5('sajgjgiiuwe'), //For login randomizing will create a problem for the users as they are expected to type it.
        'cms' => md5('EEU_PROTAL_CMS'),
        'stats' => md5('SiteStatBaseURL')
    ],
    'xss_tags' => ['meta', 'applet', 'body', 'embed', 'frame', 'iframe', 'script', 'frameset', 'html', 'layer', 'link', 'style', 'ilayer', 'object'],
    'content_rss_max_limit' => 5,
    'rss_feed_target_content_types' => [],
    'archievable_content_types' => [],

    'free_call_center'=>'906',
    'facebook_official_page'=>'https://www.facebook.com/stellacoffee',
    'twitter_official_page'=>'https://twitter.com/stellacoffee?s=11',
    'telegram_official_page'=>'https://t.me/stellacoffee',
    'youtube_official_page'=>'https://www.youtube.com/channel/UCY_ASjgstwvI6HgEPn2dQGg',
    'linkedin_official_page'=>'https://www.linkedin.com/stellacoffee',
    'instagram_official_page'=>'https://www.instagram.com/stellacoffee'
];
