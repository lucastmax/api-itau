<?php
namespace Itau\API\BolePix;

use Itau\API\TraitEntity;

class DadosIndividuaisBoleto implements \JsonSerializable
{
    use TraitEntity;

    private string $numero_nosso_numero;
    private string $data_vencimento;
    private $valor_titulo;
    private string $data_limite_pagamento;
    private string $texto_seu_numero;
    private string $texto_uso_beneficiario;

    public function setDados($nossoNumero, $dataVencimento, $valor, $limitePagamento = null, $seuNumero = null): self
    {
        $this->numero_nosso_numero = str_pad($nossoNumero, 8, '0', STR_PAD_LEFT);
        $this->data_vencimento = $dataVencimento;
        $this->valor_titulo = (int)str_replace('.', '', number_format($valor, 2, '.', ''));

        if (null !== $limitePagamento) {
            $this->data_limite_pagamento = $limitePagamento;
        }

        if (null !== $seuNumero) {
            $this->texto_seu_numero = mb_substr($seuNumero, 0, 50);
        }

        return $this;
    }

    public function setDataLimitePagamento($dataLimitePagamento): self
    {
        $this->data_limite_pagamento = $dataLimitePagamento;
        return $this;
    }

    public function setTextoSeuNumero($textoSeuNumero): self
    {
        $this->texto_seu_numero = mb_substr($textoSeuNumero, 0, 10);
        return $this;
    }

    public function setTextoUsoBeneficiario($textoUsoBeneficiario): self
    {
        $this->texto_uso_beneficiario = mb_substr($textoUsoBeneficiario, 0, 200);
        return $this;
    }
}
