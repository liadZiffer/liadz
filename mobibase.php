<?php 
/** 
 * MobileTvClient 
 * 
 * @version 1.3 2012-03-22 
 * @package MobileTvSolutionApi 
 * @documentation 1.3.1 (http://resourcekit.mobibase.com/documents/show/14) 
 * 
 * UPDATE 100914 GC documentation 
 * UPDATE 100929 GC cleaned up => 0.2 
 * UPDATE 101021 GC added setCarrier() => 0.3, doc => v1.2.1 
 * UPDATE 101026 GC added getChannelsEPG => 0.4 
 * UPDATE 110110 GC GPRS bearer removed => 0.5 
 * FIX 110707 GC getTicketChannels => 0.6 
 * UPDATE 110712 GC added synchronizeCampaign => 0.7, doc => VOD appendix v1.0.0 
 * FIX 110725 TG isTicketValid => 0.8 
 * contact e-mail address: resourcekit@mobibase.com 
*/ 
class MobileTvClient { 

    /** 
     * API Request result 
     * @var array 
     */ 
    public $results = array(); 

    /** 
     * API Request error 
     * @var string 
     */ 
    public $error; 

    /** 
     * Api endpoitn url 
     *  @var string 
     */ 
    protected $url; 

    /** 
     * API Request parameter 
     * @var array 
     */ 
    protected $params = 
        array( 
            "login"         => null, 
            "password"         => null, 
            "vendor"         => null, 
            "model"         => null, 
            "user_agent"    => null, 
            "urlok"         => null, 
            "urlko"         => null, 
            "carrier"         => null, 
            "debug"            => null, 
        ); 

    /** 
     * Available networks 
     */ 
    public static $BEARER_EDGE = 'EDGE'; 
    public static $BEARER_UMTS = 'UMTS'; 
    public static $BEARER_HSDPA = 'HSDPA'; 
    public static $BEARER_WEB = 'WEB'; 
    public static $BEARER_IPHONE = 'IPHONE'; 

    /** 
     * @var display some useful informations 
     */ 
    public $debug = false; 
    public $showLastRequest = false; 

    /** 
     * 
     * @param string $login Login 
     * @param string $password Password 
     * @param string $url API endpoint url 
     */ 
    public function __construct($login, $password, $url="") { 
        if(is_null($url) || strlen($url) == 0) { 
      $url = "http://mobiletv.mobibase.com/api/service.php"; 
        } 
        $this->url = $url; 
        $this->params['login']=$login; 
        $this->params['password']=$password; 
    } 

    //=============================================== 

    /* 
     * Handset selection 
     * API will reply with response adapted to the selected handset (if necessary) 
     * 
     * 2 main choices : 
     *     - by its useragent 
     *  - by model / vendor 
     */ 

    /** 
     * Select an handset by its useragent 
     * @param string $user_agent User Agent 
     */ 
    public function setUserAgent($user_agent) { 
        $this->params['user_agent'] = base64_encode($user_agent); 
    } 

    /* 
     * Check handset capabilities 
     */ 

    /** 
     * Check if an handset is streaming compatible 
     * @param string user agent. If set : override params[user_agent] 
     * @return boolean 
     * 
     * UPDATE 100831 GC force base64 encoding 
     */ 
    public function isStreamingCompatible($user_agent = "") { 
        if($user_agent != '') { 
            $this->setUserAgent($user_agent); 
        } 
        $this->params['action'] = "is_streaming_compatible"; 
        if($this->getResults()) { 
            return $this->results['Return'] == 1; 
        } 
        return $this->getError(); 
    } 

    /** 
     * Retrieve service list 
     * @return array of service 
     */ 
    public function listServices() { 
        $this->cleanParams(); 
        $this->params['action'] = "list_services"; 
        if($this->getResults()) { 
            return $this->results['Service']; 
        } 
        return $this->getError(); 
    } 

    /* 
     * Channel 
     */ 

    /** 
     * Retrieve channel list 
     * @return array of channel 
     */ 
    public function listChannels($serviceId /* AK */) { 
        $this->cleanParams(); 
        $this->params['action'] = "list_channels"; 
    $this->params['service'] = $serviceId; // AK 
        if($this->getResults()) { 
            return $this->results['Channel']; 
        } 
        return $this->getError(); 
    } 

