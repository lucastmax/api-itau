<?php

namespace Itau\API\BolePix;

use Itau\API\BaseResponse;

class BolePixResponse extends BaseResponse
{
    protected $emv;
    protected $txid;
    protected $base64;
    protected $id_location;
    protected $location;
    protected $tipo_cobranca;

    public function getTxid()
    {
        return $this->txid;
    }

    public function getPixCopiaECola()
    {
        return $this->emv;
    }

    public function getQrCodeBase64()
    {
        return $this->base64;
    }

    public function getIdLocation()
    {
        return $this->id_location;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function getTipoCobranca()
    {
        return $this->tipo_cobranca;
    }
}
