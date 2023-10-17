<?php

namespace Kodeingatan\Lodging\Http\Controllers\Admin;

use App\Http\Controllers\CustomizeCRUDController;
use Illuminate\Http\Request;
use Kodeingatan\Lodging\Http\Controllers\Admin\CustomerController;
use Kodeingatan\Lodging\Http\Controllers\Admin\ReservationController;
use Kodeingatan\Lodging\Http\Controllers\Admin\RoomController;
use Kodeingatan\Lodging\Http\Controllers\Admin\ServiceController;
use Kodeingatan\Lodging\Http\Controllers\Admin\ServiceUsageController;
use Kodeingatan\Lodging\Models\Reservation;
use Kodeingatan\Lodging\Models\ServiceUsage;

class RoomReservationController extends CustomizeCRUDController
{
    protected $base_model_class_name = Reservation::class;
    protected $as_route_group_name = 'room_reservation.';

    protected function paginateResultArray($paginate)
    {
        $paginate->data = $paginate->map(function (Reservation $reservation) {

            $reservation->reservation_room_cost = $reservation->getTotalRoomCost();
            $reservation->reservation_service_cost = $reservation->getTotalServiceCost();
            $reservation->reservation_total_cost = $reservation->getTotalCost();
            $reservation->reservation_tax_total_cost = $reservation->getTaxTotalCost();
            $reservation->reservation_total_bill = $reservation->getTotalBill();

            return $reservation;
        });
        return $paginate->toArray();
    }

    public static function getBrowseColumns(): array
    {
        return [
            [
                'hidden' => true,
                'dataIndex' => 'room_id',
            ],
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
                'variable' => true,
                'type' => 'currency',
                'title' => 'Total Biaya Ruangan',
                'dataIndex' => 'reservation_room_cost',
                'key' => 'reservation_room_cost',
                'order' => 'reservation_room_cost',
                'search' => [
                    'placeholder' => 'Search pembayaran...',
                    'field' => 'reservation_room_cost'
                ],
            ],
            [
                'variable' => true,
                'type' => 'currency',
                'title' => 'Total Biaya Pelayanana',
                'dataIndex' => 'reservation_service_cost',
                'key' => 'reservation_service_cost',
                'order' => 'reservation_service_cost',
                'search' => [
                    'placeholder' => 'Search pembayaran...',
                    'field' => 'reservation_service_cost'
                ],
            ],
            [
                'variable' => true,
                'type' => 'currency',
                'title' => 'Total Pembayaran',
                'dataIndex' => 'reservation_total_cost',
                'key' => 'reservation_total_cost',
                'order' => 'reservation_total_cost',
                'search' => [
                    'placeholder' => 'Search pembayaran...',
                    'field' => 'reservation_total_cost'
                ],
            ],
            [
                'variable' => true,
                'type' => 'currency',
                'title' => 'Total Pembayaran + Pajak',
                'dataIndex' => 'reservation_tax_total_cost',
                'key' => 'reservation_tax_total_cost',
                'order' => 'reservation_tax_total_cost',
                'search' => [
                    'placeholder' => 'Search pembayaran...',
                    'field' => 'reservation_tax_total_cost'
                ],
            ],
            [
                'variable' => true,
                'type' => 'currency',
                'title' => 'Total Pembayaran Bersil',
                'dataIndex' => 'reservation_total_bill',
                'key' => 'reservation_total_bill',
                'order' => 'reservation_total_bill',
                'search' => [
                    'placeholder' => 'Search pembayaran...',
                    'field' => 'reservation_total_bill'
                ],
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

    protected function handleStoreValidate(Request $request): void
    {
        dd($request->all());
    }

    public static function formCreate(): object
    {

        $reservation_id = get_id();


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
                    'type' => 'group',
                    'title' => 'Penambahan Layanan',
                    'name' => 'addition_service',
                    'fields' => [
                        [
                            'type' => 'table_select',
                            'name' => 'addition_services',
                            'label' => 'Layanan',
                            'placeholder' => 'Layanan',
                            'value' => null,
                            'options' => [
                                'tooltip' => 'Layanan yang menyewa',
                                'table_select' => [
                                    'multiple' => true,
                                    'field_selected' => [
                                        'value' => 'id',
                                        'label' => 'name',
                                    ],
                                    'title' => 'Pilih pelanggan',
                                    'columns' => ServiceController::getBrowseColumns(),
                                    'form' => [
                                        'title' => [
                                            'create' => 'Tambahkan pelanggan baru',
                                            'edit' => 'Edit pelanggan :name'
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
                    ]
                ],
                [
                    'type' => 'group',
                    'title' => 'Pembayaran pemesanan',
                    'name' => 'payment_transactions',
                    'fields' => [
                        [
                            'type' => 'date',
                            'name' => 'transaction_date',
                            'label' => 'Tanggal transaksi',
                            'placeholder' => 'Tanggal transaksi',
                            'value' => null,
                            'options' => [
                                'tooltip' => 'Tanggal transaksi transaksi pembaran'
                            ]
                        ],
                        [
                            'type' => 'select',
                            'name' => 'payment_method',
                            'label' => 'Metode pembayaran',
                            'placeholder' => 'Metode pembayaran',
                            'value' => 'cash',
                            'options' => [
                                'tooltip' => 'Metode pembayaran transaksi pembaran',
                                'select' => [
                                    'options' => [
                                        ['value' => 'cash', 'label' => 'Cash'],
                                        ['value' => 'transfers', 'label' => 'Transfer'],
                                    ]
                                ]
                            ]
                        ],
                        [
                            'type' => 'currency',
                            'name' => 'total_cost',
                            'label' => 'Biaya Sewa',
                            'placeholder' => 'Biaya Sewa',
                            'value' => 0,
                            'options' => [
                                'tooltip' => 'Biaya Sewa transaksi pembaran',
                                'currency' => [
                                    'readonly' => true,
                                    'value' => [
                                        'on_change' => ['room_id', 'total_stay_days', 'addition_services'],
                                        'value' => ':room_id.0.price_per_night * :total_stay_days',
                                    ]
                                ]
                            ]
                        ],
                        [
                            'type' => 'currency',
                            'name' => 'tax',
                            'label' => 'Pajak Sewa',
                            'placeholder' => 'Pajak Sewa',
                            'value' => 0,
                            'options' => [
                                'tooltip' => 'Pajak sewa transaksi pembaran',
                                'currency' => [
                                    'readonly' => true,
                                    'value' => [
                                        'on_change' => 'total_cost',
                                        'value' => ':total_cost * 2/100'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'type' => 'currency',
                            'name' => 'total_bill',
                            'label' => 'Jumlah Tagihan',
                            'placeholder' => 'Jumlah Tagihan',
                            'value' => 0,
                            'options' => [
                                'tooltip' => 'Jumlah tagihan transaksi pembaran',
                                'currency' => [
                                    'readonly' => true,
                                    'value' => [
                                        'on_change' => 'tax',
                                        'value' => ':total_cost + :tax'
                                    ]
                                ]
                            ]
                        ],
                    ],
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

    protected function handleUpdateValidate(Request $request, $key): void
    {
    }

    public static function formUpdate($model): object
    {
        return (object) [];
    }
}
