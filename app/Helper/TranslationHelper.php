<?php

namespace App\Helper;

use App\Http\Resources\Admin\LanguagesResource;
use App\Models\Language;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TranslationHelper
{
    public static function getLanguagesCollection(): AnonymousResourceCollection
    {
        return LanguagesResource::collection(self::getLanguages());
    }

    public static function getLanguages()
    {
        return Language::orderByDesc('id')->get();
    }
}
