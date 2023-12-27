<?php

foreach ($empresas as $key => $empresa) {
    $empresaA['id']= $key;
    $empresaA['text']= $empresa;
    $empresaB[] = $empresaA;

}

if(isset($empresas)) {
    echo $this->Js->object(array('items'=>$empresaB,'total'=>count($empresaB)));
}
?>