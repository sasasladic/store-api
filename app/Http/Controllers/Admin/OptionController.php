<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Option\CreateUpdateRequest;
use App\Http\Resources\Admin\Option\Resources\OptionResource;
use App\Http\Resources\Admin\Option\Resources\OptionSearchResource;
use App\Http\Resources\Admin\Option\Resources\OptionValueResource;
use App\Http\Resources\Admin\Option\Select\OptionValueSearchResource;
use App\Models\Option;
use App\Models\OptionValue;
use App\Models\Product;
use App\Repositories\OptionValueRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OptionController extends BaseController
{

    private OptionValueRepositoryInterface $optionRepository;

    /**
     * CategoryController constructor.
     * @param OptionValueRepositoryInterface $optionRepository
     */
    public function __construct(OptionValueRepositoryInterface $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allOptions()
    {
        return $this->returnResponseSuccessWithPagination(
            OptionResource::collection($this->optionRepository->getAll()),
            __('cruds.success.list', ['data' => 'Options'])
        );
    }

    public function allProductOptions(int $id)
    {
        $product = $this->optionRepository->findWithoutGlobalScopes(Product::class, $id);
        if (!$product) {
            return $this->returnNotFoundError();
        }

        return $this->returnResponseSuccessWithPagination(
            OptionSearchResource::collection($product->options),
            __('cruds.success.list', ['data' => 'Options'])
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function allOptionValues()
    {
        return $this->returnResponseSuccessWithPagination(
            OptionValueResource::collection($this->optionRepository->getAllValues()),
            __('cruds.success.list', ['data' => 'Option values'])
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allOptionsSelect()
    {
        return $this->returnResponseSuccessWithPagination(
            OptionSearchResource::collection($this->optionRepository->getAll()),
            __('cruds.success.list', ['data' => 'Options'])
        );
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function allOptionValuesSelect()
    {
        return $this->returnResponseSuccessWithPagination(
            OptionValueSearchResource::collection($this->optionRepository->getAllValues()),
            __('cruds.success.list', ['data' => 'Option values'])
        );
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateUpdateRequest $request)
    {
        $user = $request->user();
        $validatedData = $request->validated();
        if (!$validatedData) {
            return $this->returnResponseError([], 'No valid data!', 422);
        }
//        dd($validatedData + ['test' => '3213123sdds']);
        $option = $this->optionRepository->store(Option::class, ['name' => $validatedData['name']]);
        $data = [];
        foreach ($validatedData['values'] as $item) {
            $data[] = [
                'option_id' => $option->id,
                'value' => $item['value'],
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'deleted_by' => null
            ];
        }
        try {
            OptionValue::insert($data);

            return $this->returnResponseSuccess([], 'Success!');
        }catch (\Exception $exception) {
            return $this->returnResponseError([], 'Something went wrong', $exception->getCode());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $option = $this->optionRepository->findWithoutGlobalScopes(Option::class, $id);
        if (!$option) {
            return $this->returnNotFoundError();
        }

        return $this->returnResponseSuccess(
            new OptionResource($option),
            __('cruds.success.edit', ['model' => 'Option'])
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $deleted = $this->optionRepository->softDelete(app(Option::class)->getTable(), $id, $request->user());
        if ($deleted) {
            return $this->returnResponseSuccess([],  __('cruds.success.deleted', ['model' => 'Attribute']));
        }

        return $this->returnResponseError([],  __('cruds.error.deleted', ['model' => 'Attribute']));
    }
}