    /** 
     * Get the channel's streaming url 
     * The streaming will be adapted to the handset capabilities 
     * ie : iphone url != nokia handset url 
     * 
     * @param int/string channel id or name 
     * @param string network choose one : [GPRS|EDGE|UMTS|HSDPA|IPHONE] 
     * @param string ticket value (@see createTicket()) [optional] You will have to append the ticket 
     * @param string urlko NOT IMPLEMENTED 
     * @param string urlok NOT IMPLEMENTED 
     * @return string streaming url (ie: rtsp://xxx.mobibase.com/...) 
     */ 
    public function getChannelUrl($channel,$network,$ticket="") { // AK $urlko="",$urlok="") { 
        $this->cleanParams(); 
        $this->params['channel'] = $channel; 
        $this->params['network'] = $network; 
        $this->params['ticket'] = $ticket; 
//        $this->params['urlko'] = base64_encode($urlok); 
//        $this->params['urlok'] = base64_encode($urlko); 
        $this->params['action'] = "get_channel_url"; 
        if($this->getResults()) { 
            return $this->getResult("Url"); 
        } 
        return $this->getError(); 
    } 


    /** 
     * Check ticket validity 
     * @param string $ticket 
     * @return boolean 
     */ 
    public function isTicketValid($ticket) { 
        $this->cleanParams(); 
        $this->params['ticket'] = $ticket; 
        $this->params['action'] = "is_ticket_valid"; 

                            if($this->getResults()) { 
                return ($this->results['Return']==1); 
        } 
                            return $this->getError(); 
    } 


    /** 
     * Burn ticket 
     * @param $ticket value 
     * @param $strtime 
     * @return new expiration date time 
     */ 
    public function invalidateTicket($ticket /*, AK $strtime = "now" */ ) { 
        $this->cleanParams(); 
        $this->params['ticket'] = $ticket; 
    // AK        $this->params['strtime'] = $strtime; 
        $this->params['action'] = "invalidate_ticket"; 
        if($this->getResults()) { 
            return $this->results['Validity']; 
        } 
        return $this->getError(); 
    } 

  

    /** 
     * Get ticket profiles listing of a service 
     * 
     * @param string $service Nom ou Identifiant du service 
     * @return array 
     *      array( 
     *         Name => ticket profile name, 
     *       Service => service name, 
     *       ServiceID => service id, 
     *       MaxDuration => max duration, 
     *       MaxBytesSent => max bytes sent, 
     *       MaxSessions => max session number, 
     *       MaxSessionDuration => max duration per session 
     *       Validity => expiration date, 
     *       Networks => allowed networks (GPRS,EDGE,UMTS,HSDPA,...) 
     *    ) 
     * ) 
     */ 
    public function getTicketProfiles($service) { 
        $this->cleanParams(); 
        $this->params['service'] = $service; 
        $this->params['action'] = "get_ticket_profiles"; 
        if($this->getResults()) { 
            return $this->results['TicketProfile']; 
        } 
        return $this->getError(); 
    } 

    /** 
     * Create new ticket 
     * 
     * @param int/string $profile ticket profile id or name 
     * @param string $tracking_id arbitrary customer tracking id 
     * @param string $carrier network operator 
     * @return string ticket value 
     */ 
    public function createTicket($profile, $tracking_id, $carrier='') { 
        $this->cleanParams(); 
        $this->params['tracking_id'] = $tracking_id; 
        $this->params['profile'] = $profile; 
    if ( !empty($carrier) ) 
      $this->params['carrier'] = $carrier; 
        $this->params['action'] = "create_ticket"; 
    // AK    $this->showLastRequest = TRUE; 
        if($this->getResults()) { 
      $this->showLastRequest = FALSE; 
      return $this->getResult("Ticket"); 
        } 
    // AK $this->showLastRequest = FALSE; 
        return false; 
    } 



    /** 
     * Get allowed channels listing 
     * TODO complete array output 
     * 
     * @param string $ticket value 
     * @return array channels id and name 
     */ 
    public function getTicketChannels($ticket) { 
        $this->cleanParams(); 
        $this->params['ticket'] = $ticket; 
        $this->params['action'] = "get_ticket_channels"; 
        $toRet = array(); 

        if(!$this->getResults() || !is_array($this->results['Channel'])) { 
            return $toret; 
        } 

        $tmp = array(); 
        $toRet = array(); 
        foreach($this->results['Channel'] as $channel) { 
            if(isset($tmp['ChannelId']) && in_array($tmp['ChannelId'], $tmp)) { 
                continue; 
            } 
            $toRet[] = array( 
                    'Id' => $channel['ChannelId'], 
                    'Name' => $channel['ChannelName'], 
                    ); 
            $tmp[] =  $channel['ChannelId']; 
        } 

        unset($tmp); 
        return $toRet; 
    } 

