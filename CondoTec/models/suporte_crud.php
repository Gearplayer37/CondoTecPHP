<?php
// Arquivo: Suporte_crud.php
require_once 'conexao.php';
require_once 'suporte.model.php';

class Suporte_crud 
{
    private $conexao;
    private $suporte;

    public function __construct(Conexao $conexao, Suporte $suporte) 
    {
        $this->conexao = $conexao->conectar();
        $this->suporte = $suporte;
    }

    public function inserir() 
    { // Create
        // Geração do protocolo único de 6 dígitos
        $protocolo = random_int(100000, 999999);

        // Verifica se a sessão está iniciada
        if (session_status() == PHP_SESSION_NONE) 
        {
            session_start();
        }

        // Obtém o id do usuário da sessão
        $usuario_id = $_SESSION['id'];

        // Prepara e executa a query de inserção
        $query = 'INSERT INTO suporte(protocolo, categoria, informacao, descricao, carater, usuario_id) VALUES(:protocolo, :categoria, :informacao, :descricao, :carater, :usuario_id)';
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':protocolo', $protocolo);
        $stmt->bindValue(':categoria', $this->suporte->__get('categoria'));
        $stmt->bindValue(':informacao', $this->suporte->__get('informacao'));
        $stmt->bindValue(':descricao', $this->suporte->__get('descricao'));
        $stmt->bindValue(':carater', $this->suporte->__get('carater'));
        $stmt->bindValue(':usuario_id', $usuario_id);
        $stmt->execute();
    }

    public function recuperar() 
    { // Read
        $query = 'SELECT * FROM suporte';
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function atualizar($protocolo, $informacao, $descricao) 
    {
        $query = 'UPDATE suporte SET informacao = :informacao, descricao = :descricao WHERE protocolo = :protocolo';
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':protocolo', $protocolo);
        $stmt->bindValue(':informacao', $informacao);
        $stmt->bindValue(':descricao', $descricao);
        $stmt->execute();
    }


    public function remover($protocolo) 
    {
        $query = 'DELETE FROM suporte WHERE protocolo = :protocolo';
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':protocolo', $protocolo);
        $stmt->execute();
    }

    // Suporte_crud.php
    public function recuperarPorUsuario($idUsuario) 
    {
        $sql = "SELECT * FROM suporte WHERE usuario_id = :usuario_id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':usuario_id', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    

}
?>
