<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Admin\Option\Resources\OptionResource;
use App\Http\Resources\Admin\Option\Resources\OptionSearchResource;
use App\Http\Resources\Admin\Option\Resources\OptionValueResource;
use App\Http\Resources\Admin\Option\Select\OptionValueSearchResource;
use App\Repositories\OptionValueRepositoryInterface;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
