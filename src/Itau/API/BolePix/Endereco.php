<?php
namespace Itau\API\BolePix;

use Itau\API\TraitEntity;

class Endereco implements \JsonSerializable
{
    use TraitEntity;

    private string $nome_logradouro;
    private string $nome_bairro;
    private string $nome_cidade;
    private string $sigla_UF;
    private string $numero_CEP;
    private string $numero;
    private string $complemento;

    public function setEndereco($logradouro, $numero, $complemento, $bairro, $cidade, $uf, $cep): self
    {
        $this->nome_logradouro = mb_substr($logradouro, 0, 150);
        $this->nome_bairro = mb_substr($bairro, 0, 100);
        $this->nome_cidade = mb_substr($cidade, 0, 100);
        $this->sigla_UF = mb_substr($uf, 0, 2);
        $this->numero_CEP = preg_replace("/[^0-9]/", "", $cep);

        if (null !== $numero) {
            $this->numero = mb_substr($numero, 0, 10);
        }

        if (null !== $complemento) {
            $this->complemento = mb_substr($complemento, 0, 100);
        }

        return $this;
    }
}
