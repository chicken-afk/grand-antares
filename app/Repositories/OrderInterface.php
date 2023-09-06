<?php

namespace App\Repositories;

interface OrderInterface
{
    public function detail(string $invoice);

    public function all(array $query);

    public function payment(array $data);

    public function liveOrder();

    public function editStatus(array $data);

    public function deleteProduct(int $id);

    public function getInvoice(array $data);

    public function paymentTable(array $data, array $invoices);
}
