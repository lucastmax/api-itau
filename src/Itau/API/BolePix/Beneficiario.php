<?php
namespace Itau\API\BolePix;

use Itau\API\TraitEntity;

class Beneficiario implements \JsonSerializable
{
    use TraitEntity;

    private string $id_beneficiario;
    private string $nome_cobranca;
    private TipoPessoa $tipo_pessoa;
    private Endereco $endereco;

    public function setIdBeneficiario($agencia, $contaComDigito): self
    {
        $this->id_beneficiario = str_pad($agencia, 4, '0', STR_PAD_LEFT).str_pad($contaComDigito, 8, '0', STR_PAD_LEFT);
        return $this;
    }

    public function setIdBeneficiarioCompleto($idBeneficiario): self
    {
        $this->id_beneficiario = preg_replace("/[^0-9]/", "", $idBeneficiario);
        return $this;
    }

    public function setNomeCobranca($nome): self
    {
        $this->nome_cobranca = mb_substr($nome, 0, 100);
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
}
