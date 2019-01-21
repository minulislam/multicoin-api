<?php

namespace Multicoin\Api\Traits;

trait Invoice
{
    public function createInvoice(array $param = [])
    {
        $default = [
            'user_id'  => '',
            'callback' => '',
            'forward'  => '0',
            'amount'   => '0.00',
            'address'  => '',
        ];

        $url = $this->buildUrl('/receive');
        $url .= '?'.$this->buildQueryParam($default, $param);
        $response = $this->doGet($url);

        return $response;
    }

    public function unpaidInvoice()
    {
        $url = $this->buildUrl('/unpaid-invoices');
        $response = $this->doGet($url);

        return $response;
    }

    public function paidInvoice()
    {
        $url = $this->buildUrl('/paid-invoices');
        $response = $this->doGet($url);

        return $response;
    }
}
