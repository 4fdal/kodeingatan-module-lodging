<?php

namespace Kodeingatan\Lodging\Http\Controllers\Admin;

use App\Http\Controllers\BaseCRUDController;
use Illuminate\Http\Request;
use Kodeingatan\Lodging\Models\ServiceUsage;
use Kodeingatan\Lodging\Models\Room;

class ServiceUsageController extends BaseCRUDController
{
    protected $base_model_class_name =  ServiceUsage::class;
    protected $base_inertia_dir_path = "Admin/BaseCRUD/";
    protected $as_route_group_name = 'service_usage.';

    protected function getBrowseOptions(): object
    {
        return (object) [
            'page_active_label' => 'Penggunaan Layanan Digunankan',
            'page_title' => 'Browse Penggunaan Layanan Digunankan',
            'table_title' => 'Table Penggunaan Layanan Digunankan',
            'browse_label' => 'Penggunaan Layanan Digunankan',
        ];
    }

    public static function getBrowseColumns(): array
    {
        return [
            [
                'type' => 'relation',
                'hidden' => true,
                'dataIndex' => 'reservations.customer_id',
                'options' => [
                    'relation' => [
                        'foreignKey' => 'service_usages.reservation_id'
                    ]
                ]
            ],
            [
                'type' => 'relation',
                'title' => 'Nama Layanan Digunankan',
                'dataIndex' => 'additional_services.name',
                'key' => 'additional_services.name',
                'order' => 'additional_services.name',
                'search' => [
                    'placeholder' => 'Search nama layanan...',
                    'field' => 'additional_services.name'
                ],
                'options' => [
                    'relations' => [
                        'foreignKey' => 'service_usages.additional_service_id'
                    ]
                ]
            ],
            [
                'type' => 'relation',
                'title' => 'Nama Pelanggan',
                'dataIndex' => 'customers.name',
                'key' => 'customers.name',
                'order' => 'customers.name',
                'search' => [
                    'placeholder' => 'Search nama pelanggan...',
                    'field' => 'customers.name'
                ],
                'options' => [
                    'relations' => [
                        'foreignKey' => 'reservations.customer_id'
                    ]
                ]
            ],
            [
                'title' => 'Qty',
                'dataIndex' => 'number_of_uses',
                'key' => 'number_of_uses',
                'order' => 'number_of_uses',
                'search' => [
                    'placeholder' => 'Search nama...',
                    'field' => 'number_of_uses'
                ]
            ],
            [
                'type' => 'currency',
                'title' => 'Total Harga Layanan Digunankan',
                'dataIndex' => 'total_service_cost',
                'key' => 'total_service_cost',
                'order' => 'total_service_cost',
                'search' => [
                    'placeholder' => 'Search nama...',
                    'field' => 'total_service_cost'
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
                    'type' => 'table_select',
                    'name' => 'reservation_id',
                    'label' => 'Reservasi Pelanggan',
                    'placeholder' => 'Reservasi Pelanggan',
                    'value' => null,
                    'options' => [
                        'tooltip' => 'Reservasi pelanggan penyewa',
                        'table_select' => [
                            'multiple' => false,
                            'field_selected' => [
                                'value' => 'id',
                                'label' => 'customers.name',
                            ],
                            'title' => 'Pilih reservasi transaksi pembaran',
                            'columns' => ReservationController::getBrowseColumns(),
                            'form' => [
                                'title' => [
                                    'create' => 'Tambahkan reservasi transaksi pembaran baru',
                                    'edit' => 'Edit reservasi transaksi pembaran :customers.name'
                                ],
                                'fields' => ReservationController::formCreate()->fields,
                            ],
                            'urls' => [
                                'browse' => ['GET', route('admin.reservation.index', [
                                    'per_page' => 'all',
                                    'select' => 'all',
                                ])],
                                'store' => ['POST', route('admin.reservation.store')],
                                'update' => ['POST', route('admin.reservation.update', ':key')],
                                'delete' => ['DELETE', route('admin.reservation.delete', ':key')],
                            ]
                        ]
                    ]
                ],
                [
                    'type' => 'table_select',
                    'name' => 'additional_service_id',
                    'label' => 'Layanan Digunankan',
                    'placeholder' => 'Layanan Digunankan',
                    'value' => null,
                    'options' => [
                        'tooltip' => 'Layanan pelanggan penyewa',
                        'table_select' => [
                            'multiple' => false,
                            'field_selected' => [
                                'value' => 'id',
                                'label' => 'additional_services.name',
                            ],
                            'title' => 'Pilih layanan',
                            'columns' => ServiceController::getBrowseColumns(),
                            'form' => [
                                'title' => [
                                    'create' => 'Tambahkan layanan baru',
                                    'edit' => 'Edit layanan :additional_services.name'
                                ],
                                'fields' => ServiceController::formCreate()->fields,
                            ],
                            'urls' => [
                                'browse' => ['GET', route('admin.additional_service.index', [
                                    'per_page' => 'all',
                                    'select' => 'all',
                                ])],
                                'store' => ['POST', route('admin.additional_service.store')],
                                'update' => ['POST', route('admin.additional_service.update', ':key')],
                                'delete' => ['DELETE', route('admin.additional_service.delete', ':key')],
                            ]
                        ]
                    ]
                ],
                [
                    'type' => 'number',
                    'name' => 'number_of_uses',
                    'label' => 'Qyt',
                    'placeholder' => 'Qyt',
                    'value' => null,
                    'options' => [
                        'tooltip' => 'Qyt layanan yang disewakan',
                    ]
                ],
                [
                    'type' => 'currency',
                    'name' => 'total_service_cost',
                    'label' => 'Total harga layanan',
                    'placeholder' => 'Total harga layanan',
                    'value' => null,
                    'options' => [
                        'tooltip' => 'Total harga layanan',
                        'currency' => [
                            'readonly' => true,
                            'value' => [
                                'on_change' => 'additional_service_id',
                                'get_value' => 'price',
                                'value' => ':price * :number_of_uses'
                            ]
                        ]
                    ]
                ],
            ],
        ];
    }

