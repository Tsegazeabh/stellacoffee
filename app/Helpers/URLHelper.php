<?php
//Function that returns MD5 digest
use Illuminate\Support\Facades\Config;

function formatMD5($hash)
{
    $hash = strtoupper($hash);
    $formatedMD5 =
        substr($hash, 0, 8) . '-' .
        substr($hash, 8, 4) . '-' .
        substr($hash, 12, 4) . '-' .
        substr($hash, 16, 4) . '-' .
        substr($hash, 20);
    return $formatedMD5;
}

function getSecureURL($action)
{
    switch ($action) {
        case 1://This means you can also use numbers instead of strings while calling the function, so that you can apply arrays.
        case 'create_get':
            return formatMD5(Config::get('custom_config.crud_func_secure_url.create_get'));
        case 2:
        case 'create_post':
            return formatMD5(Config::get('custom_config.crud_func_secure_url.create_post'));
        case 3:
        case 'read':
            return formatMD5(Config::get('custom_config.crud_func_secure_url.read'));
        case 4:
        case 'manage':
            return formatMD5(Config::get('custom_config.crud_func_secure_url.manage'));
        case 5:
        case 'list':
            return formatMD5(Config::get('custom_config.crud_func_secure_url.list'));
        case 6:
        case 'edit_get':
            return formatMD5(Config::get('custom_config.crud_func_secure_url.edit_get'));
        case 7:
        case 'edit_post':
            return formatMD5(Config::get('custom_config.crud_func_secure_url.edit_post'));
        case 8:
        case 'delete':
            return formatMD5(Config::get('custom_config.crud_func_secure_url.delete'));
        case 9:
        case 'publish':
            return formatMD5(Config::get('custom_config.crud_func_secure_url.publish'));
        case 10:
        case 'unpublish':
            return formatMD5(Config::get('custom_config.crud_func_secure_url.unpublish'));
        case 11:
        case 'archive':
            return formatMD5(Config::get('custom_config.crud_func_secure_url.archive'));
        case 'restore':
            return formatMD5(Config::get('custom_config.crud_func_secure_url.restore'));
        case 12:
        case 'upload':
            return formatMD5(Config::get('custom_config.crud_func_secure_url.upload'));
        case 13:
        case 'laravel-file-manager':
        case 'lfm':
            return formatMD5(Config::get('custom_config.crud_func_secure_url.lfm'));
        case 14:
        case 'auth-root-url':
        case 'auth':
            return formatMD5(Config::get('custom_config.crud_func_secure_url.auth'));
        case 15:
        case 'stats':
            return formatMD5(Config::get('custom_config.crud_func_secure_url.stats'));
        case 16:
        case 'upload_get':
            return formatMD5(Config::get('custom_config.crud_func_secure_url.upload_get'));
        case 17:
        case 'upload_post':
            return formatMD5(Config::get('custom_config.crud_func_secure_url.upload_post'));
        case 'remove':
            return formatMD5(Config::get('custom_config.crud_func_secure_url.remove'));
        case 'open':
            return formatMD5(Config::get('custom_config.crud_func_secure_url.enable'));
        case 'close':
            return formatMD5(Config::get('custom_config.crud_func_secure_url.disable'));
        case 'modify_get':
            return formatMD5(Config::get('custom_config.crud_func_secure_url.modify_get'));
        case 'modify_post':
            return formatMD5(Config::get('custom_config.crud_func_secure_url.modify_post'));
        case 'reset':
            return formatMD5(Config::get('custom_config.crud_func_secure_url.modify_reset'));
        case 'cms':
            return formatMD5(Config::get('custom_config.crud_func_secure_url.cms'));
        default:
            return null;
    }
}
