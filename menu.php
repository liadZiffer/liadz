<?php
require_once('data.php');

 ?>
  <section class="row">
      <ul class="nav nav-justified ribbon">
          <li><a href="#"></a></li>
          <li><a href="#"></a></li>
          <li><a href="#"></a></li>
          <li><a href="#"></a></li>
      </ul>
  </section> <!--Ribbon-->
  <section class="row menu_links_wrap">
    <div class=" container">
      <div id="menu" class="menu text-capitalize">
        <ul>
              <li class="has-submenu"><a href="#">sport & news</a>
                <ul class="sub-menu">
                      <?php foreach ($streaming as $key => $value):
                           if (($value["cat"])==="Sports") {?>
                                  <li><a href="single_channel.php?ChannelId=<?php echo $value["ChannelId"]; ?>"><?php echo $value["ChannelName"]; ?></a></li>
                          <?php }?>
                      <?php endforeach; ?>

                </ul>
              </li>
              <li class="has-submenu"><a href="#">kids & education</a>
                    <ul class="sub-menu">
                          <?php foreach ($streaming as $key => $value):
                               if (($value["cat"])==="Kids & Education") {?>
                                      <li><a href="single_channel.php?ChannelId=<?php echo $value["ChannelId"]; ?>"><?php echo $value["ChannelName"]; ?></a></li>
                              <?php }?>
                          <?php endforeach; ?>

                    </ul>
              </li>
              <li class="has-submenu"><a href="#">music</a>
                    <ul class="sub-menu">
                          <?php foreach ($streaming as $key => $value):
                               if (($value["cat"])==="Music") {?>
                                      <li><a href="single_channel.php?ChannelId=<?php echo $value["ChannelId"]; ?>"><?php echo $value["ChannelName"]; ?></a></li>
                              <?php }?>
                          <?php endforeach; ?>

                    </ul>
              </li>
              <li class="has-submenu"><a href="#">lifestyle</a>
                    <ul class="sub-menu">
                          <?php foreach ($streaming as $key => $value):
                               if (($value["cat"])==="Lifestyle") {?>
                                      <li><a href="single_channel.php?ChannelId=<?php echo $value["ChannelId"]; ?>"><?php echo $value["ChannelName"]; ?></a></li>
                              <?php }?>
                          <?php endforeach; ?>

                    </ul>
              </li>
            </ul>


      </div>
    </div>

  </section>
