<?php
//Verifica se a reserva já existe naquele horario e cria a reserva
require_once('../includes/conexao.inc.php');

class reservaController {
    private $bancoDados;

    public function __construct($bancoDados) {
        $this->bancoDados = $bancoDados;
    }

    public function verificarDisponibilidade($laboratorio_id, $data_reserva, $hora_inicio, $hora_fim) {
        $query = $this->bancoDados->prepare("
            SELECT COUNT(*) as total 
            FROM reserva 
            WHERE LABORATORIO_ID = :laboratorio_id 
            AND DATA = :data_reserva 
            AND HORA_INICIO < :hora_fim 
            AND HORA_FIM > :hora_inicio
        ");
        $query->bindParam(':laboratorio_id', $laboratorio_id, PDO::PARAM_INT);
        $query->bindParam(':data_reserva', $data_reserva, PDO::PARAM_STR);
        $query->bindParam(':hora_inicio', $hora_inicio, PDO::PARAM_STR);
        $query->bindParam(':hora_fim', $hora_fim, PDO::PARAM_STR);
        $query->execute();

        $resultado = $query->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'] == 0;
    }

    public function criarReserva($usuario_id, $laboratorio_id, $descricao, $data_reserva, $hora_inicio, $hora_fim) {
        if ($this->verificarDisponibilidade($laboratorio_id, $data_reserva, $hora_inicio, $hora_fim)) {
            $query = $this->bancoDados->prepare("
                INSERT INTO reserva (PESSOA_ID, LABORATORIO_ID, DESCRICAO, DATA, HORA_INICIO, HORA_FIM, CRIADO_EM, ATUALIZADO_EM) 
                VALUES (:usuario_id, :laboratorio_id, :descricao, :data_reserva, :hora_inicio, :hora_fim, NOW(), NOW())
            ");
            $query->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $query->bindParam(':laboratorio_id', $laboratorio_id, PDO::PARAM_INT);
            $query->bindParam(':descricao', $descricao, PDO::PARAM_STR);
            $query->bindParam(':data_reserva', $data_reserva, PDO::PARAM_STR);
            $query->bindParam(':hora_inicio', $hora_inicio, PDO::PARAM_STR);
            $query->bindParam(':hora_fim', $hora_fim, PDO::PARAM_STR);

            return $query->execute();
        } else {
            return false; // Reserva não permitida
        }
    }
}
