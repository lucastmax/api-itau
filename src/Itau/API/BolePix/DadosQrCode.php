<?php
namespace Itau\API\BolePix;

use Itau\API\TraitEntity;

class DadosQrCode implements \JsonSerializable
{
    use TraitEntity;

    private string $chave;
    private string $id_location;
    private string $tipo_cobranca;

    public function setChave($chave): self
    {
        $this->chave = $chave;
        return $this;
    }

    public function setIdLocation($idLocation): self
    {
        $this->id_location = (string) $idLocation;
        return $this;
    }

    public function setTipoCobranca($tipoCobranca): self
    {
        $this->tipo_cobranca = $tipoCobranca;
        return $this;
    }
}
