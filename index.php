
<?php
include_once "header.php"; // this will include a.php
require_once('mobibase.php'); // Load the class
require_once('data.php');
// Instantiation with your username and password
$objMTVS = new MobileTvClient('mcr.api', 'bXFWde');
$objMTVS->setUserAgent( $_SERVER['HTTP_USER_AGENT'] );

$channels = $objMTVS->listChannels(12817);
$main_channel=$streaming[160]["ChannelId"];//Xtream sport
?>
      <?php include("menu.php"); ?>
    <section class="not_in_mobile" id="channels_section">

      <div class="row  media_wrapper" id="media_wrap">
    <!-- <div class="container"> -->
    <div class="container">
      <a href="single_channel.php?ChannelId=<?php echo $main_channel; ?>">
        <div class="col-sm-7 video_box">
          <div class="col-sm-12 main_wrapper">
            <div class="left_img">
              <img class="game-img" alt="" src="images/bungee_jump.jpg"/>
              <div class="bg_text"></div>


            <div class="bg_text_info">
              <b>Xtream Sports </b><br>

              <span>The extream sports channel.100% andrenaline!

            </span>
            </div>
            </div>
          </div>
        </div><!-- end left main img-->
      </a>

      <div class="col-sm-5  right_wrapper_img"><!-- start slider box-->
        <div class="col-sm-12 slider upper_slider">
          <div class="slider">
               <a href="single_channel.php?ChannelId=<?php echo $streaming[431]["ChannelId"];?>">
                 <div class="inner_img">
                   <img class="game-img" alt="" src="images/rightSliderBOx/HeaderRight_2.jpg"/>
                   <div class="right_bg_text"></div>
                   <div class="bg_text_info_right">
                     <h4><b><?php echo $streaming[431]["ChannelName"]; ?></b><br>
                       <span><?php echo $streaming[431]["ChannelBaseline"]; ?></span>
                   </h4>
                   </div>
                 </div>
               </a>
               <a href="single_channel.php?ChannelId=<?php echo $streaming[193]["ChannelId"];   ?>">
                 <div class="inner_img">
                   <img class="game-img" alt="" src="images/rightSliderBOx/HeaderRight_3.jpg"/>
                   <div class="right_bg_text"></div>
                   <div class="bg_text_info_right">
                     <h4><b><?php echo $streaming[193]["ChannelName"]; ?></b><br>
                       <span><?php echo $streaming[193]["ChannelBaseline"]; ?></span>
                   </h4>
                   </div>
                 </div>
               </a>
               <a href="single_channel.php?ChannelId=<?php echo $streaming[160]["ChannelId"];   ?>">
                 <div class="inner_img">
                   <img class="game-img" alt="" src="images/rightSliderBOx/HeaderRight_4.jpg"/>
                   <div class="right_bg_text"></div>
                   <div class="bg_text_info_right">
                     <h4><b><?php echo $streaming[160]["ChannelName"]; ?></b><br>
                       <span><?php echo $streaming[160]["ChannelBaseline"]; ?></span>
                   </h4>
                   </div>
                 </div>
               </a>
          </div>
        </div>
        <div class="col-sm-12 slider upper_slider">
          <div class="slider">
               <a href="single_channel.php?ChannelId='<?php echo $streaming[270]["ChannelId"];   ?>'">
                 <div class="inner_img">
                   <img class="game-img" alt="" src="images/rightSliderBOx/HeaderRight_5.jpg"/>
                   <div class="right_bg_text"></div>
                   <div class="bg_text_info_right">
                     <h4><b><?php echo $streaming[270]["ChannelName"]; ?></b><br>
                       <span><?php echo $streaming[270]["ChannelBaseline"]; ?></span>
                   </h4>
                   </div>
                 </div>
               </a>
               <a href="single_channel.php?ChannelId='<?php echo $streaming[413]["ChannelId"];   ?>'">
                 <div class="inner_img">
                   <img class="game-img" alt="" src="images/rightSliderBOx/HeaderRight_6.jpg"/>
                   <div class="right_bg_text"></div>
                   <div class="bg_text_info_right">
                     <h4><b><?php echo $streaming[413]["ChannelName"]; ?></b><br>
                       <span><?php echo $streaming[413]["ChannelBaseline"]; ?></span>
                   </h4>
                   </div>
                 </div>
               </a>
               <a href="single_channel.php?ChannelId='<?php echo $streaming[149]["ChannelId"];   ?>'">
                 <div class="inner_img">
                   <img class="game-img" alt="" src="images/rightSliderBOx/HeaderRight_1.jpg"/>
                   <div class="right_bg_text"></div>
                   <div class="bg_text_info_right">
                     <h4><b><?php echo $streaming[149]["ChannelName"]; ?></b><br>
                       <span><?php echo $streaming[149]["ChannelBaseline"]; ?></span>
                   </h4>
                   </div>
                 </div>
               </a>
          </div>
        </div>
    </div>
    </div>
  </div><!--END mediawrap-->
    </section>



    <section class="row recent_streams"id="index">
        <div class="container">
          <div class="row title_row">
              <h3 class="text-capitalize">our channels</h3>
          </div>
          <?php foreach ($streaming as $key => $value):?>
          <article class="grow col-sm-4 video_post postType3">
              <div class="inner row m0">
                  <a href="single_channel.php?ChannelId=<?php echo $value["ChannelId"]; ?>"><div class="row screencast m0">
                      <img src="<?php echo $value["mainPic"]; ?>" alt="" class="cast img-responsive">
                  </div></a>
                  <div class="row m0 post_data">
                    <div class="row m0 taxonomy">
                        <div class="fleft category text-uppercase"><a href="single_channel.php?ChannelId=<?php echo $value["ChannelId"]; ?>"><b class="cha_name"><?php echo $value["ChannelName"]; ?> </b><br><?php echo $value["cat"]; ?></a></div>
                    </div>
                  </div>

              </div>
          </article>
          <?php endforeach; ?>
            </div>
        </div>
    </section> <!--Recent streams-->
    <?php
    include_once "footer.php"; // this will include a.php

    ?>
