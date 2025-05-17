<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    protected $invoices;
    protected $customer;
    protected $paymentDetail;
    public function __construct()
    {
        // Initialize invoices array here
        $this->invoices = [
            1 => [
                [
                    'product_id' => 1,
                    'name' => 'Polo Wear',
                    'description' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                    'size' => 'xxl',
                    'qty' => 2,
                    'price' => 200000,
                    'total' => 400000,
                ],
                [
                    'product_id' => 2,
                    'name' => 'Polo Wear',
                    'description' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                    'size' => 'xxl',
                    'qty' => 1,
                    'price' => 200000,
                    'total' => 200000,
                ],
                [
                    'product_id' => 3,
                    'name' => 'Polo Wear',
                    'description' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                    'size' => 'xxl',
                    'qty' => 3,
                    'price' => 200000,
                    'total' => 600000,
                ],
            ],
            2 => [
                [
                    'product_id' => 1,
                    'name' => 'Polo Wear',
                    'description' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                    'size' => 'xxl',
                    'qty' => 2,
                    'price' => 200000,
                    'total' => 400000,
                ],
                [
                    'product_id' => 2,
                    'name' => 'Polo Wear',
                    'description' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                    'size' => 'xxl',
                    'qty' => 1,
                    'price' => 200000,
                    'total' => 200000,
                ],
                [
                    'product_id' => 3,
                    'name' => 'Polo Wear',
                    'description' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                    'size' => 'xxl',
                    'qty' => 3,
                    'price' => 200000,
                    'total' => 600000,
                ],
            ],
        ];

        // Initialize customer data here
        $this->customer = [
            1 => [
                'name' => 'John Doe',
                'address' => '123 Main St, City, Country',
                'phone' => '123-456-7890',
                'email' => 'john@gmail.com'
            ],
            2 => [
                'name' => 'Kevin',
                'address' => '456 Main St, City, Country',
                'phone' => '0899-1829-2020',
                'email' => 'kevin@gmail.com'
            ]
        ];

        $this->paymentDetail = [
            1 => [
                'payment_method' => 'Credit Card',
                'payment_status' => 'Paid',
                'payment_date' => '2023-10-01',
            ],
            2 => [
                'payment_method' => 'Bank Transfer',
                'payment_status' => 'Pending',
                'payment_date' => '2023-10-02'
            ]
        ];
    }
     public function index($sales_id)
    {
        return view('invoice.index', [
            'invoice' => $this->invoices[$sales_id],
            'sales_id' => $sales_id,
            'customer' => $this->customer[$sales_id],
            'payment' => $this->paymentDetail[$sales_id]
        ]);
    }
}
