<?php

namespace App\Http\Resources\Admin\Category\Model;


class CategoryEdit extends CategoryCreate
{
    private $category;

    public function __construct($languages, $categories, $category)
    {
        parent::__construct($languages, $categories);
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getCurrentCategory()
    {
        return $this->category;
    }
}
