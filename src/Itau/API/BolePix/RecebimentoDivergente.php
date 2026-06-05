<?php
namespace Itau\API\BolePix;

use Itau\API\TraitEntity;

class RecebimentoDivergente implements \JsonSerializable
{
    use TraitEntity;

    private string $codigo_tipo_autorizacao;
    private string $codigo_tipo_recebimento;
    private string $percentual_minimo;
    private string $percentual_maximo;

    public function setRecebimentoDivergente($codigoAutorizacao, $codigoRecebimento = null, $percentualMinimo = null, $percentualMaximo = null): self
    {
        $this->codigo_tipo_autorizacao = $codigoAutorizacao;

        if (null !== $codigoRecebimento) {
            $this->codigo_tipo_recebimento = $codigoRecebimento;
        }

        if (null !== $percentualMinimo) {
            $this->percentual_minimo = number_format((float) $percentualMinimo, 5, '.', '');
        }

        if (null !== $percentualMaximo) {
            $this->percentual_maximo = number_format((float) $percentualMaximo, 5, '.', '');
        }

        return $this;
    }
}
