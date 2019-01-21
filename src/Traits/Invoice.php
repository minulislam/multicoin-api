<?php

namespace Multicoin\Api\Traits;

trait Invoice
{
    public function createInvoice()
    {
        $url      = $this->buildUrlParam('/receive');
        $response = $this->doGet($url);

        return $response;
    }

    public function unpaidInvoice()
    {
        $url      = $this->buildUrlParam('/unpaid-invoices');
        $response = $this->doGet($url);

        return $response;
    }

    public function paidInvoice()
    {
        $url      = $this->buildUrlParam('/paid-invoices');
        $response = $this->doGet($url);

        return $response;
    }
}
