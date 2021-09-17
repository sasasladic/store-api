<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\User\CreateUpdateRequest;
use App\Http\Resources\Admin\Role\RoleResource;
use App\Http\Resources\Admin\User\Item\UserEditItem;
use App\Http\Resources\Admin\User\Resources\UserIndexResource;
use App\Models\Role;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{

    private UserRepositoryInterface $userRepository;

    /**
     * UserController constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->returnResponseSuccessWithPagination(
            UserIndexResource::collection($this->userRepository->getAll()),
            __('cruds.success.list', ['data' => 'orders'])
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        return $this->returnResponseSuccess(RoleResource::collection(Role::all()), __('cruds.success.create'));
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
            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);
            $user = $this->userRepository->store(User::class, $data);

            return $this->returnResponseSuccess(['user_id' => $user->id], __('cruds.success.stored'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $user = $this->userRepository->findWithoutGlobalScopes(User::class, $id);
        if (!$user) {
            return $this->returnNotFoundError();
        }

        return $this->returnResponseSuccess(
            new UserEditItem($user),
            __('cruds.success.edit', ['model' => 'User']),
            ['role' => RoleResource::collection(Role::all())],
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
            $this->userRepository->update(app(User::class)->getTable(), $id, $request->validated(), $request->user());

            return $this->returnResponseSuccess(['user_id' => $id],  __('cruds.success.updated', ['model' => 'User']));
        }catch (\Exception $exception) {
            return $this->returnResponseError([], __('cruds.errors.db_fail'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $deleted = $this->userRepository->softDelete(app(User::class)->getTable(), $id, $request->user());
        if ($deleted) {
            return $this->returnResponseSuccess([],  __('cruds.success.deleted', ['model' => 'User']));
        }

        return $this->returnResponseError([],  __('cruds.error.deleted', ['model' => 'User']));
    }
}
