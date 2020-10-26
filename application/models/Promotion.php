<?php
    class Promotion extends CI_Model{

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

        public function nouveau($idArticle){
            try{
                $idGratuit = 'GRT01';
                $idPourcentage = "PRC01";

                $remise = array(
                    'idarticle' => $idArticle,
                    'idgratuit' => $idGratuit,
                    'idpourcentage' => $idPourcentage
                );
                $this->db->insert('remise',$remise);
                return $remise;
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