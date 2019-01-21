<?php

namespace Multicoin\Api\Traits;

trait Invoice
{
    public function __construct()
    {
        parent::construct();
    }

    public function createInvoice()
    {
        /**
         * [ GET api/v1/{coin}/receive ]
         */
        $url      = $this->coin.'/receive';
        $response = $this->doGet($url);
        return $response;
    }

    public function unpaidInvoice()
    {
        /**
         * [ GET api/v1/{coin}/unpaid-invoices ]
         */
        $url      = $this->coin.'/addr/'.'/unpaid-invoices';
        $response = $this->doGet($url);
        return $response;
    }

    public function paidInvoice()
    {
        /**
         * [ GET api/v1/{coin}/paid-invoices ]
         */
        $url      = $this->coin.'/addr/'.'/unpaid-invoices';
        $response = $this->doGet($url);
        return $response;
    }

}
