<?php

namespace Multicoin\Api\Traits;

trait Invoice
{
    public function createInvoice(array $params = [])
    {
        $defaultParams = [
            'user_id'  => '',
            'callback' => '',
            'forward'  => 0,
            'amount'   => 0.00,
            'address'  => '',
        ];
        //$data = array_merge($defaultParams, $params);
        $data = array_values(array_filter(array_merge($defaultParams, $params)));
        $url  = $this->buildUrlParam('/receive');
        $url .= '?'.http_build_query($data);
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
