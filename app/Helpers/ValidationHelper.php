<?php

use Spatie\Csp\Nonce\RandomString;

function isValidImageType($mime_type){
    return in_array($mime_type, array( 'image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/bmp'));
}

function validImageMimeTypes(){
    return array( 'image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/bmp');
}

function isValidFileType($mime_type){
    return in_array($mime_type, array( 'application/pdf', 'image/jpeg', 'image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/bmp'));
}

function validFileMimeTypes(){
    return array( 'application/pdf', 'image/jpeg', 'image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/bmp');
}

function getNonce(){
    return (new RandomString)->generate();
}
