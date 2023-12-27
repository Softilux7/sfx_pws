<?php

foreach ($clientes as $key => $cliente) {
    $clienteA['id']= $key;
    $clienteA['text']= $cliente;
    $clienteB[] = $clienteA;

}

if(isset($clientes)) {
    echo $this->Js->object(array('items'=>$clienteB,'total'=>count($clienteB)));
}
?>