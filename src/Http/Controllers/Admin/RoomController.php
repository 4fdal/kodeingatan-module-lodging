<?php

namespace Kodeingatan\Lodging\Http\Controllers\Admin;

use App\Http\Controllers\BaseCRUDController;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoomController extends BaseCRUDController
{



    protected function getBaseModelClassName(): string
    {
        return Role::class;
    }

    protected function getBaseInertiaDirPath(): string
    {
        return "Admin/Role/";
    }

    protected function getAsRouteGroupName(): string
    {
        return "role.";
    }

    protected function handleStoreValidate(Request $request): void
    {
        $request->validate([
            'name' => ['required', 'unique:roles,name'],
            'guard_name' => ['required'],
            'permissions' => ['required'],
            'permissions.*' => ['required', 'exists:permissions,id'],
        ]);
    }

    protected function getDataStore(Request $request): array
    {
        $data = $request->only(['name', 'guard_name', 'permissions']);
        $data['permissions'] = json_encode($request->permissions);

        return $data;
    }

    protected function handleAfterStore(Request $request, $model): void
    {
        $permissions = Permission::whereIn('id', $request->permissions)->get();
        $model->syncPermissions($permissions);
    }

    protected function handleUpdateValidate(Request $request, $model): void
    {
        $request->validate([
            'name' => ['required', 'unique:roles,name,' . $model->id],
            'guard_name' => ['required'],
            'permissions' => ['required'],
            'permissions.*' => ['required', 'exists:permissions,id'],
        ]);
    }

    protected function modelShowRelation($model)
    {

        return $model->with(['permissions']);
    }

    protected function getDataUpdate(Request $request, $model): array
    {
        $data = $request->only(['name', 'guard_name', 'permissions']);
        $data['permissions'] = json_encode($request->permissions);

        return $data;
    }

    protected function handleAfterUpdate(Request $request, $model): void
    {
        $permissions = Permission::whereIn('id', $request->permissions)->get();
        $model->syncPermissions($permissions);
    }
}
