<?php

class Suporte
{
  private $id;
	private $protocolo;
  private $categoria;
  private $informacao;
  private $descricao;
  private $carater;
  private $usuario_id;

  public function __get($atributo) 
  {
		return $this->$atributo;
	}

	public function __set($atributo, $valor) 
  {
		$this->$atributo = $valor;
		return $this;
	}
}

?>