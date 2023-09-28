<?php

namespace Kodeingatan\Lodging\Http\Controllers\Admin;

use App\Http\Controllers\BaseCRUDController;
use Illuminate\Http\Request;
use Kodeingatan\Lodging\Models\AdditionalService;
use Kodeingatan\Lodging\Models\Room;

class ServiceController extends BaseCRUDController
{
    protected $base_model_class_name =  AdditionalService::class;
    protected $base_inertia_dir_path = "Admin/BaseCRUD/";
    protected $as_route_group_name = 'additional_service.';

    protected function getBrowseOptions(): object
    {
        return (object) [
            'page_active_label' => 'Service',
            'page_title' => 'Browse Service',
            'table_title' => 'Table Service',
            'browse_label' => 'Service',
        ];
    }

    public static function getBrowseColumns(): array
    {
        return [
            [
                'type' => 'image',
                'title' => 'Foto',
                'dataIndex' => 'photos',
                'key' => 'photos',
            ],
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
                'type' => 'currency',
                'title' => 'Harga',
                'dataIndex' => 'price',
                'key' => 'price',
                'order' => 'price',
                'search' => [
                    'placeholder' => 'Search nama...',
                    'field' => 'price'
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
                'type' => 'timestamp',
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
            'title' => 'Form penambahan kamar',
            'fields' => [
                [
                    'type' => 'image',
                    'name' => 'photos',
                    'label' => 'Photo',
                    'label' => 'Photo',
                    'placeholder' => 'Photo',
                    'value' => null,
                    'options' => [
                        'tooltip' => 'Photo kamar yang disewakan',
                        'image' => [
                            'multiple' => true,
                        ]
                    ]
                ],
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
                    'type' => 'currency',
                    'name' => 'price',
                    'label' => 'Harga',
                    'placeholder' => 'Harga',
                    'value' => null,
                    'options' => [
                        'tooltip' => 'Harga atau nomor kamar yang disewakan'
                    ]
                ],
                [
                    'type' => 'textarea',
                    'name' => 'description',
                    'label' => 'Deskripsi kamar',
                    'placeholder' => 'Deskripsi kamar',
                    'value' => null,
                    'options' => [
                        'tooltip' => 'Deskripsi kamar yang disekawan',
                    ]
                ],
            ],
        ];
    }

    protected function getCreateOptions(): object
    {
        return (object) [
            'page_active_label' => 'Tambahkan',
            'page_title' => "Tambahkan Kamar",
            'card_title' => "Form tambahkan kamar",
        ];
    }

    protected function handleStoreValidate(Request $request): void
    {

        $request->validate([
            'name' => ['required', 'unique:rooms,name'],
            'price' => ['required', 'numeric'],
            'description' => ['required'],
        ]);
    }

    protected function handleAfterStore(Request $request, $model): void
    {
    }

    protected function handleUpdateValidate(Request $request, $model): void
    {
        $request->validate([
            'name' => ['required', 'unique:rooms,name,' . $model->id],
            'price' => ['required', 'numeric'],
            'description' => ['required'],
        ]);
    }

    protected function getShowOptions($model): object
    {
        return (object) [
            'page_active_label' => 'Detail',
            'page_title' => "Detail Kamar",
            'browse_label' => 'Kamar',
        ];
    }

    public static function showColumn($model): array
    {
        return (array)[
            ['title' => 'Foto', 'dataIndex' => 'photos', 'type' => 'image'],
            ['title' => 'Nama', 'dataIndex' => 'name', 'type' => 'text'],
            ['title' => 'Harga', 'dataIndex' => 'price', 'type' => 'currency'],
            ['title' => 'Deskripsi', 'dataIndex' => 'description', 'type' => 'text'],
            ['title' => 'Created At', 'dataIndex' => 'created_at', 'type' => 'timestamp'],
            ['title' => 'Updated At', 'dataIndex' => 'updated_at', 'type' => 'timestamp'],
        ];
    }

    public static function formUpdate($model): object
    {
        return (object)[
            'title' => 'Form penambahan kamar',
            'fields' => [
                [
                    'type' => 'image',
                    'name' => 'photos',
                    'label' => 'Photo',
                    'label' => 'Photo',
                    'placeholder' => 'Photo',
                    'value' => $model->photos,
                    'options' => [
                        'tooltip' => 'Photo kamar yang disewakan',
                        'image' => [
                            'multiple' => true,
                        ]
                    ]
                ],
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
                    'type' => 'currency',
                    'name' => 'price',
                    'label' => 'Harga',
                    'placeholder' => 'Harga',
                    'value' => $model->price,
                    'options' => [
                        'tooltip' => 'Harga yang disewakan'
                    ]
                ],
                [
                    'type' => 'textarea',
                    'name' => 'description',
                    'label' => 'Deskripsi kamar',
                    'placeholder' => 'Deskripsi kamar',
                    'value' => $model->description,
                    'options' => [
                        'tooltip' => 'Deskripsi kamar yang disekawan',
                    ]
                ],
            ],
        ];
    }

    protected function getUpdateOptions($model): object
    {
        return (object) [
            'page_active_label' => 'Edit',
            'page_title' => "Edit Kamar `{$model->name}`",
            'card_title' => "Form edit `{$model->name}`",
            'browse_label' => 'Kamar',
        ];
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
