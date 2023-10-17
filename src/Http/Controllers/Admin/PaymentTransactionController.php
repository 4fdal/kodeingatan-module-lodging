<?php

namespace Kodeingatan\Lodging\Http\Controllers\Admin;

use App\Http\Controllers\BaseCRUDController;
use Exception;
use Illuminate\Http\Request;
use Kodeingatan\Lodging\Models\PaymentTransaction;
use Kodeingatan\Lodging\Models\Reservation;

class PaymentTransactionController extends BaseCRUDController
{
    protected $base_model_class_name =  PaymentTransaction::class;
    protected $base_inertia_dir_path = "Admin/BaseCRUD/";
    protected $as_route_group_name = 'payment_transaction.';

    protected function getBrowseOptions(): object
    {
        return (object) [
            'page_active_label' => 'Transaksi Pembayaran',
            'page_title' => 'Browse Transaksi Pembayaran',
            'table_title' => 'Table Transaksi Pembayaran',
            'browse_label' => 'Transaksi Pembayaran',
        ];
    }

    public static function getBrowseColumns(): array
    {
        return [
            [
                'hidden' => true,
                'type' => 'relation',
                'dataIndex' => 'reservations.customer_id',
                'options' => [
                    'relation' => [
                        'foreign_key' => 'reservation_id',
                    ]
                ]
            ],
            [
                'type' => 'relation',
                'title' => 'Reservasi',
                'dataIndex' => 'customers.name',
                'key' => 'customers.name',
                'order' => 'customers.name',
                'search' => [
                    'placeholder' => 'Search nama...',
                    'field' => 'customers.name'
                ],
                'options' => [
                    'relation' => [
                        'foreign_key' => 'reservations.customer_id',
                    ],
                ]
            ],
            [
                'type' => 'date',
                'title' => 'Tanggal Transaksi',
                'dataIndex' => 'transaction_date',
                'key' => 'transaction_date',
                'order' => 'transaction_date',
                'search' => [
                    'placeholder' => 'Search tanggal transaksi...',
                    'field' => 'transaction_date',
                ]
            ],
            [
                'type' => 'badge',
                'title' => 'Metode Pembayaran',
                'dataIndex' => 'payment_method',
                'key' => 'payment_method',
                'order' => 'payment_method',
                'search' => [
                    'placeholder' => 'Search metode pembayaran...',
                    'field' => 'payment_method',
                ],
                'options' => [
                    'badge' => [
                        'value' => [
                            'cash' => [
                                'color' => 'green',
                                'label' => 'TUNAI',
                            ],
                            'transfers' => [
                                'color' => 'green',
                                'label' => 'TRANSFER',
                            ]
                        ],
                    ]
                ]
            ],
            [
                'type' => 'currency',
                'title' => 'Total Pembayaran',
                'dataIndex' => 'total_cost',
                'key' => 'total_cost',
                'order' => 'total_cost',
                'search' => [
                    'placeholder' => 'Search total pembayaran...',
                    'field' => 'total_cost',
                ]
            ],
            [
                'type' => 'currency',
                'title' => 'Pajak',
                'dataIndex' => 'tax',
                'key' => 'tax',
                'order' => 'tax',
                'search' => [
                    'placeholder' => 'Search pajak...',
                    'field' => 'tax',
                ]
            ],
            [
                'type' => 'currency',
                'title' => 'Jumlah Tagihan',
                'dataIndex' => 'total_bill',
                'key' => 'total_bill',
                'order' => 'total_bill',
                'search' => [
                    'placeholder' => 'Search jumlah tagihan...',
                    'field' => 'total_bill',
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
            'title' => 'Form penambahan transaksi pembaran',
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
                                'on_change' => 'reservation_id',
                                'get_value' => 'reservation_total_cost',
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
        ];
    }

    protected function getCreateOptions(): object
    {
        return (object) [
            'page_active_label' => 'Tambahkan',
            'page_title' => "Tambahkan Transaksi Pembayaran",
            'card_title' => "Form tambahkan transaksi pembaran",
        ];
    }

    protected function handleStoreValidate(Request $request): void
    {

        $request->validate([
            'reservation_id' => ['required', 'exists:reservations,id'],
            'transaction_date' => ['required', 'date'],
            'payment_method' => ['required', 'string'],
        ]);
    }

    protected function getDataStore(Request $request): array
    {
        $model = $this->newModel();
        $model = $this->modelRelation($model);

        $fillable  = $model->getFillable();
        $data = $request->only($fillable);

        if (in_array('key', $fillable)) {
            $data['key'] = \Str::uuid();
        }

        $reservation = Reservation::with(['room', 'serviceUsages' => function ($query) {
            return $query->with(['additionService']);
        }])->where('id', $request->reservation_id)->first();

        $room = $reservation->room;
        if (!isset($room)) throw new Exception("Kamar tidak ditemukan");

        $data['total_cost'] = $reservation->getTotalCost();
        $data['tax'] = $reservation->getTaxTotalCost();
        $data['total_bill'] = $reservation->getTotalBill();

        return $data;
    }

    protected function handleAfterStore(Request $request, $model): void
    {
    }

    protected function handleUpdateValidate(Request $request, $model): void
    {
        $request->validate([
            'reservation_id' => ['required', 'exists:reservations,id'],
            'transaction_date' => ['required', 'date'],
            'payment_method' => ['required', 'string'],
        ]);
    }

    protected function getDataUpdate(Request $request, $model): array
    {

        $fillable = [];
        foreach (get_class($this)::formUpdate($model)->fields ?? [] as $key => $value) {
            array_push($fillable, $value['name']);
        }

        $data = $request->only($fillable);

        $reservation = Reservation::with(['room', 'serviceUsages' => function ($query) {
            return $query->with(['additionService']);
        }])->where('id', $request->reservation_id)->first();

        $room = $reservation->room;
        if (!isset($room)) throw new Exception("Kamar tidak ditemukan");

        $data['total_cost'] = $reservation->getTotalCost();
        $data['tax'] = $reservation->getTaxTotalCost();
        $data['total_bill'] = $reservation->getTotalBill();

        return $data;
    }

    protected function getShowOptions($model): object
    {
        return (object) [
            'page_active_label' => 'Detail',
            'page_title' => "Detail Transaksi Pembayaran",
            'browse_label' => 'Transaksi Pembayaran',
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
            ['title' => 'Tanggal Transksi', 'dataIndex' => 'transaction_date', 'type' => 'date'],
            ['title' => 'Metode Pembayaran', 'dataIndex' => 'payment_method', 'type' => 'badge', 'options' => [
                'badge' => [
                    'value' => [
                        'cash' => [
                            'color' => 'green',
                            'label' => 'TUNAI',
                        ],
                        'transfers' => [
                            'color' => 'green',
                            'label' => 'TRANSFER',
                        ]
                    ],
                ]
            ]],
            ['title' => 'Total Biaya', 'dataIndex' => 'total_cost', 'type' => 'currency'],
            ['title' => 'Pajak Pph(2%)', 'dataIndex' => 'tax', 'type' => 'currency'],
            ['title' => 'Jumlag Tagihan', 'dataIndex' => 'total_bill', 'type' => 'currency'],
            ['title' => 'Created At', 'dataIndex' => 'created_at', 'type' => 'timestamp'],
            ['title' => 'Updated At', 'dataIndex' => 'updated_at', 'type' => 'timestamp'],
        ];
    }

    public static function formUpdate($model): object
    {
        return (object)[
            'title' => 'Form penambahan transaksi pembaran',
            'fields' =>
            [
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
                            'title' => 'Pilih reservasi pelanggan',
                            'columns' => ReservationController::getBrowseColumns(),
                            'form' => [
                                'title' => [
                                    'create' => 'Tambahkan reservasi pelanggan baru',
                                    'edit' => 'Edit reservasi pelanggan :customers.name'
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
                    'type' => 'date',
                    'name' => 'transaction_date',
                    'label' => 'Tanggal transaksi',
                    'placeholder' => 'Tanggal transaksi',
                    'value' => $model->transaction_date,
                    'options' => [
                        'tooltip' => 'Tanggal transaksi pelanggan'
                    ]
                ],
                [
                    'type' => 'select',
                    'name' => 'payment_method',
                    'label' => 'Metode pembayaran',
                    'placeholder' => 'Metode pembayaran',
                    'value' => $model->payment_method,
                    'options' => [
                        'tooltip' => 'Metode pembayaran pelanggan',
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
                    'value' => $model->total_cost,
                    'options' => [
                        'tooltip' => 'Biaya Sewa pelanggan',
                        'currency' => [
                            'readonly' => true,
                            'value' => [
                                'on_change' => 'reservation_id',
                                'get_value ' => 'reservation_total_cost',
                            ]
                        ]
                    ]
                ],
                [
                    'type' => 'currency',
                    'name' => 'tax',
                    'label' => 'Pajak Sewa',
                    'placeholder' => 'Pajak Sewa',
                    'value' => $model->tax,
                    'options' => [
                        'tooltip' => 'Pajak sewa pelanggan',
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
                    'value' => $model->total_bill,
                    'options' => [
                        'tooltip' => 'Jumlah tagihan pelanggan',
                        'currency' => [
                            'readonly' => true,
                            'value' => [
                                'on_change' => 'tax',
                                'value' => ':total_cost - :tax'
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
            'page_title' => "Edit Transaksi Pembayaran `{$model->name}`",
            'card_title' => "Form edit `{$model->name}`",
            'browse_label' => 'Transaksi Pembayaran',
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
