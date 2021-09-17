<?php

namespace App\Http\Resources\Admin\Shared;

class LanguagesBaseData
{
    private $languages;

    public function __construct($languages)
    {
        $this->languages = $languages;
    }

    /**
     * @return mixed
     */
    public function getLanguages()
    {
        return $this->languages;
    }
}
