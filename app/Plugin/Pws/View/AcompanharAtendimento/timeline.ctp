<style type="text/css">
    .wrap { max-width: 75em; height:100%; width:100%; margin: 0 auto; padding-top: 2.5%;}
    #map-canvas { height: 50%; }
  </style>
<div>Distância percorrida: <strong style="color:#ea4335"><span id="distkm"></strong> <span id="distmin" style="color:#666666"></span></span></div>
<div style="float: left;width:450px;overflow:auto;height:400px">
    <input type="hidden" id="idTimeline" name="idTimeline" value="<?php echo $idTimeline; ?>">
    <ul class="cbp_tmtimeline">
    <?php foreach ($records as $key => $data) : ?>
    <!-- <?php $dt =  new DateTime($data['app_atendimento_timeline']['create_at']); ?>
    <li>
        <time class="cbp_tmtime" datetime="<?php echo $data['app_atendimento_timeline']['create_at'] ?>"><span><?php echo $dt->format("d/m/y"); ?></span> <span><?php echo $dt->format("H:i"); ?></span></time>
        <div class="cbp_tmicon"></div>
        <div class="cbp_tmlabel">
                <h2 style="padding:0px;margin:2px"><?php echo $arrStatus[$data['app_atendimento_timeline']['andamento_chamado_snapshot']]; ?></h2>
        </div>
    </li> -->
    <li>
        <time class="cbp_tmtime" datetime="<?php echo $data['dt']; ?>"><span><?php echo $data['dt_format']; ?></span> <span><?php echo $data['hour']; ?></span></time>
        <div class="cbp_tmicon"></div>
        <div class="cbp_tmlabel">
            <h2 style="padding:0px;margin:2px"><?php echo $data['label'] . ' ' . $data['pausa']; ?></h2>
        </div>
    </li>
    <?php endforeach; ?>
    </ul>   

</div >
<div style="float: left;width:400px;padding-left:20px">
    <div class="wrap">
        <div class="row" style="margin-left:0px">
            <div style="width:500px">
              <div class="location-map" id="location-map">
                <div style="width: 500px; height: 400px;" id="map_canvas"></div>
              </div>
            </div>
        </div>
    </div>
</div> 
<div style="clear: both"></div>