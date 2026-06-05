<?php
namespace Itau\API\BolePix;

use Itau\API\TraitEntity;

class Pagador implements \JsonSerializable
{
    use TraitEntity;

    private Pessoa $pessoa;
    private Endereco $endereco;
    private string $texto_endereco_email;
    private string $numero_ddd;
    private string $numero_telefone;

    public function pessoa(): Pessoa
    {
        $pessoa = new Pessoa();
        $this->setPessoa($pessoa);
        return $pessoa;
    }

    public function setPessoa(Pessoa $pessoa): self
    {
        $this->pessoa = $pessoa;
        return $this;
    }

    public function endereco(): Endereco
    {
        $endereco = new Endereco();
        $this->setEndereco($endereco);
        return $endereco;
    }

    public function setEndereco(Endereco $endereco): self
    {
        $this->endereco = $endereco;
        return $this;
    }

    public function setEmail($email): self
    {
        $this->texto_endereco_email = $email;
        return $this;
    }

    public function setTelefone($ddd, $telefone): self
    {
        $this->numero_ddd = preg_replace("/[^0-9]/", "", $ddd);
        $this->numero_telefone = preg_replace("/[^0-9]/", "", $telefone);
        return $this;
    }
}
