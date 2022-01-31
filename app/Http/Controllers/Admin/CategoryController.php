<?php

namespace App\Http\Controllers\Admin;

use App\Helper\TranslationHelper;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Category\CreateUpdateRequest;
use App\Http\Resources\Admin\Category\Item\CreateCategoryItem;
use App\Http\Resources\Admin\Category\Item\EditCategoryItem;
use App\Http\Resources\Admin\Category\Model\CategoryCreate;
use App\Http\Resources\Admin\Category\Model\CategoryEdit;
use App\Http\Resources\Admin\Category\Resources\CategoryResource;
use App\Models\Category;
use App\Repositories\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    private CategoryRepositoryInterface $categoryRepository;

    /**
     * CategoryController constructor.
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $allCategories = Category::withoutGlobalScopes()->paginate(config('admin-panel.pagination.default'));
        $allCategories = $this->categoryRepository->getAll();

        return $this->returnResponseSuccessWithPagination(
            CategoryResource::collection($allCategories),
            __('cruds.success.list', ['data' => 'categories'])
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        return $this->returnResponseSuccess(
            new CreateCategoryItem(
                new CategoryCreate(
                    TranslationHelper::getLanguagesCollection(),
                    CategoryResource::collection(Category::withoutGlobalScopes()->orderByDesc('id')->take(10)->get())
                )
            ),
            __('cruds.success.create')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateUpdateRequest $request)
    {
        try {
            $categoryData = $request->except('gender_id');
            $category = Category::create($categoryData);

            if ($request->gender_id == 3) {
                $genderIds = [1,2];
            }else{
                $genderIds = [$request->gender_id];
            }
            $category->genders()->attach($genderIds);

            return $this->returnResponseSuccess(['category_id' => $category->id], __('cruds.success.stored'));
        }catch (\Exception $exception) {
            return $this->returnResponseError([], __('cruds.errors.db_fail'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(int $id)
    {
        $category = $this->categoryRepository->findWithoutGlobalScopes(Category::class, $id);
        if (!$category) {
            return $this->returnNotFoundError();
        }

        return $this->returnResponseSuccess(
            new EditCategoryItem(
                new CategoryEdit(
                    TranslationHelper::getLanguagesCollection(),
                    CategoryResource::collection(Category::withoutGlobalScopes()->orderByDesc('id')->take(10)->get()),
                    $category
                )
            ),
            __('cruds.success.edit', ['model' => 'Category'])
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CreateUpdateRequest $request, int $id)
    {
        try {
            $this->categoryRepository->update(app(Category::class)->getTable(), $id, $request->validated(), $request->user());

            return $this->returnResponseSuccess(['category_id' => $id],  __('cruds.success.updated', ['model' => 'Category']));
        }catch (\Exception $exception) {
            return $this->returnResponseError([], __('cruds.errors.db_fail'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, int $id)
    {
        $deleted = $this->categoryRepository->softDelete(app(Category::class)->getTable(), $id, $request->user());
        if ($deleted) {
            return $this->returnResponseSuccess([],  __('cruds.success.deleted', ['model' => 'Category']));
        }

        return $this->returnResponseError([],  __('cruds.error.deleted', ['model' => 'Category']));
    }
}
