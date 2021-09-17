<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Admin\UserOrder\Resources\UserOrderResource;
use App\Repositories\UserOrderRepositoryInterface;
use Illuminate\Http\Request;

class UserOrderController extends BaseController
{

    private UserOrderRepositoryInterface $userOrderRepository;

    /**
     * UserOrderController constructor.
     * @param UserOrderRepositoryInterface $userOrderRepository
     */
    public function __construct(UserOrderRepositoryInterface $userOrderRepository)
    {
        $this->userOrderRepository = $userOrderRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->returnResponseSuccessWithPagination(
            UserOrderResource::collection($this->userOrderRepository->getAll()),
            __('cruds.success.list', ['data' => 'orders'])
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
