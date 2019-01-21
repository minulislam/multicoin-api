<?php
namespace Multicoin\Api\Traits;

trait Transaction
{
    /*public function __construct()
    {
        parent::construct();
    }*/

    public function transactionsFromDb()
    {
        /**
         * [ GET api/v1/{coin}/{address}/txfromdb ]
         */
        $url      = $this->buildUrlParam('/'.$this->address.'/txfromdb');
        $response = $this->doGet($url);
        return $response;
    }

    public function transactionsFromApi()
    {
        /**
         * [ GET api/v1/{coin}/{address}/txfromapi ]
         */
        $url      = $this->buildUrlParam('/'.$this->address.'/txfromapi');
        $response = $this->doGet($url);
        return $response;
    }

    public function transactionsDetails()
    {
        /**
         * [ GET api/v1/{coin}/tx/{txid} ]
         */
        $url      = $this->buildUrlParam('/tx/'.$this->txid);
        $response = $this->doGet($url);
        return $response;
    }

    public function transactionsIsValidated()
    {
        /**
         * [GET api/v1/{coin}/tx/{txid}/validate ]
         */
        $url      = $this->buildUrlParam('/tx/'.$this->txid.'/validate');
        $response = $this->doGet($url);
        return $response;
    }

    public function transactionsConfirmations()
    {
        /**
         * [GET api/v1/{coin}/tx/{txid}/confirmations ]
         */
        $url      = $this->buildUrlParam('/tx/'.$this->txid.'/confirmations');
        $response = $this->doGet($url);
        return $response;
    }

}
