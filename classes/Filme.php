<?php

class Filme
{
	private $id;
	private $nome;
	private $genero;
    private $duracao;
	private $dataLancamento;
	private $sinopse;
	private $elenco;
	private $diretor;
    private $imagem;

	/**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

	/**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     *
     * @return self
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

	/**
     * @return mixed
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * @param mixed $genero
     *
     * @return self
     */
    public function setGenero(Genero $genero)
    {
        $this->genero = $genero;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDuracao()
    {
        return $this->duracao;
    }

    /**
     * @param mixed $duracao
     *
     * @return self
     */
    public function setDuracao($duracao)
    {
        $this->duracao = $duracao;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDataLancamento()
    {
        return $this->dataLancamento;
    }

    /**
     * @param mixed $dataLancamento
     *
     * @return self
     */
    public function setDataLancamento($dataLancamento)
    {
        $this->dataLancamento = $dataLancamento;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSinopse()
    {
        return $this->sinopse;
    }

    /**
     * @param mixed $sinopse
     *
     * @return self
     */
    public function setSinopse($sinopse)
    {
        $this->sinopse = $sinopse;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getElenco()
    {
        return $this->elenco;
    }

    /**
     * @param mixed $elenco
     *
     * @return self
     */
    public function setElenco($elenco)
    {
        $this->elenco = $elenco;

        return $this;
    }



    /**
     * @return mixed
     */
    public function getDiretor()
    {
        return $this->diretor;
    }

    /**
     * @param mixed $diretor
     *
     * @return self
     */
    public function setDiretor(Diretor $diretor)
    {
        $this->diretor = $diretor;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getImagem()
    {
        return $this->imagem;
    }

    /**
     * @param mixed $imagem
     *
     * @return self
     */
    public function setImagem($imagem)
    {
        $this->imagem = $imagem;

        return $this;
    }
}