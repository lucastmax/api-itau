<?php
namespace Itau\API\BolePix;

use Itau\API\TraitEntity;

class Pessoa implements \JsonSerializable
{
    use TraitEntity;

    private string $nome_pessoa;
    private string $nome_fantasia;
    private TipoPessoa $tipo_pessoa;

    public function setNomePessoa($nome): self
    {
        $this->nome_pessoa = mb_substr($nome, 0, 100);
        return $this;
    }

    public function setNomeFantasia($nomeFantasia): self
    {
        $this->nome_fantasia = mb_substr($nomeFantasia, 0, 100);
        return $this;
    }

    public function tipoPessoa(): TipoPessoa
    {
        $tipoPessoa = new TipoPessoa();
        $this->setTipoPessoa($tipoPessoa);
        return $tipoPessoa;
    }

    public function setTipoPessoa(TipoPessoa $tipoPessoa): self
    {
        $this->tipo_pessoa = $tipoPessoa;
        return $this;
    }
}
