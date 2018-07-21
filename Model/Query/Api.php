<?php
namespace Amzone\Ongkir\Model\Query;

use Magento\Framework\HTTP\ZendClientFactory;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Api
{
    const CITY_KAB = 'Kabupaten';
    const CITY_KOT = 'Kota';

    protected $_httpClient;

    public function __contstruct(ZendClientFactory $httpClient) {
        $this->_httpClient = $httpClient;
    }

    public function apiCaller($url, $method, $params, $header = null)
    {
        $apiCaller = $this->_httpClient->create();
        $apiCaller->setUri($url);
        $apiCaller->setMethod($method);
        $apiCaller->setHeaders([
            'Content-Type: application/x-www-form-urlencoded',
            'Accept: application/json',
            'Key: '.$header
        ]);

        $apiCaller->setParameterPost($param); //or parameter get
        return $apiCaller->request();
    }

    public function getOngkir($origin, $destination, $weight, $courier)
    {
        $params = [
            'origin' => $origin,
            'originType' => 'city',
            'destination' => $destination,
            'destinationType' => 'city',
            'weight' => $weight,
            'courier' => $courier
        ];
        $key = 'xx';

        //$apiCaller = $this->_httpClient->create();
        $ongkir = $this->apiCaller('https://api.rajaongkir.com/starter/cost', \Zend_Http_Client::POST, $params, $key);

        $ongkirBody = json_decode($ongkir->getBody());

        if ($ongkir->rajaongkir->status->code == 200) {
            return $ongkir->rajaongkir->results;
        } else {
            return 0;
        }
    }

    public function getProvince()
    {
        //
        //
    }

    public function getCity()
    {
        //
    }
}
