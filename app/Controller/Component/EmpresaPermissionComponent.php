<?php
/**
 * Created by PhpStorm.
 * User: Vinicius
 * Date: 10/01/2019
 * Time: 22:00
 */

class EmpresaPermissionComponent extends Component {

    const EMPRESA_WA_EQUIPAMENTOS = 53;

    public static function verifiquePermissaoModuloContrato($empresaId, $userGroupId)
    {
        if ($empresaId != self::EMPRESA_WA_EQUIPAMENTOS || ($empresaId == self::EMPRESA_WA_EQUIPAMENTOS && ($userGroupId == 6 || $userGroupId == 1)))
            return true;
        else
            return false;
    }

    public static function verifiqueClienteDataVoice($userGroup, $idBase){

        // DATA VOICE

        return ($userGroup == 3 and $idBase == 15) ? true : false;

    }

}