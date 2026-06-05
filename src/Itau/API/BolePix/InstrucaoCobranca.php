<?php
namespace Itau\API\BolePix;

use Itau\API\TraitEntity;

class InstrucaoCobranca implements \JsonSerializable
{
    use TraitEntity;

    private int $codigo_instrucao_cobranca;
    private bool $dia_util;

    public function setInstrucaoCobranca($codigoInstrucaoCobranca, $diaUtil = null): self
    {
        $this->codigo_instrucao_cobranca = (int) $codigoInstrucaoCobranca;

        if (null !== $diaUtil) {
            $this->dia_util = (bool) $diaUtil;
        }

        return $this;
    }
}
