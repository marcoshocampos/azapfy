<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DateTime;

class apiController extends Controller
{
    public function apiremetente()
    {
        $remetentes = [];

        $api = Http::get('http://homologacao3.azapfy.com.br/api/ps/notas');
        $apiArray = json_decode($api, true);

        //Agrupar as notas por remetente.

        foreach ($apiArray as $remet) {

            $remetentes[$remet['cnpj_remete']][] = $remet;
        }

        return $remetentes;
    }

    public function index()
    {
        $remetentes = $this->apiremetente();

        return response(json_encode($remetentes));
    }

    public function readValorNota()
    {
        //Calcular o valor total das notas para cada remetente.

        $soma_notas = [];
        $remetentes = $this->apiremetente();

        foreach ($remetentes as $remetente) {

            $somar_notas_rementente = 0;
            $nome_remetente = '';

            foreach ($remetente as $nota) {

                $somar_notas_rementente += $nota['valor'];
                $nome_remetente = $nota['nome_remete'];
            }

            $soma_notas[$nome_remetente] = $somar_notas_rementente;
        }

        return response(json_encode($soma_notas));
    }

    public function readValorEntregue()
    {

        //Calcular o valor que o remetente irá receber pelo que já foi entregue.

        $soma_entregue = [];
        $remetentes = $this->apiremetente();

        foreach ($remetentes as $remetente) {

            $somar_entrega = 0;
            $nome_remet = '';

            foreach ($remetente as $nota) {

                $nome_remet = $nota['nome_remete'];

                if ($nota['status'] == 'COMPROVADO') {

                    $dt_ent = new DateTime(str_replace("/", "-", $nota['dt_entrega']));
                    $dt_ent->format('Y-m-d\TH:i:s.Z\Z');

                    $dt_emis = new DateTime(str_replace("/", "-", $nota['dt_emis']));
                    $dt_emis->format('Y-m-d\TH:i:s.Z\Z');

                    $result = $dt_ent->diff($dt_emis)->format("%d");

                    if ($result <= 2) {

                        $somar_entrega += $nota['valor'];
                    }
                }
            }

            $soma_entregue[$nome_remet] = $somar_entrega;
        }

        return response(json_encode($soma_entregue));
    }

    public function readValorNaoEntregue()
    {
        //Calcular o valor que o remetente irá receber pelo que ainda não foi entregue.

        $soma_aberto = [];
        $remetentes = $this->apiremetente();

        foreach ($remetentes as $remetente) {

            $somar_nao_entrega = 0;
            $nome_remet = '';

            foreach ($remetente as $nota) {

                $nome_remet = $nota['nome_remete'];

                if ($nota['status'] == 'ABERTO') {

                    $hoje = new DateTime(str_replace("/", "-", date('d/m/Y h:i:s')));
                    $hoje->format('Y-m-d\TH:i:s.Z\Z');


                    $dt_emis = new DateTime(str_replace("/", "-", $nota['dt_emis']));
                    $dt_emis->format('Y-m-d\TH:i:s.Z\Z');

                    $result = $hoje->diff($dt_emis)->days;

                    if ($result <= 2) {

                        $somar_nao_entrega += $nota['valor'];
                    }
                }
            }

            $soma_aberto[$nome_remet] = $somar_nao_entrega;
        }

        return response(json_encode($soma_aberto));
    }

    public function readValorAtraso()
    {
        //Calcular quanto o remetente deixou de receber devido ao atraso na entrega.

        $soma_atrasado = [];
        $result1 = 0;
        $result2 = 0;
        $remetentes = $this->apiremetente();

        foreach ($remetentes as $remetente) {

            $somar_receber_atraso = 0;
            $nome_remet = '';

            foreach ($remetente as $nota) {

                $nome_remet = $nota['nome_remete'];

                $dt_emis = new DateTime(str_replace("/", "-", $nota['dt_emis']));
                $dt_emis->format('Y-m-d\TH:i:s.Z\Z');

                if ($nota['status'] == 'COMPROVADO') {

                    $dt_ent = new DateTime(str_replace("/", "-", $nota['dt_entrega']));
                    $dt_ent->format('Y-m-d\TH:i:s.Z\Z');

                    $result1 = $dt_ent->diff($dt_emis)->format("%d");;

                    if ($result1 > 2) {

                        $somar_receber_atraso += $nota['valor'];
                    }
                } else {

                    $hoje = new DateTime(str_replace("/", "-", date('d/m/Y h:i:s')));
                    $hoje->format('Y-m-d\TH:i:s.Z\Z');
                    $result2 = $hoje->diff($dt_emis)->days;

                    if ($result2 > 2) {

                        $somar_receber_atraso += $nota['valor'];
                    }
                }
            }

            $soma_atrasado[$nome_remet] = $somar_receber_atraso;
        }

        return response(json_encode($soma_atrasado));
    }
}
