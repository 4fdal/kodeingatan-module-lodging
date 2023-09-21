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
            'browse_label' => 'Tipe Kamar',
        ];
    }

    public static function getBrowseColumns(): array
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
            'title' => 'Form penambahan tipe kamar',
            'fields' => [
                [
                    'type' => 'text',
                    'name' => 'name',
                    'label' => 'Nama',
                    'placeholder' => 'Nama',
                    'value' => null,
                    'options' => [
                        'tooltip' => 'Nama atau nomor kamar yang disewakan'
                    ]
                ],
                [
                    'type' => 'textarea',
                    'name' => 'description',
                    'label' => 'Description',
                    'placeholder' => 'Description',
                    'value' => null,
                    'options' => [
                        'tooltip' => 'Deskripsi kamar yang disekawan',
                    ]
                ],
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
            'card_title' => "Form tambahkan tipe kamar",
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

    protected function getShowOptions($model): object
    {
        return (object) [
            'page_active_label' => 'Detail Tipe Kamar',
            'page_title' => "Detail Tipe Kamar",
            'browse_label' => 'Tipe Kamar',
        ];
    }

    public static function showColumn($model): array
    {
        return (array)[
            ['title' => 'Nama', 'dataIndex' => 'name', 'type' => 'text'],
            ['title' => 'Deskripsi', 'dataIndex' => 'description', 'type' => 'text'],
            ['title' => 'Created At', 'dataIndex' => 'created_at', 'type' => 'text'],
            ['title' => 'Updated At', 'dataIndex' => 'updated_at', 'type' => 'text'],
        ];
    }

    protected function modelShowRelation($model)
    {
        return $model;
    }

    public static function formUpdate($model): object
    {
        return (object)[
            'title' => "Form edit tipe kamar `{$model->name}`",
            'fields' => [
                [
                    'type' => 'text',
                    'name' => 'name',
                    'label' => 'Nama',
                    'placeholder' => 'Nama',
                    'value' => $model->name,
                    'options' => [
                        'tooltip' => 'Nama atau nomor kamar yang disewakan'
                    ]
                ],
                [
                    'type' => 'textarea',
                    'name' => 'description',
                    'label' => 'Description',
                    'placeholder' => 'Description',
                    'value' => $model->description,
                    'options' => [
                        'tooltip' => 'Deskripsi kamar yang disekawan',
                    ]
                ],
            ],
            // 'relations' => [
            //     'table_name' => Model::formCreate,
            // ]
        ];
    }

    protected function getUpdateOptions($model): object
    {
        return (object) [
            'page_active_label' => 'Tipe Kamar',
            'page_title' => "Edit Tipe Kamar `{$model->name}`",
            'card_title' => "Form edit `{$model->name}`",
            'browse_label' => 'Tipe Kamar',
        ];
    }


    protected function getDataUpdate(Request $request, $model): array
    {
        $data = $request->only(['name', 'description']);

        return $data;
    }

    protected function handleAfterUpdate(Request $request, $model): void
    {
    }

    public static function getBrowseRecycleColumns(): array
    {
        return self::getBrowseColumns();
    }

    public static function showColumnRecycle($model): array
    {
        return self::showColumn($model);
    }
}
