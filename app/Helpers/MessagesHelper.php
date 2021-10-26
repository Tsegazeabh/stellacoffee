<?php

function getPublicErrorMessage()
{
    return trans('notifications.errors.PublicErrorMessage');
}

function getGeneralAdminErrorMessage()
{
    return trans('notifications.errors.ExceptionErrorMessage');
}

function getResourceNotFoundErrorMessage()
{
    return trans('notifications.errors.ResourceNotFound');
}

function getContentCreatedNotificationMessage()
{
    return trans('notifications.success.ContentCreated');
}

function getContentUpdatedNotificationMessage()
{
    return trans('notifications.success.ContentUpdated');
}

function getContentDeletedNotificationMessage()
{
    return trans('notifications.success.ContentDeleted');
}

function getContentPublishedNotificationMessage()
{
    return trans('notifications.success.ContentPublished');
}

function getContentArchivedNotificationMessage()
{
    return trans('notifications.success.ResourceNotFound');
}

function getContentUnpublishedNotificationMessage()
{
    return trans('notifications.success.ContentUnpublished');
}

function getMailSentNotificationMessage()
{
    return trans('notifications.success.MailSentSuccessfully');
}

function getMailSendingProcessFailedErrorMessage()
{
    return trans('notifications.success.MailSendingProcessFailed');
}

function getFileUploadedMessage()
{
    return trans('notifications.success.ContentUploaded');
}

function getContentCreateFailedMessage()
{
    return trans('notifications.errors.ContentCreation');
}

function getContentUpdateFailedMessage()
{
    return trans('notifications.errors.ContentUpdate');
}

function getFileUploadFailed()
{
    return trans('notifications.success.UploadFailed');
}

function getUnAuthorizedAccessMessage()
{

    return trans('notifications.errors.AuthorizationError');
}

function getUnableToDownloadFileMessage()
{
    return trans('notifications.errors.DownloadFailed');
}

function getEmptyContentPageNotificationMessage()
{
    return trans('notifications.errors.EmptyContentPage');
}

function getReplyIsPostedNotificationMessage()
{
    return trans('notifications.success.ReplyPostedSuccessfully');
}

function getUnableToPostReplyErrMessage()
{
    return trans('notifications.errors.UnableToPostReply');
}

function getUnableToDeleteContentErrMessage()
{
    return trans('notifications.errors.UnableToDeleteContent');
}

function logError(Throwable $ex)
{
    \Illuminate\Support\Facades\Log::error($ex->getMessage() . ' in ' . $ex->getFile() . ' Line:' . $ex->getLine());
}

function getPasswordUpdatedMessage()
{
    return trans('notifications.success.PasswordModified');
}

function getPasswordUpdateFailedMessage()
{
    return trans('notifications.error.UnableToUpdateYourPassword');
}
function getRequestClosedNotificationMessage()
{
    return trans('notifications.success.RequestClosed');
}
function getRequestOpenedNotificationMessage()
{
    return trans('notifications.success.RequestOpened');
}
function getUserStatusUpdatedNotificationMessage()
{
    return trans('notifications.success.UserStatusUpdated');
}
function getUnableToUpdateUserStatusNotificationMessage()
{
    return trans('notifications.success.UnableToUpdateUserStatus');
}
