<?php
namespace Itau\API\BolePix;

use Itau\API\TraitEntity;

class Juros implements \JsonSerializable
{
    use TraitEntity;

    const SEM_JUROS = '05';
    const PERCENTUAL_MENSAL = '90';
    const PERCENTUAL_DIARIO = '91';
    const PERCENTUAL_ANUAL = '92';
    const VALOR_DIARIO = '93';

    private string $codigo_tipo_juros;
    private string $valor_juros;
    private  $percentual_juros;
    private string $data_juros;

    public function setJuros($codigo, $valor = null, $percentual = null, $data = null): self
    {
        $this->codigo_tipo_juros = $codigo;

        if (null !== $valor) {
            $this->valor_juros = (float) $valor * 100;
        }

        if (null !== $percentual) {
            $this->percentual_juros = (float) $percentual * 100000; //number_format((float) $percentual, 5, '.', '');
        }

        if (null !== $data) {
            $this->data_juros = $data;
        }

        return $this;
    }
}
