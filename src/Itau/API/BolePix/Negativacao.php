<?php
namespace Itau\API\BolePix;

use Itau\API\TraitEntity;

class Negativacao implements \JsonSerializable
{
    use TraitEntity;

    private int $codigo_tipo_negativacao;
    private bool $negativacao;
    private int $quantidade_dias_negativacao;

    public function setNegativacao($negativacao, $quantidadeDias = null, $codigoTipoNegativacao = null): self
    {
        $this->negativacao = (bool) $negativacao;

        if (null !== $quantidadeDias) {
            $this->quantidade_dias_negativacao = (int) $quantidadeDias;
        }

        if (null !== $codigoTipoNegativacao) {
            $this->codigo_tipo_negativacao = (int) $codigoTipoNegativacao;
        }

        return $this;
    }
}
