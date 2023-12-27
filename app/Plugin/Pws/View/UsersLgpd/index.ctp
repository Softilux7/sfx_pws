<div class="span12">
    <div class="row-fluid">
        <div class="span12">
            <div class="page-header">
                <div style="display:flex;justify-content: space-between;align-items: center;">
                    <div>
                        <h1 style="margin-left:50px;color:#666"><i class="fa fa-home fa-lg"></i> LGPD </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if ($this->Session->check('Message.flash')) { ?>
        <div class="alert">
            <button data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
            <b><?php echo($this->Session->flash()); ?></b>
            <br/>
        </div>
    <?php } ?>
    
    <div class="row-fluid hidden-phone hidden-tablet hidden-sm" >
        <div class="span6" style="margin-left:0px;width:100%">
            <div class="panel panel-primary" style="border-color:#81d5ff">
                <div class="panel-heading" style="padding:1px 15px;background:#81d5ff;border-color:#81d5ff;text-align:center">
                    <h3 style="color:#0177b1"><i class="fa fa-check-square-o" aria-hidden="true" ></i> Usuários</h3>
                </div>
                <div class="panel-body text-center" style="min-height: 200px;padding:0px">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Política de Privacidade</th>
                                <th>Termo de uso</th>
                                <th>Termo de consentimento</th>
                                <th>Motivo</th>
                                <th>Aceito</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody >
                            <?php 
                                foreach ($usersLgpd as $response): 
                                    $data = $response['UsersLgpd'];
                                    // _tst($response);
                            ?>
                                <tr>
                                    <td><?php echo $response['User']['user_name'];?></td>
                                    <td><?php echo $data['email'];?></td>
                                    <td><?php echo $data['politica_privacidade'] ? date("Y/m/d H:i:s", strtotime($data['politica_privacidade'])) : '';?></td>
                                    <td><?php echo $data['termo_uso'] ? date("Y/m/d H:i:s", strtotime($data['termo_uso'])) : '';?></td>
                                    <td><?php echo $data['termo_consentimento'] ? date("Y/m/d H:i:s", strtotime($data['termo_consentimento'])) : '';?></td>
                                    <td><?php echo $data['motivo'];?></td>
                                    <td><?php 
                                        if($data['negado'] == 1){
                                            echo 'Não';
                                        }else{
                                            if($data['politica_privacidade'] != '' && $data['termo_uso'] != '' && $data['termo_consentimento'] != '' && $data['negado'] == 0){
                                                echo 'Sim';
                                            }
                                        }
                                        
                                    ?></td>
                                </tr>
                            <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>

                    <p>
                        <?php
                        echo $this->Paginator->counter(array(
                            'format' => __('Pagina {:page} de {:pages}, mostrando {:current} registros de {:count} no total, iniciando no registro {:start}, terminando em {:end}')
                        ));
                        ?>
                    </p>

                    <div class="pagination">
                        <ul>
                            <?php
                            echo $this->Paginator->prev('<< ' . __('Anterior'), array(
                                'tag' => 'li',
                                'escape' => false
                            ));
                            echo $this->Paginator->numbers(array(
                                'separator' => '',
                                'tag' => 'li'
                            ));
                            echo $this->Paginator->next(__('Proximo') . ' >>', array(
                                'tag' => 'li',
                                'escape' => false
                            ));
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>