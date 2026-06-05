<?php
namespace Itau\API\BolePix;

use Itau\API\TraitEntity;

class Multa implements \JsonSerializable
{
    use TraitEntity;

    const VALOR_FIXO = '01';
    const PERCENTUAL = '02';
    const SEM_MULTA = '03';

    private string $codigo_tipo_multa;
    private string $valor_multa;
    private string $percentual_multa;
    private string $data_multa;

    public function setMulta($codigo, $valor = null, $percentual = null, $data = null): self
    {
        $this->codigo_tipo_multa = $codigo;

        if (null !== $valor) {
            $this->valor_multa = number_format((float) $valor, 2, '.', '');
        }

        if (null !== $percentual) {
            $this->percentual_multa = number_format((float) $percentual, 5, '.', '');
        }

        if (null !== $data) {
            $this->data_multa = $data;
        }

        return $this;
    }
}
