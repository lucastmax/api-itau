<?php
namespace Itau\API\BolePix;

use Itau\API\TraitEntity;

class TipoPessoa implements \JsonSerializable
{
    use TraitEntity;

    const PESSOA_FISICA = 'F';
    const PESSOA_JURIDICA = 'J';

    private string $codigo_tipo_pessoa;
    private string $numero_cadastro_pessoa_fisica;
    private string $numero_cadastro_nacional_pessoa_juridica;

    public function setPessoa($tipoPessoa, $numero): self
    {
        $this->codigo_tipo_pessoa = $tipoPessoa;
        $numero = preg_replace("/[^0-9]/", "", $numero);

        if ($this->codigo_tipo_pessoa == self::PESSOA_FISICA) {
            $this->numero_cadastro_pessoa_fisica = $numero;
        } else {
            $this->numero_cadastro_nacional_pessoa_juridica = $numero;
        }

        return $this;
    }
}
