<?php

namespace Kodeingatan\Lodging\Http\Controllers\Admin;

use App\Http\Controllers\BaseCRUDController;
use Illuminate\Http\Request;
use Kodeingatan\Lodging\Models\RoomType;

class RoomTypeController extends BaseCRUDController
{
    protected $base_model_class_name =  RoomType::class;
    protected $base_inertia_dir_path = "Admin/BaseCRUD/";
    protected $as_route_group_name = 'room_type.';

    protected function getBrowseOptions(): object
    {
        return (object) [
            'page_active_label' => 'Tipe Kamar',
            'page_title' => 'Browse Tipe Kamar',
            'table_title' => 'Table Tipe Kamar',
        ];
    }

    protected function getBrowseColumns(): array
    {
        return [
            [
                'title' => 'Nama',
                'dataIndex' => 'name',
                'key' => 'name',
                'order' => 'name',
                'search' => [
                    'placeholder' => 'Search nama...',
                    'field' => 'name'
                ]
            ],
            [
                'title' => 'Deskripsi',
                'dataIndex' => 'description',
                'key' => 'description',
                'order' => 'description',
                'search' => [
                    'placeholder' => 'Search nama...',
                    'field' => 'description'
                ]
            ],
            [
                'title' => 'Created At',
                'dataIndex' => 'created_at',
                'key' => 'created_at',
                'order' => 'created_at',
            ],
        ];
    }

    public static function formCreate(): object
    {
        return (object)[
            'title' => 'Tambahkan Tipe Kamar',
            'fields' => [
                ['type' => 'text', 'name' => 'name', 'label' => 'Nama', 'placeholder' => 'Nama', 'value' => null],
                ['type' => 'textarea', 'name' => 'description', 'label' => 'Description', 'placeholder' => 'Description', 'value' => null],
            ],
            // 'relations' => [
            //     'table_name' => Model::formCreate,
            // ]
        ];
    }

    protected function getCreateOptions(): object
    {
        return (object) [
            'page_active_label' => 'Tipe Kamar',
            'page_title' => "Tambahkan Tipe Kamar",
        ];
    }

    protected function handleStoreValidate(Request $request): void
    {
        $request->validate([
            'name' => ['required', 'unique:room_types,name'],
            'description' => ['required'],
        ]);
    }

    protected function getDataStore(Request $request): array
    {

        $data = $request->only(['name', 'description']);
        $data['key'] = \Str::uuid();

        return $data;
    }

    protected function handleAfterStore(Request $request, $model): void
    {
    }

    protected function handleUpdateValidate(Request $request, $model): void
    {
        $request->validate([
            'name' => ['required', 'unique:roles,name,' . $model->id],
            'description' => ['required'],
        ]);
    }

    protected function modelShowRelation($model)
    {
        return $model;
    }

    protected function getDataUpdate(Request $request, $model): array
    {
        $data = $request->only(['name', 'description']);

        return $data;
    }

    protected function handleAfterUpdate(Request $request, $model): void
    {
    }
}
