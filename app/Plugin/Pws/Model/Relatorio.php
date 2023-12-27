<?php


class Relatorio extends PwsAppModel
{
    public function getAtendimentos($chamados = array(), $conditions = array())
    {
        $return = array();
        $this->useTable = 'atendimentos';

        $SEQOS = array();

        foreach($chamados as $key => $data){

            $SEQOS[] = $data['Chamado']['SEQOS'];

        }

        $id = implode(',', $SEQOS);

        if($id != ''){

            $query = $this->query("SELECT * FROM atendimentos 
                                            WHERE SEQOS in ({$id}) 
                                            AND ID_BASE = {$data['Chamado']['ID_BASE']} 
                                            AND TFVISITA = 'S' 
                                            " . implode(" ", $conditions) . " 
                                            ORDER BY DTATENDIMENTO");

            foreach($query as $key => $data){

                $atendimento = $data['atendimentos'];

                // soma o total das despesas
                $atendimento['TOTAL'] = $this->formatFloat(($atendimento['VALATENDIMENTO'] + $atendimento['VALKM'] + $atendimento['VALESTACIONAMENTO'] + $atendimento['VALPEDAGIO'] + $atendimento['VALOUTRASDESP']));

                $atendimento['NMATENDENTE'] = $data['atendimentos']['NMATENDENTE'];
                $atendimento['TEMPOATENDIMENTO'] = $data['atendimentos']['TEMPOATENDIMENTO'];
                $atendimento['DTATENDIMENTO'] = $data['atendimentos']['DTATENDIMENTO'];
                $atendimento['VALATENDIMENTO'] = $this->formatFloat($data['atendimentos']['VALATENDIMENTO']);
                $atendimento['VALKM'] = $this->formatFloat($data['atendimentos']['VALKM']);
                $atendimento['VALESTACIONAMENTO'] = $this->formatFloat($data['atendimentos']['VALESTACIONAMENTO']);
                $atendimento['VALPEDAGIO'] = $this->formatFloat($data['atendimentos']['VALPEDAGIO']);
                $atendimento['VALOUTRASDESP'] = $this->formatFloat($data['atendimentos']['VALOUTRASDESP']);

                $return[$data['atendimentos']['SEQOS']][] = $atendimento;

            }
        }

        return $return;
    }

    private function formatFloat($data){

        return number_format($data, 2, ',', '.');

    }

    public function getImagesAtendimento($arrAtendimentos){

        $this->useTable = 'app_atendimento_photos';

        $arrIds = array();

        foreach($arrAtendimentos as $key => $data){
            $arrIds[] = $data[0]['id'];
        }

        if(count($arrIds) > 0){

            // consulta as imagens do atendimento
            $query = $this->query("SELECT * FROM app_atendimento_photos WHERE id_atendimento IN (" . implode(",", $arrIds) .")  AND status = 1  ORDER BY id DESC");

            foreach ($query as $key => $data) {

                $dataPhotos = $data['app_atendimento_photos'];

                // gera o hash da imagem
                $hash = Security::hash($dataPhotos['id_atendimento'] . $this->empresa);
                
                $arrImage[$dataPhotos['id_atendimento']][] = "?id={$dataPhotos['id']}&idAtendimento={$dataPhotos['id_atendimento']}&hash={$hash}";

            }

        }

        return $arrImage;

    }
}