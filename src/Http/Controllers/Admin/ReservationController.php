<?php

namespace Kodeingatan\Lodging\Http\Controllers\Admin;

use App\Http\Controllers\BaseCRUDController;
use Illuminate\Http\Request;
use Kodeingatan\Lodging\Models\Reservation;

class ReservationController extends BaseCRUDController
{
    protected $base_model_class_name =  Reservation::class;
    protected $base_inertia_dir_path = "Admin/BaseCRUD/";
    protected $as_route_group_name = 'reservation.';

    protected function getBrowseOptions(): object
    {
        return (object) [
            'page_active_label' => 'Reservasi',
            'page_title' => 'Browse Reservasi',
            'table_title' => 'Table Reservasi',
            'browse_label' => 'Reservasi',
        ];
    }

    public static function getBrowseColumns(): array
    {
        return [
            [
                'type' => 'relation',
                'title' => 'Nama Pelanggan',
                'dataIndex' => 'customers.name',
                'key' => 'customers.name',
                'order' => 'customers.name',
                'search' => [
                    'placeholder' => 'Search nama...',
                    'field' => 'customers.name'
                ],
                'options' => [
                    'relation' => [
                        'foreign_key' => 'reservations.customer_id'
                    ]
                ]
            ],
            [
                'type' => 'relation',
                'title' => 'Kamar',
                'dataIndex' => 'rooms.name',
                'key' => 'rooms.name',
                'order' => 'rooms.name',
                'search' => [
                    'placeholder' => 'Search nama...',
                    'field' => 'rooms.name'
                ],
                'options' => [
                    'relation' => [
                        'foreign_key' => 'reservations.room_id'
                    ]
                ]
            ],
            [
                'title' => 'Berapa Malam',
                'dataIndex' => 'total_stay_days',
                'key' => 'total_stay_days',
                'order' => 'total_stay_days',
                'search' => [
                    'placeholder' => 'Search nama...',
                    'field' => 'total_stay_days'
                ],
            ],
            [
                'type' => 'date',
                'title' => 'Tanggal Checkin',
                'dataIndex' => 'checkin_date',
                'key' => 'checkin_date',
                'order' => 'checkin_date',
                'search' => [
                    'placeholder' => 'Search nama...',
                    'field' => 'checkin_date'
                ],
            ],
            [
                'type' => 'date',
                'title' => 'Tanggal Checkout',
                'dataIndex' => 'checkout_date',
                'key' => 'checkout_date',
                'order' => 'checkout_date',
                'search' => [
                    'placeholder' => 'Search nama...',
                    'field' => 'checkout_date'
                ],
            ],
            [
                'type' => 'badge',
                'title' => 'Status',
                'dataIndex' => 'status',
                'key' => 'status',
                'order' => 'status',
                'options' => [
                    'badge' => [
                        'value' => [
                            'process' => [
                                'color' => 'red',
                                'label' => 'PROSES',
                            ],
                            'done' => [
                                'color' => 'lightgreen',
                                'label' => 'SELESAI',
                            ]
                        ],
                    ]
                ]
            ],
            [
                'type' => 'badge',
                'title' => 'Status Pembayaran',
                'dataIndex' => 'payment_status',
                'key' => 'payment_status',
                'order' => 'payment_status',
                'options' => [
                    'badge' => [
                        'value' => [
                            'process' => [
                                'color' => 'red',
                                'label' => 'PROSES',
                            ],
                            'done' => [
                                'color' => 'lightgreen',
                                'label' => 'SELESAI',
                            ]
                        ],
                    ]
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
                    'name' => 'customer_id',
                    'label' => 'Pelanggan',
                    'placeholder' => 'Pelanggan',
                    'value' => null,
                    'options' => [
                        'tooltip' => 'Pelanggan yang menyewa',
                        'table_select' => [
                            'multiple' => false,
                            'field_selected' => [
                                'value' => 'id',
                                'label' => 'name',
                            ],
                            'title' => 'Pilih pelanggan',
                            'columns' => CustomerController::getBrowseColumns(),
                            'form' => [
                                'title' => [
                                    'create' => 'Tambahkan pelanggan baru',
                                    'edit' => 'Edit pelanggan :name'
                                ],
                                'fields' => CustomerController::formCreate()->fields,
                            ],
                            'urls' => [
                                'browse' => ['GET', route('admin.customer.index', [
                                    'per_page' => 'all',
                                    'select' => 'all',
                                ])],
                                'store' => ['POST', route('admin.customer.store')],
                                'update' => ['POST', route('admin.customer.update', ':key')],
                                'delete' => ['DELETE', route('admin.customer.delete', ':key')],
                            ]
                        ]
                    ]
                ],
                [
                    'type' => 'table_select',
                    'name' => 'room_id',
                    'label' => 'Kamar',
                    'placeholder' => 'Kamar',
                    'value' => null,
                    'options' => [
                        'tooltip' => 'Kamar yang disewa',
                        'table_select' => [
                            'multiple' => false,
                            'field_selected' => [
                                'value' => 'id',
                                'label' => 'name',
                            ],
                            'title' => 'Pilih kamar',
                            'columns' => RoomController::getBrowseColumns(),
                            'form' => [
                                'title' => [
                                    'create' => 'Tambahkan kamar baru',
                                    'edit' => 'Edit kamar :name'
                                ],
                                'fields' => RoomController::formCreate()->fields,
                            ],
                            'urls' => [
                                'browse' => ['GET', route('admin.room.index', [
                                    'per_page' => 'all',
                                    'select' => 'all',
                                ])],
                                'store' => ['POST', route('admin.room.store')],
                                'update' => ['POST', route('admin.room.update', ':key')],
                                'delete' => ['DELETE', route('admin.room.delete', ':key')],
                            ]
                        ]
                    ]
                ],
                [
                    'type' => 'number',
                    'name' => 'total_stay_days',
                    'label' => 'Lama sewa per malam',
                    'placeholder' => 'Lama sewa per malam',
                    'value' => null,
                    'options' => [
                        'tooltip' => 'Lama sewa per malam'
                    ]
                ],
                [
                    'type' => 'date',
                    'name' => 'checkin_date',
                    'label' => 'Tanggal checkin',
                    'placeholder' => 'Tanggal checkin',
                    'value' => null,
                    'options' => [
                        'tooltip' => 'Tanggal checkin'
                    ]
                ],
                [
                    'type' => 'date',
                    'name' => 'checkout_date',
                    'label' => 'Tanggal Checkout',
                    'placeholder' => 'Tanggal Checkout',
                    'value' => null,
                    'options' => [
                        'tooltip' => 'Tanggal Checkout'
                    ]
                ],
                [
                    'type' => 'select',
                    'name' => 'status',
                    'label' => 'Status',
                    'placeholder' => 'Status',
                    'value' => 'process',
                    'options' => [
                        'tooltip' => 'Status yang disewakan',
                        'select' => [
                            'options' => [
                                ['label' => 'Proses', 'value' => 'process'],
                                ['label' => 'Selesai', 'value' => 'done']
                            ]
                        ]
                    ]
                ],
                [
                    'type' => 'select',
                    'name' => 'payment_status',
                    'label' => 'Status Pembayaran',
                    'placeholder' => 'Status Pembayaran',
                    'value' => 'process',
                    'options' => [
                        'tooltip' => 'Status pembayaran yang disewakan',
                        'select' => [
                            'options' => [
                                ['label' => 'Proses', 'value' => 'process'],
                                ['label' => 'Selesai', 'value' => 'done']
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
            'page_active_label' => 'Reservasi',
            'page_title' => "Tambahkan Reservasi",
            'card_title' => "Form tambahkan kamar",
        ];
    }

    protected function handleStoreValidate(Request $request): void
    {

        $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'room_id' => ['required', 'exists:rooms,id'],
            'total_stay_days' => ['required', 'numeric'],
            'checkin_date' => ['required', 'date'],
            'checkout_date' => ['required', 'date'],
            'status' => ['required', 'string'],
            'payment_status' => ['required', 'string'],
        ]);
    }

    protected function handleAfterStore(Request $request, $model): void
    {
    }

    protected function handleUpdateValidate(Request $request, $model): void
    {
        $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'room_id' => ['required', 'exists:rooms,id'],
            'total_stay_days' => ['required', 'numeric'],
            'checkin_date' => ['required', 'date'],
            'checkout_date' => ['required', 'date'],
            'status' => ['required', 'string'],
            'payment_status' => ['required', 'string'],
        ]);
    }

    protected function getShowOptions($model): object
    {
        return (object) [
            'page_active_label' => 'Detail',
            'page_title' => "Detail Reservasi",
            'browse_label' => 'Reservasi',
        ];
    }

    public static function showColumn($model): array
    {
        return (array)[
            ['title' => 'Reservasi', 'dataIndex' => 'customers_id', 'type' => 'table_browse', 'options' => [
                'table_browse' => [
                    'columns' => CustomerController::getBrowseColumns(),
                    'urls' => [
                        'browse' => ['GET', route('admin.customer.index', [
                            'select' => 'all',
                            'per_page' => 'all',
                            'search' => [
                                'id' => ":customer_id"
                            ]
                        ])]
                    ],
                    'redirect_urls' => [
                        'show' => route('admin.customer.show', [
                            'key' => ":key",
                        ])
                    ]
                ]
            ]],
            ['title' => 'Kamar', 'dataIndex' => 'room_id', 'type' => 'table_browse', 'options' => [
                'table_browse' => [
                    'columns' => RoomController::getBrowseColumns(),
                    'urls' => [
                        'browse' => ['GET', route('admin.room.index', [
                            'select' => 'all',
                            'per_page' => 'all',
                            'search' => [
                                'id' => ":room_id"
                            ]
                        ])]
                    ],
                    'redirect_urls' => [
                        'show' => route('admin.room.show', [
                            'key' => ":key",
                        ])
                    ]
                ]
            ]],
            ['title' => 'Lama Menginap', 'dataIndex' => 'total_stay_days', 'type' => 'number'],
            ['title' => 'Tanggal Checkin', 'dataIndex' => 'checkin_date', 'type' => 'date'],
            ['title' => 'Tanggal Checkout', 'dataIndex' => 'checkout_date', 'type' => 'date'],
            ['title' => 'Status ', 'dataIndex' => 'status', 'type' => 'badge', 'options' => [
                'badge' => [
                    'value' => [
                        'process' => [
                            'color' => 'red',
                            'label' => 'PROSES',
                        ],
                        'done' => [
                            'color' => 'lightgreen',
                            'label' => 'SELESAI',
                        ]
                    ],
                ]
            ]],
            ['title' => 'Status Pembayaran', 'dataIndex' => 'payment_status', 'type' => 'badge', 'options' => [
                'badge' => [
                    'value' => [
                        'process' => [
                            'color' => 'red',
                            'label' => 'PROSES',
                        ],
                        'done' => [
                            'color' => 'lightgreen',
                            'label' => 'SELESAI',
                        ]
                    ],
                ]
            ]],
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
                    'name' => 'customer_id',
                    'label' => 'Pelanggan',
                    'placeholder' => 'Pelanggan',
                    'value' => $model->customer_id,
                    'options' => [
                        'tooltip' => 'Pelanggan yang menyewa',
                        'table_select' => [
                            'multiple' => false,
                            'field_selected' => [
                                'value' => 'id',
                                'label' => 'name',
                            ],
                            'title' => 'Pilih pelanggan',
                            'columns' => CustomerController::getBrowseColumns(),
                            'form' => [
                                'title' => [
                                    'create' => 'Tambahkan pelanggan baru',
                                    'edit' => 'Edit pelanggan :name'
                                ],
                                'fields' => CustomerController::formCreate()->fields,
                            ],
                            'urls' => [
                                'browse' => ['GET', route('admin.customer.index', [
                                    'per_page' => 'all',
                                    'select' => 'all',
                                ])],
                                'store' => ['POST', route('admin.customer.store')],
                                'update' => ['POST', route('admin.customer.update', ':key')],
                                'delete' => ['DELETE', route('admin.customer.delete', ':key')],
                            ]
                        ]
                    ]
                ],
                [
                    'type' => 'table_select',
                    'name' => 'room_id',
                    'label' => 'Kamar',
                    'placeholder' => 'Kamar',
                    'value' => $model->room_id,
                    'options' => [
                        'tooltip' => 'Kamar yang disewa',
                        'table_select' => [
                            'multiple' => false,
                            'field_selected' => [
                                'value' => 'id',
                                'label' => 'name',
                            ],
                            'title' => 'Pilih kamar',
                            'columns' => RoomController::getBrowseColumns(),
                            'form' => [
                                'title' => [
                                    'create' => 'Tambahkan kamar baru',
                                    'edit' => 'Edit kamar :name'
                                ],
                                'fields' => RoomController::formCreate()->fields,
                            ],
                            'urls' => [
                                'browse' => ['GET', route('admin.room.index', [
                                    'per_page' => 'all',
                                    'select' => 'all',
                                ])],
                                'store' => ['POST', route('admin.room.store')],
                                'update' => ['POST', route('admin.room.update', ':key')],
                                'delete' => ['DELETE', route('admin.room.delete', ':key')],
                            ]
                        ]
                    ]
                ],
                [
                    'type' => 'number',
                    'name' => 'total_stay_days',
                    'label' => 'Lama sewa per malam',
                    'placeholder' => 'Lama sewa per malam',
                    'value' => $model->total_stay_days,
                    'options' => [
                        'tooltip' => 'Lama sewa per malam'
                    ]
                ],
                [
                    'type' => 'date',
                    'name' => 'checkin_date',
                    'label' => 'Tanggal checkin',
                    'placeholder' => 'Tanggal checkin',
                    'value' => $model->checkin_date,
                    'options' => [
                        'tooltip' => 'Tanggal checkin'
                    ]
                ],
                [
                    'type' => 'date',
                    'name' => 'checkout_date',
                    'label' => 'Tanggal Checkout',
                    'placeholder' => 'Tanggal Checkout',
                    'value' => $model->checkout_date,
                    'options' => [
                        'tooltip' => 'Tanggal Checkout'
                    ]
                ],
                [
                    'type' => 'select',
                    'name' => 'status',
                    'label' => 'Status',
                    'placeholder' => 'Status',
                    'value' => $model->status,
                    'options' => [
                        'tooltip' => 'Status yang disewakan',
                        'select' => [
                            'options' => [
                                ['label' => 'Proses', 'value' => 'process'],
                                ['label' => 'Selesai', 'value' => 'done']
                            ]
                        ]
                    ]
                ],
                [
                    'type' => 'select',
                    'name' => 'payment_status',
                    'label' => 'Status Pembayaran',
                    'placeholder' => 'Status Pembayaran',
                    'value' => $model->payment_status,
                    'options' => [
                        'tooltip' => 'Status pembayaran yang disewakan',
                        'select' => [
                            'options' => [
                                ['label' => 'Proses', 'value' => 'process'],
                                ['label' => 'Selesai', 'value' => 'done']
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
            'page_title' => "Edit Reservasi {$model->name}",
            'card_title' => "Form edit {$model->name}",
            'browse_label' => 'Reservasi',
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
