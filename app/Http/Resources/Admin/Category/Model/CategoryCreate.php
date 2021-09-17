<?php

namespace App\Http\Resources\Admin\Category\Model;

use App\Http\Resources\Admin\Shared\LanguagesBaseData;

class CategoryCreate extends LanguagesBaseData
{
    private $categories;

    public function __construct($languages, $categories)
    {
        parent::__construct($languages);
        $this->categories = $categories;
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }
}
