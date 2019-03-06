<?php
include_once "data.php"; // this will include a.php
require_once('mobibase.php'); // Load the class
$objMTVS = new MobileTvClient('mcr.api', 'bXFWde');
$objMTVS->setUserAgent( $_SERVER['HTTP_USER_AGENT'] );
if (isset($_GET["ChannelId"])) {
  $ChannelId=$_GET["ChannelId"];
  if (isset($streaming[$ChannelId])) {
    $item=$streaming[$ChannelId];
    $channel_name=$item["ChannelName"];
    $channel_lang=$item["ChannelLang"];
    $channel_logo=$item["ChannelLogo"];
    $channel_base=$item["ChannelBaseline"];
    $channel_bg=$item["img"];
    $poster=$item["poster"];
    $id = $_GET['ChannelId'];
  }
}
if (!isset($item)){
  header("location:index.php");
  exit;
}
$ticketId = '7ce6575d36bdb3e8c4988aaf8c832db9';
$network = 'WIFI';
$channelId = $item['ChannelId'];
$channelUrl = $objMTVS->getChannelUrl($channelId, $network, $ticketId);
include_once "header.php"; // this will include a.php

?>

    <section class="row post_page_sidebar post_page_sidebar1" id="single" style="background:url('<?php echo $channel_bg; ?>')">
          <?php include("menu.php"); ?>
        <div class="container">
            <div class="row info_wrap">
              <div class="col-xs-12 content_title" id="title_mobile">
                <span><?php echo $channel_name; ?></span>
              </div>
                <div class="col-sm-8 col-xs-12 post_page_uploads">
                    <div class="author_details post_details row m0">
                        <div class="left_img player_wrapper">
						  <?php
							if (stripos($channelUrl, "http://") !== false) {
echo <<<HTML
                          <div class="video_wrap">
                        	<video poster="{$poster}" src="{$channelUrl}" controls width="100%" height="300px"></video>
                          </div>
HTML;

							}
							else
							{
echo <<<HTML
                          <div class="video_wrap">
                          	<video id="player" poster="{$poster}"></video>
                          </div>
                          <script type="text/javascript" src="https://content.jwplatform.com/libraries/tQYWD6Ok.js"></script>
                          <script>
                          var channelUrl="{$channelUrl}";
                          console.log(channelUrl);
                          var poster="{$poster}";
                              jwplayer('player').setup({
                                  'flashplayer': 'http://demoaccess.mobibase.com/default/js/mediaplayer/jwplayer.swf',
                                  'provider': 'rtmp',
                                  'streamer': 'rtmp://wowza64.mobibase.com:8080/rtplive',
                                  'file': channelUrl,
                                  'image': poster,
                                  'width': '100%',
                                  'height': '400',
                                  'hideLogo': true,
                                  'autostart': false,
                                  'icon': false,
                                  //'stretching': 'none',
                                  'controlbar': 'over',
                                  'controlbar.idlehide': true,
                                  'controlbar.enableTime': false,
                               // 'volume': 25
                              });
                          </script>
HTML;

							}
						  ?>

                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-xs-12 sidebar sidebar2">
                    <div class="row m0 sidebar_row_inner">
                        <!--Sponsored Area-->
                        <div class="row m0 widget widget_sponsored_area">
                              <div class="channel_logo_wrap">
                               <a href="#"><img class="logo-img img-responsive" alt="" src="<?php echo $channel_logo; ?>"/></a>
                              </div>
                          <div class="content_wrapper">
                            <div class="row inner_content">
                              <div class="col-xs-12 content_title">
                                <span><?php echo $channel_name; ?></span>
                              </div>
                            </div>
                            <div class="row text-capitalize content_properties">
                              <ul>
                                <li id="style">Lifstyle</li>
                                <li id="impress"><?php echo $channel_base; ?></li>
                              </ul>
                            </div>
                            <div class="row content_info">
                              <div class="col-xs-12">
                                <p>
                                  <?php echo $channel_base;  ?>
                               </p>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> <!--main_channel_content-->
    <section id="programs">
        <div class="container">
          <div class="row title_row">
              <h3 class="text-capitalize">related channels</h3>
          </div>
          <?php foreach ($streaming as $key => $value):

                if (($value["ChannelId"])!=($id))
                 {?>
                      <div class="col-sm-4  program_info grow">
                              <a href="single_channel.php?ChannelId=<?php echo $value["ChannelId"]; ?>"><div class="row screencast m0">
                                 <img src="<?php echo $value["mainPic"]; ?>" alt="" class="cast img-responsive">
                              </div></a>
                              <div class="row m0 post_data">
                                <div class="row m0 taxonomy">
                                    <div class="fleft category text-uppercase"><a href="single_channel.php?ChannelId=<?php echo $value["ChannelId"]; ?>"><b class="cha_name"><?php echo $value["ChannelName"]; ?> </b><br><?php echo $value["cat"]; ?></a></div>
                                </div>
                              </div>
                      </div>
            <?php }?>
          <?php endforeach; ?>
        </div>
    </section>

    <?php
    include_once "footer.php"; // this will include a.php
    ?>
