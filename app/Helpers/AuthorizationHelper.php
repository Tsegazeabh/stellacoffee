<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

function getAuthorizableModels()
{
    return array(
        \App\Models\ExportDestination::class=>\App\Models\ExportDestination::$actions,
        \App\Models\ExportProcess::class=>\App\Models\ExportProcess::$actions,
        \App\Models\Store::class=>\App\Models\Store::$actions,
        \App\Models\Shop::class=>\App\Models\Shop::$actions,
        \App\Models\CuppingEvent::class=>\App\Models\CuppingEvent::$actions,
        \App\Models\CuppingProcedure::class=>\App\Models\CuppingProcedure::$actions,
        \App\Models\FactoryLocation::class=>\App\Models\FactoryLocation::$actions,
        \App\Models\DutyFreeLocation::class=>\App\Models\DutyFreeLocation::$actions,
        \App\Models\News::class=>\App\Models\News::$actions,
        \App\Models\Event::class=>\App\Models\Event::$actions,
        \App\Models\ForumTopic::class=>\App\Models\ForumTopic::$actions,
        \App\Models\CustomerTestimonial::class=>\App\Models\CustomerTestimonial::$actions,
        \App\Models\Faq::class=>\App\Models\Faq::$actions,
        \App\Models\ProductBlend::class=>\App\Models\ProductBlend::$actions,
        \App\Models\ProductPackage::class=>\App\Models\ProductPackage::$actions,
        \App\Models\RoastingGuide::class=>\App\Models\RoastingGuide::$actions,
        \App\Models\RoastingMachine::class=>\App\Models\RoastingMachine::$actions,
        \App\Models\RoastingProcess::class=>\App\Models\RoastingProcess::$actions,
        \App\Models\RoastingService::class=>\App\Models\RoastingService::$actions,
        \App\Models\SuccessStory::class=>\App\Models\SuccessStory::$actions,
        \App\Models\History::class=>\App\Models\History::$actions,
        \App\Models\Certification::class=>\App\Models\Certification::$actions,
        \App\Models\StellaCoffeeOrigin::class=>\App\Models\StellaCoffeeOrigin::$actions,
        \App\Models\ContactUsRequest::class=>\App\Models\ContactUsRequest::$actions,
        \App\Models\ContactInfo::class=>\App\Models\ContactInfo::$actions,
    );
}

function isAuthorized($model, $action, User $user)
{
    if($user->is_admin){
        return true;
    }

    $userId = $user->getAuthIdentifier();

    return Role::whereHas('users', function ($query) use ($userId) {
        $query->where('users.id', $userId);
    })->whereHas('permissions', function ($query) use ($model, $action) {
        $query->where('model', $model)->where('action', $action);
    })->exists();
}
