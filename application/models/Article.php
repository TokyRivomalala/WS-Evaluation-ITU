<?php
    class Article extends CI_Model{

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

        public function select($code){
            $sql = "SELECT * from article WHERE code like '".$code."'";
            $res = $this->db->query($sql);
            $result = $res->result_array();
            return $result;
        }

        public function nouveau($designation,$code){
            try{
                $ifCodeExist = sizeof($this->Article->select($code));
                if($ifCodeExist > 0){
                    throw new Exception("Ce code existe deja.");
                }
                else{
                    
                    $identifiant = 'ART';
                    $seq = 'article_seq';
                    $idArticle = $this->Fonction->getSeq($identifiant,$seq);

                    $article = array(
                        'idarticle' => $idArticle,
                        'designation' => $designation,
                        'code' => $code
                    );
                    $this->db->insert('article',$article);
                    return $idArticle;
                    //return $this->Fonction->toJson('success',$util,'Article insere');
                }
            }
            catch(Exception $ex){
                throw $ex;
            }
        }

        public function nouveauArticle($designation,$code,$quantiteStock,$prixUnitaire){
            try{
                $util = $this->Admin->checkToken();
                if($this->Fonction->IsNullOrEmptyString($designation) || $this->Fonction->IsNullOrEmptyString($code) || $this->Fonction->IsNullOrEmptyString($quantiteStock) || $this->Fonction->IsNullOrEmptyString($prixUnitaire) ){
                    throw new Exception("Veuiller remplir tout les champs.");
                } 
                else{

                    $idArticle = $this->Article->nouveau($designation,$code);
                    $this->StockArticle->nouveau($idArticle,$quantiteStock,$prixUnitaire);
                    $promotion = $this->Promotion->nouveau($idArticle);

                    
                    $result = array(
                        'idarticle' => $idArticle,
                        'designation' => $designation,
                        'code' => $code,
                        'quantitestock' => $quantiteStock,
                        'prixunitaire' => $prixUnitaire,
                        'pourcentage' => $promotion["idpourcentage"],
                        'gratuit' => $promotion["idgratuit"]
                    );
                    return $this->Fonction->toJson('success',$result,'Article insere');
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