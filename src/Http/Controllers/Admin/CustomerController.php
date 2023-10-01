<?php

namespace Kodeingatan\Lodging\Http\Controllers\Admin;

use App\Http\Controllers\BaseCRUDController;
use Illuminate\Http\Request;
use Kodeingatan\Lodging\Models\Customer;
use Kodeingatan\Lodging\Models\Room;

class CustomerController extends BaseCRUDController
{
    protected $base_model_class_name =  Customer::class;
    protected $base_inertia_dir_path = "Admin/BaseCRUD/";
    protected $as_route_group_name = 'customer.';

    protected function getBrowseOptions(): object
    {
        return (object) [
            'page_active_label' => 'Customer',
            'page_title' => 'Browse Customer',
            'table_title' => 'Table Customer',
            'browse_label' => 'Customer',
        ];
    }

    public static function getBrowseColumns(): array
    {
        return [
            [
                'type' => 'text',
                'title' => 'Nik',
                'dataIndex' => 'identity_number',
                'key' => 'identity_number',
                'order' => 'identity_number',
                'search' => [
                    'placeholder' => 'Search nik...',
                    'field' => 'identity_number',
                ]
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
                'title' => 'Alamat',
                'dataIndex' => 'address',
                'key' => 'address',
                'order' => 'address',
                'search' => [
                    'placeholder' => 'Search alamat...',
                    'field' => 'address'
                ]
            ],
            [
                'title' => 'Email',
                'dataIndex' => 'email',
                'key' => 'email',
                'order' => 'email',
                'search' => [
                    'placeholder' => 'Search alamat email...',
                    'field' => 'email'
                ]
            ],
            [
                'title' => 'No. Hp.',
                'dataIndex' => 'phone_number',
                'key' => 'phone_number',
                'order' => 'phone_number',
                'search' => [
                    'placeholder' => 'Search nomor ponsel...',
                    'field' => 'phone_number'
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
            'title' => 'Form penambahan pelanggan',
            'fields' => [
                [
                    'type' => 'text',
                    'name' => 'identity_number',
                    'label' => 'Nik',
                    'placeholder' => 'Nik',
                    'value' => null,
                    'options' => [
                        'tooltip' => 'Nik pelanggan'
                    ]
                ],
                [
                    'type' => 'text',
                    'name' => 'name',
                    'label' => 'Nama',
                    'placeholder' => 'Nama',
                    'value' => null,
                    'options' => [
                        'tooltip' => 'Nama pelanggan'
                    ]
                ],
                [
                    'type' => 'email',
                    'name' => 'email',
                    'label' => 'Email',
                    'placeholder' => 'Email',
                    'value' => null,
                    'options' => [
                        'tooltip' => 'Email pelanggan'
                    ]
                ],
                [
                    'type' => 'text',
                    'name' => 'phone_number',
                    'label' => 'No. Ponsel',
                    'placeholder' => 'No. Ponsel',
                    'value' => null,
                    'options' => [
                        'tooltip' => 'No. Ponsel pelanggan'
                    ]
                ],
                [
                    'type' => 'textarea',
                    'name' => 'address',
                    'label' => 'Alamat',
                    'placeholder' => 'Alamat',
                    'value' => null,
                    'options' => [
                        'tooltip' => 'Alamat pelanggan'
                    ]
                ],

            ],
        ];
    }

    protected function getCreateOptions(): object
    {
        return (object) [
            'page_active_label' => 'Tambahkan',
            'page_title' => "Tambahkan Pelanggan",
            'card_title' => "Form tambahkan pelanggan",
        ];
    }

    protected function handleStoreValidate(Request $request): void
    {

        $request->validate([
            'identity_number' => ['required', 'unique:customers,identity_number'],
            'name' => ['required', 'string'],
            'address' => ['required', 'string'],
            'email' => ['required', 'string'],
            'phone_number' => ['required', 'numeric'],
        ]);
    }

    protected function handleAfterStore(Request $request, $model): void
    {
    }

    protected function handleUpdateValidate(Request $request, $model): void
    {
        $request->validate([
            'identity_number' => ['required', 'unique:customers,identity_number,' . $model->id],
            'name' => ['required', 'string'],
            'address' => ['required', 'string'],
            'email' => ['required', 'string'],
            'phone_number' => ['required', 'numeric'],
        ]);
    }

    protected function getShowOptions($model): object
    {
        return (object) [
            'page_active_label' => 'Detail',
            'page_title' => "Detail Pelanggan",
            'browse_label' => 'Pelanggan',
        ];
    }

    public static function showColumn($model): array
    {
        return (array)[
            ['title' => 'Nik', 'dataIndex' => 'identity_number', 'type' => 'text'],
            ['title' => 'Nama', 'dataIndex' => 'name', 'type' => 'text'],
            ['title' => 'Alamat', 'dataIndex' => 'address', 'type' => 'text'],
            ['title' => 'Email', 'dataIndex' => 'email', 'type' => 'text'],
            ['title' => 'No. Hp.', 'dataIndex' => 'phone_number', 'type' => 'text'],
            ['title' => 'Created At', 'dataIndex' => 'created_at', 'type' => 'timestamp'],
            ['title' => 'Updated At', 'dataIndex' => 'updated_at', 'type' => 'timestamp'],
        ];
    }

    public static function formUpdate($model): object
    {
        return (object)[
            'title' => 'Form penambahan pelanggan',
            'fields' => [
                [
                    'type' => 'text',
                    'name' => 'identity_number',
                    'label' => 'Nik',
                    'placeholder' => 'Nik',
                    'value' => $model->identity_number,
                    'options' => [
                        'tooltip' => 'Nik pelanggan'
                    ]
                ],
                [
                    'type' => 'text',
                    'name' => 'name',
                    'label' => 'Nama',
                    'placeholder' => 'Nama',
                    'value' => $model->name,
                    'options' => [
                        'tooltip' => 'Nama pelanggan'
                    ]
                ],
                [
                    'type' => 'email',
                    'name' => 'email',
                    'label' => 'Email',
                    'placeholder' => 'Email',
                    'value' => $model->email,
                    'options' => [
                        'tooltip' => 'Email pelanggan'
                    ]
                ],
                [
                    'type' => 'text',
                    'name' => 'phone_number',
                    'label' => 'No. Ponsel',
                    'placeholder' => 'No. Ponsel',
                    'value' => $model->phone_number,
                    'options' => [
                        'tooltip' => 'No. Ponsel pelanggan'
                    ]
                ],
                [
                    'type' => 'textarea',
                    'name' => 'address',
                    'label' => 'Alamat',
                    'placeholder' => 'Alamat',
                    'value' => $model->address,
                    'options' => [
                        'tooltip' => 'Alamat pelanggan'
                    ]
                ],
            ]
        ];
    }

    protected function getUpdateOptions($model): object
    {
        return (object) [
            'page_active_label' => 'Edit',
            'page_title' => "Edit Pelanggan `{$model->name}`",
            'card_title' => "Form edit `{$model->name}`",
            'browse_label' => 'Pelanggan',
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
