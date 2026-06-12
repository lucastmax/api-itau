<?php
namespace Itau\API\BolePix;

use Itau\API\TraitEntity;

class DadoBoleto implements \JsonSerializable
{
    use TraitEntity;

    const ESPECIE_DM = '01';
    const ESPECIE_DS = '08';
    const INSTRUMENTO_COBRANCA_BOLEPIX = "boleto_pix";

    private string $descricao_instrumento_cobranca = self::INSTRUMENTO_COBRANCA_BOLEPIX;
    private string $tipo_boleto = "a vista";
    private string $codigo_carteira = "109";
    private string $codigo_especie;
    private  $valor_total_titulo;
    private string $data_emissao;
    private Pagador $pagador;
    private int $codigo_tipo_vencimento;
    private array $dados_individuais_boleto = [];
    private Juros $juros;
    private Multa $multa;
    private RecebimentoDivergente $recebimento_divergente;
    private array $instrucao_cobranca;
    private Protesto $protesto;
    private Negativacao $negativacao;

    public function __construct()
    {
        $this->data_emissao = date("Y-m-d");
    }

    public function setDados($valor, $codigoEspecie = self::ESPECIE_DM): self
    {
        $this->valor_total_titulo = $this->formatDecimal($valor) * 100;
        $this->codigo_especie = $codigoEspecie;
        return $this;
    }

    public function setDescricaoInstrumentoCobranca($descricaoInstrumentoCobranca): self
    {
        $this->descricao_instrumento_cobranca = $descricaoInstrumentoCobranca;
        return $this;
    }

    public function setTipoBoleto($tipoBoleto): self
    {
        $this->tipo_boleto = $tipoBoleto;
        return $this;
    }

    public function setCodigoCarteira($codigoCarteira): self
    {
        $this->codigo_carteira = (string) $codigoCarteira;
        return $this;
    }

    public function setCodigoEspecie($codigoEspecie): self
    {
        $this->codigo_especie = $codigoEspecie;
        return $this;
    }

    public function setValorTotalTitulo($valor): self
    {
        $this->valor_total_titulo = $this->formatDecimal($valor);
        return $this;
    }

    public function setDataEmissao($dataEmissao): self
    {
        $this->data_emissao = $dataEmissao;
        return $this;
    }

    public function setCodigoTipoVencimento($codigoTipoVencimento): self
    {
        $this->codigo_tipo_vencimento = (int) $codigoTipoVencimento;
        return $this;
    }

    public function pagador(): Pagador
    {
        $pagador = new Pagador();
        $this->setPagador($pagador);
        return $pagador;
    }

    public function setPagador(Pagador $pagador): self
    {
        $this->pagador = $pagador;
        return $this;
    }

    public function dadosIndividuais(): DadosIndividuaisBoleto
    {
        $dados = new DadosIndividuaisBoleto();
        $this->setDadosIndividuaisBoleto($dados);
        return $dados;
    }

    public function setDadosIndividuaisBoleto(DadosIndividuaisBoleto $dados): self
    {
        $this->dados_individuais_boleto[] = $dados;
        return $this;
    }

    public function juros(): Juros
    {
        $juros = new Juros();
        $this->setJuros($juros);
        return $juros;
    }

    public function setJuros(Juros $juros): self
    {
        $this->juros = $juros;
        return $this;
    }

    public function multa(): Multa
    {
        $multa = new Multa();
        $this->setMulta($multa);
        return $multa;
    }

    public function setMulta(Multa $multa): self
    {
        $this->multa = $multa;
        return $this;
    }

    public function recebimentoDivergente(): RecebimentoDivergente
    {
        $recebimentoDivergente = new RecebimentoDivergente();
        $this->setRecebimentoDivergente($recebimentoDivergente);
        return $recebimentoDivergente;
    }

    public function setRecebimentoDivergente(RecebimentoDivergente $recebimentoDivergente): self
    {
        $this->recebimento_divergente = $recebimentoDivergente;
        return $this;
    }

    public function instrucaoCobranca(): InstrucaoCobranca
    {
        $instrucaoCobranca = new InstrucaoCobranca();

        if (!isset($this->instrucao_cobranca)) {
            $this->instrucao_cobranca = [];
        }

        $this->instrucao_cobranca[] = $instrucaoCobranca;
        return $instrucaoCobranca;
    }

    public function protesto(): Protesto
    {
        $protesto = new Protesto();
        $this->setProtesto($protesto);
        return $protesto;
    }

    public function setProtesto(Protesto $protesto): self
    {
        $this->protesto = $protesto;
        return $this;
    }

    public function negativacao(): Negativacao
    {
        $negativacao = new Negativacao();
        $this->setNegativacao($negativacao);
        return $negativacao;
    }

    public function setNegativacao(Negativacao $negativacao): self
    {
        $this->negativacao = $negativacao;
        return $this;
    }

    private function formatDecimal($valor): string
    {
        return (float) $valor; //number_format((float) $valor, 2, '.', '');
    }
}
