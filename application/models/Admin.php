<?php
    class Admin extends CI_Model{

        public function checkLogin($email,$mdp){
            $data = array (
                'email' => $email,
                'mdp' => $mdp
            );
            try{

                $query = $this->db->get_where('admin', $data);
                $res = $query->result_array();
                if(sizeof($res) == 0){
                    throw new Exception('Erreur email ou de mot de passe');
                }
                else{
                    $token=$this->Fonction->generateToken($res[0]['email'],$res[0]['mdp']);

                    $this->db->set('token', $token['token']);
                    $this->db->set('tokenexpiration', $token['expiration']);
                    $this->db->where('idadmin', $res[0]['idadmin']);
                    $this->db->update('admin');

                    return $this->Fonction->toJson('success',$token,'Login ok');
                }
            }catch(Exception $ex){
                throw $ex;
            }
        }

        public function checkToken(){
            $token = $this->Fonction->getBearerToken();
            try{
                if(!isset($token)){
                    throw new Exception ("Veuiller d'abord vous connecter .");
                }
                else{
                    $now = $this->Fonction->dateNow();
                    $res = $this->db->get_where('admin',array('token'=>$token,'tokenexpiration >= '=>$now));
                    $result = $res->result_array();
                    if(sizeof($result) == 0 ){
                        throw new Exception("Veuiller d'abord vous connecter");
                    }
                    else{
                        return $result;
                    }
                }
            }catch(Exception $ex){
                throw $ex;
            }

        }

        public function deconnexion(){
            try{
                $admin = $this->checkToken();
                $this->db->set('token', NULL);
                $this->db->set('tokenexpiration', NULL);
                $this->db->where('idadmin', $admin[0]['idadmin']);
                $this->db->update('admin');
                return $this->Fonction->toJson('success',$admin,'deconnexion reussi');   
            }catch(Exceptioin $ex){
                throw $ex;
            }
        }

        public function nouveauDate($date){
            try{
                if($this->Fonction->IsNullOrEmptyString($date)){
                    throw new Exception("Date ne devrait pas etre null");
                }
                $util = array(
                    'date' => $date
                );
                $this->db->insert('testdate',$util);
                return $this->Fonction->toJson('success',$util,'Date insere');  
            }
            catch(Exception $ex){
                throw $ex;
            }
        } 
    }
?>