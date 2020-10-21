<?php
    class Utilisateur extends CI_Model{

        public function checkLogin($email,$mdp){
            $data = array (
                'email' => $email,
                'mdp' => $mdp
            );
            try{

                $query = $this->db->get_where('utilisateur', $data);
                $res = $query->result_array();
                if(sizeof($res) == 0){
                    throw new Exception('Erreur email ou de mot de passe');
                }
                else{
                    $token=$this->Fonction->generateToken($res[0]['email'],$res[0]['mdp']);

                    $this->db->set('token', $token['token']);
                    $this->db->set('tokenexpiration', $token['expiration']);
                    $this->db->where('idutil', $res[0]['idutil']);
                    $this->db->update('utilisateur');

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
                    $res = $this->db->get_where('utilisateur',array('token'=>$token,'tokenexpiration >= '=>$now));
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
                $util = $this->checkToken();
                $this->db->set('token', NULL);
                $this->db->set('tokenexpiration', NULL);
                $this->db->where('idutil', $util[0]['idutil']);
                $this->db->update('utilisateur');
                return $this->Fonction->toJson('success',$util,'deconnexion reussi');   
            }catch(Exceptioin $ex){
                throw $ex;
            }
        }

        public function recherche($dateNaissStart,$dateNaissFinal,$email,$nom,$orderBy,$order,$limit,$offset){
            try{
                $util = $this->Admin->checkToken();
                if($this->Fonction->IsNullOrEmptyString($nom)) $nom = '%%';
                else $nom = '%'.$nom.'%';

                if($this->Fonction->IsNullOrEmptyString($email)) $email = '%%';
                else $email = '%'.$email.'%';

                if($this->Fonction->IsNullOrEmptyString($orderBy)) $orderBy = '';
                else $orderBy = ' ORDER BY '.$orderBy;

                if($this->Fonction->IsNullOrEmptyString($dateNaissStart) && $this->Fonction->IsNullOrEmptyString($dateNaissFinal)) $dateNaiss = '<= NOW()';
                if($this->Fonction->IsNullOrEmptyString($dateNaissStart) && !$this->Fonction->IsNullOrEmptyString($dateNaissFinal)) $dateNaiss = " <= '". $dateNaissFinal."'";
                if(!$this->Fonction->IsNullOrEmptyString($dateNaissStart) && $this->Fonction->IsNullOrEmptyString($dateNaissFinal)) $dateNaiss = " >= '". $dateNaissStart."'";
                if(!$this->Fonction->IsNullOrEmptyString($dateNaissStart) && !$this->Fonction->IsNullOrEmptyString($dateNaissFinal)) $dateNaiss = " BETWEEN '". $dateNaissStart."' AND '". $dateNaissFinal."'";

                $sql = "SELECT * from utilisateur WHERE nom like '".$nom."' AND datenaiss ".$dateNaiss." AND email LIKE '".$email."'".$orderBy." ".$order." limit ".$limit." offset ".$offset;
                $res = $this->db->query($sql);
                $result = $res->result_array();
                if(sizeof($result) == 0){
                    throw new Exception("Aucun utilisateur trouve");
                }
                else{
                    $test = array('sql' => $sql);
                    return $result;
                }
            }catch(Exception $ex){
                throw $ex;
            }   
        }

        public function rechercheCount($dateNaissStart,$dateNaissFinal,$email,$nom,$orderBy,$order){
            try{
                $util = $this->Admin->checkToken();
                if($this->Fonction->IsNullOrEmptyString($nom)) $nom = '%%';
                else $nom = '%'.$nom.'%';

                if($this->Fonction->IsNullOrEmptyString($email)) $email = '%%';
                else $email = '%'.$email.'%';

                if($this->Fonction->IsNullOrEmptyString($orderBy)) $orderBy = '';
                else $orderBy = ' ORDER BY '.$orderBy;

                if($this->Fonction->IsNullOrEmptyString($dateNaissStart) && $this->Fonction->IsNullOrEmptyString($dateNaissFinal)) $dateNaiss = '<= NOW()';
                if($this->Fonction->IsNullOrEmptyString($dateNaissStart) && !$this->Fonction->IsNullOrEmptyString($dateNaissFinal)) $dateNaiss = " <= '". $dateNaissFinal."'";
                if(!$this->Fonction->IsNullOrEmptyString($dateNaissStart) && $this->Fonction->IsNullOrEmptyString($dateNaissFinal)) $dateNaiss = " >= '". $dateNaissStart."'";
                if(!$this->Fonction->IsNullOrEmptyString($dateNaissStart) && !$this->Fonction->IsNullOrEmptyString($dateNaissFinal)) $dateNaiss = " BETWEEN '". $dateNaissStart."' AND '". $dateNaissFinal."'";

                $sql = "SELECT * from utilisateur WHERE nom like '".$nom."' AND datenaiss ".$dateNaiss." AND email LIKE '".$email."'".$orderBy." ".$order;
                $res = $this->db->query($sql);
                $result = $res->result_array();
                if(sizeof($result) == 0){
                    throw new Exception("Aucun utilisateur trouve");
                }
                else{
                    $test = array('sql' => $sql);
                    return $result;
                }
            }catch(Exception $ex){
                throw $ex;
            }   
        }

        public function nouveau($nom,$prenom,$dateNaiss,$email,$sexe,$mdp){
            try{
                $util = $this->Admin->checkToken();
                if($this->Fonction->IsNullOrEmptyString($nom) || $this->Fonction->IsNullOrEmptyString($prenom) || $this->Fonction->IsNullOrEmptyString($dateNaiss) || $this->Fonction->IsNullOrEmptyString($email) || $this->Fonction->IsNullOrEmptyString($sexe) || $this->Fonction->IsNullOrEmptyString($mdp)){
                    throw new Exception("Veuiller remplir tout les champs.");
                } 
                $now = $this->Fonction->dateNow();
                $dateNaiss = $this->Fonction->strToDateTime($dateNaiss);
                if($dateNaiss > $now){
                    throw new Exception("Veuiller verifier votre date de naissance.");
                }
                else{
                    $identifiant = 'UT';
                    $seq = 'utilisateur_seq';
                    $id = $this->Fonction->getSeq($identifiant,$seq);

                    $util = array(
                        'idutil' => $id,
                        'nom' => $nom,
                        'prenom' => $prenom,
                        'datenaiss' => $dateNaiss,
                        'email' => $email,
                        'sexe' => $sexe,
                        'mdp' => $mdp
                    );
                    $this->db->insert('utilisateur',$util);
                    return $this->Fonction->toJson('success',$util,'Utilisateur insere');
                }
            }
            catch(Exception $ex){
                throw $ex;
            }
        }

        public function modifier($idutil,$mdp){
            try{
                $util = $this->Admin->checkToken();
                if($this->Fonction->IsNullOrEmptyString($mdp) || $this->Fonction->IsNullOrEmptyString($idutil)){
                    throw new Exception("Veuiller remplir le formulaire.");
                }
                else{
                    $this->db->set('mdp', $mdp);
                    $this->db->where('idutil', $idutil);
                    $this->db->update('utilisateur');

                    $res = array (
                        'idutil' => $idutil,
                        'mdp' => $mdp
                    );
                    return $this->Fonction->toJson('success',$res,'Utilisateur modifie');
                }
            }catch(Exception $ex){
                throw $ex;
            }
        }

        public function supprimer($idutil){
            try{
                $util = $this->Admin->checkToken();
                
                $this->db->where('idutil', $idutil);
                $this->db->delete('utilisateur');

                $res = array (
                        'idutil' => $idutil
                );
                return $this->Fonction->toJson('success',$res,'Utilisateur supprime');
            }catch(Exception $ex){
                throw $ex;
            }
        }
    }
?>