<?php
namespace Itau\API\BolePix;

use Itau\API\TraitEntity;

class BolePix implements \JsonSerializable
{
    use TraitEntity;

    const ETAPA_TESTE = "simulacao";
    const ETAPA_EFETIVO = "efetivacao";

    private string $etapa_processo_boleto;
    private string $codigo_canal_operacao;
    private Beneficiario $beneficiario;
    private DadoBoleto $dado_boleto;
    private DadosQrCode $dados_qrcode;

    public function __construct(
        $modo = self::ETAPA_EFETIVO,
        $agencia = null,
        $conta = null,
        $contaDV = null,
        $valor = null,
        $codigoEspecie = DadoBoleto::ESPECIE_DM,
        $numeroDocumento = null,
        $nome = null,
        $tipoPessoa = null,
        $documento = null,
        $endereco = null,
        $numero = null,
        $complemento = null,
        $bairro = null,
        $cidade = null,
        $siglaEstado = null,
        $cep = null,
        $nossoNumero = null,
        $vencimento = null
    )
    {
        $this->setEtapaProcessoBoleto($modo);

        if (null !== $agencia && null !== $conta && null !== $contaDV) {
            $this->beneficiario()->setIdBeneficiario($agencia, $conta.$contaDV);
        }

        if (null !== $valor) {
            $dadoBoleto = $this->dadoBoleto()->setDados($valor, $codigoEspecie);

            if (null !== $nome && null !== $tipoPessoa && null !== $documento) {
                $pagador = $dadoBoleto->pagador();
                $pagador->pessoa()->setNomePessoa($nome)
                    ->tipoPessoa()->setPessoa($tipoPessoa, $documento);

                if (null !== $endereco && null !== $bairro && null !== $cidade && null !== $siglaEstado && null !== $cep) {
                    $pagador->endereco()->setEndereco(
                        $endereco, $numero, $complemento, $bairro, $cidade, $siglaEstado, $cep
                    );
                }
            }

            if (null !== $nossoNumero && null !== $vencimento) {
                $dadoBoleto->dadosIndividuais()->setDados(
                    $nossoNumero, $vencimento, $valor, null, $numeroDocumento
                );
            }
        }
    }

    public function setEtapaProcessoBoleto($etapa): self
    {
        $this->etapa_processo_boleto = $etapa;
        return $this;
    }

    public function setCodigoCanalOperacao($codigoCanalOperacao): self
    {
        $this->codigo_canal_operacao = $codigoCanalOperacao;
        return $this;
    }

    public function beneficiario(): Beneficiario
    {
        $beneficiario = new Beneficiario();
        $this->setBeneficiario($beneficiario);
        return $beneficiario;
    }

    public function setBeneficiario(Beneficiario $beneficiario): self
    {
        $this->beneficiario = $beneficiario;
        return $this;
    }

    public function dadoBoleto(): DadoBoleto
    {
        $dado = new DadoBoleto();
        $this->setDadoBoleto($dado);
        return $dado;
    }

    public function setDadoBoleto(DadoBoleto $dado): self
    {
        $this->dado_boleto = $dado;
        return $this;
    }

    public function dadosQrCode(): DadosQrCode
    {
        $dadosQrCode = new DadosQrCode();
        $this->setDadosQrCode($dadosQrCode);
        return $dadosQrCode;
    }

    public function setDadosQrCode(DadosQrCode $dadosQrCode): self
    {
        $this->dados_qrcode = $dadosQrCode;
        return $this;
    }
}
