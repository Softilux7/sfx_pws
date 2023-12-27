<ul>
    <?php foreach ($records as $key => $data) : ?>
        <li style="float:left; list-style-type: none;padding:10px"><img src="<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'acompanharAtendimento', 'action' => 'renderImage' . $data)); ?>" height="300" width="300" /></li>
    <?php endforeach; ?>
</ul>