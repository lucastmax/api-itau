<?php
namespace Itau\API\BolePix;

use Itau\API\TraitEntity;

class Protesto implements \JsonSerializable
{
    use TraitEntity;

    private int $codigo_tipo_protesto;
    private bool $protesto;
    private int $quantidade_dias_protesto;

    public function setProtesto($protesto, $quantidadeDias = null, $codigoTipoProtesto = null): self
    {
        $this->protesto = (bool) $protesto;

        if (null !== $quantidadeDias) {
            $this->quantidade_dias_protesto = (int) $quantidadeDias;
        }

        if (null !== $codigoTipoProtesto) {
            $this->codigo_tipo_protesto = (int) $codigoTipoProtesto;
        }

        return $this;
    }
}