    protected function getCreateOptions(): object
    {
        return (object) [
            'page_active_label' => 'Tambahkan',
            'page_title' => "Tambahkan layana baru",
            'card_title' => "Form tambahkan layanan",
        ];
    }

    protected function handleStoreValidate(Request $request): void
    {

        $request->validate([
            'additional_service_id' => ['required', 'exists:additional_services,id'],
            'reservation_id' => ['required', 'exists:reservations,id'],
            'number_of_uses' => ['required', 'numeric'],
            'total_service_cost' => ['required', 'numeric'],
        ]);
    }

    protected function handleAfterStore(Request $request, $model): void
    {
    }

    protected function handleUpdateValidate(Request $request, $model): void
    {
        $request->validate([
            'additional_service_id' => ['required', 'exists:additional_services,id'],
            'reservation_id' => ['required', 'exists:reservations,id'],
            'number_of_uses' => ['required', 'numeric'],
            'total_service_cost' => ['required', 'numeric'],
        ]);
    }

    protected function getShowOptions($model): object
    {
        return (object) [
            'page_active_label' => 'Detail',
            'page_title' => "Detail Layanan Digunakan",
            'browse_label' => 'Layanan Digunankan',
        ];
    }

    public static function showColumn($model): array
    {
        return (array)[
            ['title' => 'Reservasi Pelanggan', 'dataIndex' => 'reservation_id', 'type' => 'table_browse', 'options' => [
                'table_browse' => [
                    'columns' => ReservationController::getBrowseColumns(),
                    'urls' => [
                        'browse' => ['GET', route('admin.reservation.index', [
                            'select' => 'all',
                            'per_page' => 'all',
                            'search' => [
                                'id' => ":reservation_id"
                            ]
                        ])]
                    ],
                    'redirect_urls' => [
                        'show' => route('admin.reservation.show', [
                            'key' => ":key",
                        ])
                    ]
                ]
            ]],
            ['title' => 'Layanan', 'dataIndex' => 'additional_service_id', 'type' => 'table_browse', 'options' => [
                'table_browse' => [
                    'columns' => ReservationController::getBrowseColumns(),
                    'urls' => [
                        'browse' => ['GET', route('admin.additional_service.index', [
                            'select' => 'all',
                            'per_page' => 'all',
                            'search' => [
                                'id' => ":additional_service_id"
                            ]
                        ])]
                    ],
                    'redirect_urls' => [
                        'show' => route('admin.additional_service.show', [
                            'key' => ":key",
                        ])
                    ]
                ]
            ]],
            ['title' => 'Qty', 'dataIndex' => 'number_of_uses', 'type' => 'number'],
            ['title' => 'Total Harga Layanan', 'dataIndex' => 'total_service_cost', 'type' => 'currency'],
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
                    'type' => 'table_select',
                    'name' => 'reservation_id',
                    'label' => 'Reservasi Pelanggan',
                    'placeholder' => 'Reservasi Pelanggan',
                    'value' => $model->reservation_id,
                    'options' => [
                        'tooltip' => 'Reservasi pelanggan penyewa',
                        'table_select' => [
                            'multiple' => false,
                            'field_selected' => [
                                'value' => 'id',
                                'label' => 'customers.name',
                            ],
                            'title' => 'Pilih reservasi transaksi pembaran',
                            'columns' => ReservationController::getBrowseColumns(),
                            'form' => [
                                'title' => [
                                    'create' => 'Tambahkan reservasi transaksi pembaran baru',
                                    'edit' => 'Edit reservasi transaksi pembaran :customers.name'
                                ],
                                'fields' => ReservationController::formCreate()->fields,
                            ],
                            'urls' => [
                                'browse' => ['GET', route('admin.reservation.index', [
                                    'per_page' => 'all',
                                    'select' => 'all',
                                ])],
                                'store' => ['POST', route('admin.reservation.store')],
                                'update' => ['POST', route('admin.reservation.update', ':key')],
                                'delete' => ['DELETE', route('admin.reservation.delete', ':key')],
                            ]
                        ]
                    ]
                ],
                [
                    'type' => 'table_select',
                    'name' => 'additional_service_id',
                    'label' => 'Layanan Digunankan',
                    'placeholder' => 'Layanan Digunankan',
                    'value' => $model->additional_service_id,
                    'options' => [
                        'tooltip' => 'Layanan pelanggan penyewa',
                        'table_select' => [
                            'multiple' => false,
                            'field_selected' => [
                                'value' => 'id',
                                'label' => 'additional_services.name',
                            ],
                            'title' => 'Pilih layanan',
                            'columns' => ServiceController::getBrowseColumns(),
                            'form' => [
                                'title' => [
                                    'create' => 'Tambahkan layanan baru',
                                    'edit' => 'Edit layanan :additional_services.name'
                                ],
                                'fields' => ServiceController::formCreate()->fields,
                            ],
                            'urls' => [
                                'browse' => ['GET', route('admin.additional_service.index', [
                                    'per_page' => 'all',
                                    'select' => 'all',
                                ])],
                                'store' => ['POST', route('admin.additional_service.store')],
                                'update' => ['POST', route('admin.additional_service.update', ':key')],
                                'delete' => ['DELETE', route('admin.additional_service.delete', ':key')],
                            ]
                        ]
                    ]
                ],
                [
                    'type' => 'number',
                    'name' => 'number_of_uses',
                    'label' => 'Qyt',
                    'placeholder' => 'Qyt',
                    'value' => $model->number_of_uses,
                    'options' => [
                        'tooltip' => 'Qyt layanan yang disewakan',
                    ]
                ],
                [
                    'type' => 'currency',
                    'name' => 'total_service_cost',
                    'label' => 'Total harga layanan',
                    'placeholder' => 'Total harga layanan',
                    'value' => $model->total_service_cost,
                    'options' => [
                        'tooltip' => 'Total harga layanan',
                        'currency' => [
                            'readonly' => true,
                            'value' => [
                                'on_change' => 'additional_service_id',
                                'get_value' => 'price',
                                'value' => ':price * :number_of_uses'
                            ]
                        ]
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
