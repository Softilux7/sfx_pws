<?php

class UploadComponent extends Component
{

    public static function upload($imagem = array(), $dir = 'img')
    {
        //$dir = WWW_ROOT.$dir.DS;
        $dir = WWW_ROOT.$dir.'/emp'.DS;

        if(($imagem['error']!=0) and ($imagem['size']==0)) {
            throw new NotImplementedException('Alguma coisa deu errado, o upload retornou erro '.$imagem['error'].' e tamanho '.$imagem['size']);
        }

        Self::checa_dir($dir);

        $imagem = Self::checa_nome($imagem, $dir);

        Self::move_arquivos($imagem, $dir);

        return $imagem['name'];
    }


    public  static function checa_dir($dir)
    {
        App::uses('Folder', 'Utility');
        $folder = new Folder();
        if (!is_dir($dir)){
            $folder->create($dir);
        }
    }


    public static function checa_nome($imagem, $dir)
    {
        $imagem_info = pathinfo($dir.$imagem['name']);
        $imagem_nome = Self::trata_nome($imagem_info['filename']).'.'.$imagem_info['extension'];
       // debug($imagem_nome);
        $conta = 2;
        while (file_exists($dir.$imagem_nome)) {
            $imagem_nome  = Self::trata_nome($imagem_info['filename']).'-'.$conta;
            $imagem_nome .= '.'.$imagem_info['extension'];
            $conta++;
          //  debug($imagem_nome);
        }
        $imagem['name'] = $imagem_nome;
        return $imagem;
    }


    public static function trata_nome($imagem_nome)
    {
        $imagem_nome = strtolower(Inflector::slug($imagem_nome,'-'));
        return $imagem_nome;
    }

    public static function move_arquivos($imagem, $dir)
    {
        App::uses('File', 'Utility');
        $arquivo = new File($imagem['tmp_name'], true, 0777);
        $arquivo->copy($dir.$imagem['name']);
        $arquivo->close();
//        $dir = new Folder();
        chmod ($dir.$imagem['name'], 0755);
    }

}