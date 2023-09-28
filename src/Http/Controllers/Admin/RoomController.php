<?php

namespace Kodeingatan\Lodging\Http\Controllers\Admin;

use App\Http\Controllers\BaseCRUDController;
use Illuminate\Http\Request;
use Kodeingatan\Lodging\Models\Room;

class RoomController extends BaseCRUDController
{
    protected $base_model_class_name =  Room::class;
    protected $base_inertia_dir_path = "Admin/BaseCRUD/";
    protected $as_route_group_name = 'room.';

    protected function getBrowseOptions(): object
    {
        return (object) [
            'page_active_label' => 'Kamar',
            'page_title' => 'Browse Kamar',
            'table_title' => 'Table Kamar',
            'browse_label' => 'Kamar',
        ];
    }

    public static function getBrowseColumns(): array
    {
        return [
            [
                'type' => 'image',
                'title' => 'Foto',
                'dataIndex' => 'photo',
                'key' => 'photo',
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
                'type' => 'relation',
                'title' => 'Tipe Ruangan',
                'dataIndex' => 'room_types.name',
                'key' => 'room_types.name',
                'order' => 'room_types.name',
                'search' => [
                    'placeholder' => 'Search nama...',
                    'field' => 'room_types.name'
                ],
                'options' => [
                    'relation' => [
                        'foreign_key' => 'room_type_id',
                    ],
                ]
            ],
            [
                'type' => 'currency',
                'title' => 'Harga per Malam',
                'dataIndex' => 'price_per_night',
                'key' => 'price_per_night',
                'order' => 'price_per_night',
                'search' => [
                    'placeholder' => 'Search nama...',
                    'field' => 'price_per_night'
                ]
            ],
            [
                'type' => 'boolean',
                'title' => 'Ketersediaan',
                'dataIndex' => 'availability',
                'key' => 'availability',
                'order' => 'availability',
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
                    'name' => 'photo',
                    'label' => 'Photo',
                    'label' => 'Photo',
                    'placeholder' => 'Photo',
                    'value' => null,
                    'options' => [
                        'tooltip' => 'Photo kamar yang disewakan'
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
                    'type' => 'table_select',
                    'name' => 'room_type_id',
                    'label' => 'Tipe kamar',
                    'placeholder' => 'Tipe kamar',
                    'value' => null,
                    'options' => [
                        'tooltip' => 'Tipe kamar yang disewakan',
                        'table_select' => [
                            'multiple' => false,
                            'field_selected' => [
                                'value' => 'id',
                                'label' => 'name',
                            ],
                            'title' => 'Pilih tipe kamar',
                            'columns' => RoomTypeController::getBrowseColumns(),
                            'form' => [
                                'title' => [
                                    'create' => 'Tambahkan tipe kamar baru',
                                    'edit' => 'Edit tipe kamar :name'
                                ],
                                'fields' => RoomTypeController::formCreate()->fields,
                            ],
                            'urls' => [
                                'browse' => ['GET', route('admin.room_type.index', [
                                    'per_page' => 'all',
                                    'select' => 'all',
                                ])],
                                'store' => ['POST', route('admin.room_type.store')],
                                'update' => ['POST', route('admin.room_type.update', ':key')],
                                'delete' => ['DELETE', route('admin.room_type.delete', ':key')],
                            ]
                        ]
                    ]
                ],
                [
                    'type' => 'currency',
                    'name' => 'price_per_night',
                    'label' => 'Harga kamar per malam',
                    'placeholder' => 'Harga kamar per malam',
                    'value' => null,
                    'options' => [
                        'tooltip' => 'Harga kamar per malam yang disewakan'
                    ]
                ],
                [
                    'type' => 'switch',
                    'name' => 'availability',
                    'label' => 'Ketersediaan kamar',
                    'placeholder' => 'Ketersediaan kamar',
                    'value' => null,
                    'options' => [
                        'tooltip' => 'Ketersediaan kamar yang disewakan'
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
            'page_active_label' => 'Kamar',
            'page_title' => "Tambahkan Kamar",
            'card_title' => "Form tambahkan kamar",
        ];
    }

    protected function handleStoreValidate(Request $request): void
    {

        $request->validate([
            'name' => ['required', 'unique:rooms,name'],
            'room_type_id' => ['required',],
            'price_per_night' => ['required', 'numeric'],
            'availability' => ['required', 'boolean'],
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
            'room_type_id' => ['required', 'exists:room_types,id'],
            'price_per_night' => ['required', 'numeric'],
            'availability' => ['required', 'boolean'],
            'description' => ['required'],
        ]);
    }

    protected function getShowOptions($model): object
    {
        return (object) [
            'page_active_label' => 'Detail Kamar',
            'page_title' => "Detail Kamar",
            'browse_label' => 'Kamar',
        ];
    }

    public static function showColumn($model): array
    {
        return (array)[
            ['title' => 'Foto', 'dataIndex' => 'photo', 'type' => 'image'],
            ['title' => 'Nama', 'dataIndex' => 'name', 'type' => 'text'],
            ['title' => 'Kamar', 'dataIndex' => 'room_type_id', 'type' => 'table_browse', 'options' => [
                'table_browse' => [
                    'columns' => RoomTypeController::getBrowseColumns(),
                    'urls' => [
                        'browse' => ['GET', route('admin.room_type.index', [
                            'select' => 'all',
                            'per_page' => 'all',
                            'search' => [
                                'id' => ":room_type_id"
                            ]
                        ])]
                    ],
                    'redirect_urls' => [
                        'show' => route('admin.room_type.show', [
                            'key' => ":key",
                        ])
                    ]
                ]
            ]],
            ['title' => 'Harga per malam', 'dataIndex' => 'price_per_night', 'type' => 'currency'],
            ['title' => 'Ketersediaan', 'dataIndex' => 'availability', 'type' => 'boolean'],
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
                    'name' => 'photo',
                    'label' => 'Photo',
                    'label' => 'Photo',
                    'placeholder' => 'Photo',
                    'value' => $model->photo,
                    'options' => [
                        'tooltip' => 'Photo kamar yang disewakan'
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
                    'type' => 'table_select',
                    'name' => 'room_type_id',
                    'label' => 'Tipe kamar',
                    'placeholder' => 'Tipe kamar',
                    'value' => $model->room_type_id,
                    'options' => [
                        'tooltip' => 'Tipe kamar yang disewakan',
                        'table_select' => [
                            'multiple' => false,
                            'field_selected' => [
                                'value' => 'id',
                                'label' => 'name',
                            ],
                            'title' => 'Pilih tipe kamar',
                            'columns' => RoomTypeController::getBrowseColumns(),
                            'form' => [
                                'title' => [
                                    'create' => 'Tambahkan tipe kamar baru',
                                    'edit' => 'Edit tipe kamar :name'
                                ],
                                'fields' => RoomTypeController::formCreate()->fields,
                            ],
                            'urls' => [
                                'browse' => ['GET', route('admin.room_type.index', [
                                    'per_page' => 'all',
                                    'select' => 'all',
                                ])],
                                'store' => ['POST', route('admin.room_type.store')],
                                'update' => ['POST', route('admin.room_type.update', ':key')],
                                'delete' => ['DELETE', route('admin.room_type.delete', ':key')],
                            ]
                        ]
                    ]
                ],
                [
                    'type' => 'currency',
                    'name' => 'price_per_night',
                    'label' => 'Harga kamar per malam',
                    'placeholder' => 'Harga kamar per malam',
                    'value' => $model->price_per_night,
                    'options' => [
                        'tooltip' => 'Harga kamar per malam yang disewakan'
                    ]
                ],
                [
                    'type' => 'switch',
                    'name' => 'availability',
                    'label' => 'Ketersediaan kamar',
                    'placeholder' => 'Ketersediaan kamar',
                    'value' => $model->availability,
                    'options' => [
                        'tooltip' => 'Ketersediaan kamar yang disewakan'
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
            'page_active_label' => 'Kamar',
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