    /** 
     * Get session count of a ticket 
     * 
     * @param string $ticket value 
     * @return int Nombre de sessions 
     */ 
    public function getTicketNbSessions($ticket) { 
        $this->cleanParams(); 
        $this->params['ticket'] = $ticket; 
        $this->params['action'] = "get_ticket_nb_sessions"; 
        if($this->getResults()) { 
            return $this->getResult("Sessions"); 
        } 
        return false; 
    } 

    /** 
     * Get cumulated duration consumed 
     * 
     * @param string $ticket value 
     * @param int/string $channel id or name (optional filter) 
     * @param date $date begin on 
     * @return int seconds 
     */ 
    public function getTicketDuration($ticket, $channel="", $date="0") { 
        $this->cleanParams(); 
        $this->params['ticket'] = $ticket; 
        $this->params['channel'] = $channel; 
        $this->params['date'] = $date; 
        $this->params['action'] = "get_ticket_duration"; 
        if($this->getResults()) { 
            return $this->getResult("Duration"); 
        } 
        return false; 
    } 

  

    /** 
     * Get cumulated duration consumed by customer tracking id 
     * 
     * @param string $tracking_id customer tracking id 
     * @param int/string $channel id or name 
     * @param datetime $date begin on 
     * @return int seconds 
     */ 
    public function getDurationFromTrackingId($tracking_id, $channel="", $date="0") { 
        $this->cleanParams(); 
        $this->params['tracking_id'] = $tracking_id; 
        $this->params['channel'] = $channel; 
        $this->params['date'] = $date; 
        $this->params['action'] = "get_duration_from_tracking_id"; 
        if($this->getResults()) { 
            return $this->getResult("Duration"); 
        } 
        return false; 
    } 

    /** 
     * Get ticket expiration date 
     * 
     * @param string ticket value 
     * @return datatime expiration date 
     */ 
    public function getTicketEndingDate($ticket) { 
        $this->cleanParams(); 
        $this->params['ticket'] = $ticket; 
        $this->params['action'] = "get_ticket_ending_date"; 
        if($this->getResults()) { 
            return $this->getResult("EndingDate"); 
        } 
        return false; 
    } 

  
    /* 
     * Misc 
     */ 

    /** 
     * Get error message 
     * @return string Erreur 
     */ 
    public function getError() { 
        return $this->error; 
    } 

    /** 
     * Get debug data 
     */ 
    public function getDebug() { 
        return $this->results['Debug']; 
    } 

    /** 
     * Enable / disable debug 
     * @param bool $debug 
     */ 
    public function setDebug($debug) { 
        $this->params['debug'] = $debug; 
    } 

    /** 
     * Parse le resultat de la requete dans un tableau associatif 
     * 
     * @return bool False si le service renvoit une erreur 
     */ 
    protected function getResults() { 
        $this->results = array(); 
        $query = $this->getQuery(); 

        if ($this->showLastRequest) { echo $this->url.$query."\n"; } 

        $lines = file($this->url.$query); 

        if ($this->debug) var_dump($lines); 

        $start = false; 
        $xml = ""; 
        foreach($lines as $line) { 
            $line = trim(html_entity_decode($line)); 
            if(preg_match('/.*(<\?.*\?>).*/',$line,$matches)) { 
                $start = true; 
                $line = $matches[1]; 
            } 
            if($start) { 
                $xml .= $line; 
            } 
        } 
        $array = $this->xml2array($xml); 
        if(count($array['Response']) == 0) { 
            return false; 
        } 
        if(isset($array['Response']['Error'])) { 
            $this->error = $array['Response']['Error']; 
            return false; 
        } 
        $this->results = $array['Response']; 
        return true; 
    } 

    /** 
     * Retourne un champs du tableau. 
     * Cette m?thode sert dans le cas d'une r?ponse simple 
     * (une seule balise dans la r?ponse) 
     * 
     * @return string 
     */ 
    protected function getResult($field) { 
        return $this->results[$field]; 
    } 

