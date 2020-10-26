<?php
    class Fonction extends CI_Model{

        public STATIC $now = "";

        public function toJson($status='success',$datas=NULL,$message=''){
            $res=array();
            $res['status']=$status;  
            $res['datas']=$datas;  
            $res['message']=$message;
            return json_encode($res);  
        }

        public function toJsonTicket($status='success',$datas=NULL,$ticket,$message=''){
            $res=array();
            $res['status']=$status;  
            $res['datas']=$datas;  
            $res['ticket'] = $ticket;
            $res['message']=$message;
            return json_encode($res);  
        }

        public function getAuthorizationHeader(){
            $headers = null;
            if (isset($_SERVER['Authorization'])) {
                $headers = trim($_SERVER["Authorization"]);
            }
            else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
                $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
            } elseif (function_exists('apache_request_headers')) {
                $requestHeaders = apache_request_headers();
                // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
                $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
                //print_r($requestHeaders);
                if (isset($requestHeaders['Authorization'])) {
                    $headers = trim($requestHeaders['Authorization']);
                }
            }
            return $headers;
        }
       
        public function getBearerToken() {
            $headers = $this->getAuthorizationHeader();
            // HEADER: Get the access token from the header
            if (!empty($headers)) {
                if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                    return $matches[1];
                }
            }
            return null;
        }

        public function getSeq($identifiant,$seq){
            $sql = "SELECT lpad(nextval('".$seq."')::text,2,'0');";
            $res = $this->db->query($sql);
            $res = $res->row();
            $res = $identifiant.$res->lpad;
            return $res;
        }

        public function IsNullOrEmptyString($str){
            return (!isset($str) || trim($str) === '');
        }

        public function dateNow(){
            $dt = new DateTime();
            $dt->setTimezone(new DateTimeZone('Indian/Antananarivo'));
            return $dt->format('Y-m-d H:i:s');
        }

        public function strToDateTime($dateStr){
            $date = strtotime($dateStr); 
            return date('Y-m-d H:i:s', $date);
        }

        public function generateToken($email,$mdp){
            if($this->IsNullOrEmptyString(Fonction::$now)){
                Fonction::$now = $this->dateNow();
            }
            $token = sha1($email.$mdp.Fonction::$now);
            $expiration = $this->getTokenExpiration();
            $data = array(
                'token' => $token,
                'expiration' => $expiration
            );
            return $data;
        }

        public function getTokenExpiration(){
            $expiration = date('Y-m-d H:i:s', strtotime(Fonction::$now . ' +30 minutes'));
            Fonction::$now = null;
            return $expiration;
        }

        public function getNow(){
            return Fonctionservice::$now;
        }

        public function getNbPage($limit,$resTotalRow){
            $nbPage = 0;
            if($resTotalRow == 0) $nbPage = 0;
            if($resTotalRow < $limit) $nbPage = 1;
            else{
                if($resTotalRow % $limit == 0){
                    $nbPage = $resTotalRow / $limit;
                }
                else{
                    $nbPage = intval($resTotalRow / $limit + 1);
                }
            }
            return $nbPage;
        }

        public function getOffset($currPage,$limit){
            $offset = 0;
            if($currPage == 1) $offset = 0;
            else{
                $offset = ($currPage - 1) * $limit ;
            }
            return $offset;
        }

        public function pushArray($array,$toPush){
            array_push($array,$toPush);
            return $array;
        }

        public function sortArray($array, $on, $order = SORT_ASC){
            $new_array = array();
            $sortable_array = array();
        
            if (count($array) > 0) {
                foreach ($array as $k => $v) {
                    if (is_array($v)) {
                        foreach ($v as $k2 => $v2) {
                            if ($k2 == $on) {
                                $sortable_array[$k] = $v2;
                            }
                        }
                    } else {
                        $sortable_array[$k] = $v;
                    }
                }
        
                switch ($order) {
                    case SORT_ASC:
                        asort($sortable_array);
                        break;
                    case SORT_DESC:
                        arsort($sortable_array);
                        break;
                }
        
                foreach ($sortable_array as $k => $v) {
                    $new_array[$k] = $array[$k];
                }
            }
        
            return $new_array;
        }
    }
?>