    /** 
     * Formate l'url de requ?te sur l'API a partir des diff?rents param?tres 
     * 
     * @return string url avec param?tre GET url encod?s 
     */ 
    protected function getQuery() { 
        $query = "?"; 
        foreach($this->params as $key => $val) { 
            if($val != "") { 
                $query .= $key.'='.urlencode($val)."&"; 
            } 
        } 

        $this->debug("query => $query"); 

        return $query; 
    } 

    protected function isHandsetSelected() { 
        return ( 
            isset($this->params['handset_id']) 
            || (isset($this->params['user_agent'])) 
            || (isset($this->params['model']) && isset($this->params['vendor']))); 
    } 

    /** 
     * Enleve les retours chariots et les espaces dans une chaine 
     * 
     * @param string $str 
     * @return string 
     */ 
    protected function cleanLine($str) { 
        return str_replace(array("\n","\r","\r\n"),"",trim($str)); 
    } 

    /** 
     * On fait le m?nage avant une nouvelle requete 
     */ 
    protected function cleanParams($clean_handset = true) { 
        //Concerne certains param?tres pour avoir un acc?s stateless 
        $login         = $this->params['login']; 
        $password     = $this->params['password']; 
        $vendor     = $this->params['vendor']; 
        $model         = $this->params['model']; 
        $user_agent = $this->params['user_agent']; 
        $carrier     = $this->params['carrier']; 
    // AK        $campaign     = $this->params['campaign_id']; 
        $urlok         = $this->params['urlok']; 
        $urlko         = $this->params['urlko']; 
        $debug        = $this->params['debug']; 
        $this->params = array(); 
        $this->params['login']         = $login; 
        $this->params['password']     = $password; 
        $this->params['vendor']     = $vendor; 
        $this->params['model']         = $model; 
        $this->params['user_agent'] = $user_agent; 
        $this->params['carrier']     = $carrier; 
    // AK        $this->params['campaign_id']         = null; 
        $this->params['debug']         = $debug; 
        $this->params['urlok']         = null; 
        $this->params['urlko']         = null; 
        $this->params['service']     = null; 
        $this->params['ticket_profile'] = null; 
    } 

    /** 
     * Retourne un tableau associatif a partir d'une 
     * structure xml 
     * 
     * @param string $xml 
     * @return assoc array 
     */ 
    protected function xml2array($xml) { 
        $values = array(); 
        $index  = array(); 
        $arr  = array(); 
        $parser = xml_parser_create(); 
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1); 
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0); 
        xml_parse_into_struct($parser, $xml, $values, $index); 
        xml_parser_free($parser); 
        $i = 0; 
        $name = $values[$i]['tag']; 
        $arr[$name] = isset($values[$i]['attributes']) ? $values[$i]['attributes'] : ''; 
        $arr[$name] = $this->toArray($values, $i); 
        return $arr; 
    } 

    /** 
     * Fonction utilis?e pour la conversion xml => array 
     * 
     * @param array $values Tableau de donn?es xml 
     * @param int $i Pointeur dans le tableau de donn?e 
     * @return Array 
     */ 
    protected function toArray($values, &$i){ 
        $child = array(); 
        if (isset($values[$i]['value'])) 
            array_push($child, $values[$i]['value']); 
        while ($i++ < count($values)) { 
            switch ($values[$i]['type']) { 
                case 'cdata': 
                    array_push($child, $values[$i]['value']); 
                    break; 
                case 'complete': 
                    $name = $values[$i]['tag']; 
                    if(!empty($name)){ 
                        $child[$name] = $values[$i]['value']; 
                        if(isset($values[$i]['attributes'])) { 
                            $child[$name] = $values[$i]['attributes']; 
                        } 
                    } 
                      break; 
                case 'open': 
                    $name = $values[$i]['tag']; 
                    $size = isset($child[$name]) ? sizeof($child[$name]) : 0; 
                    $child[$name][$size] = $this->toArray($values, $i); 
                    break; 
                case 'close': 
                    return $child; 
            } 
        } 
        return $child; 
    } 

    protected function debug($str) { 

        if (!$this->debug) 
            return; 

        echo date("Y-m-d H:i:s")." $str\n"; 
    } 
} 

//class MobileTvException extends Exception { } 