<?php
    class Achat extends CI_Model{

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

        public function nouveau($code,$quantite){
            try{
                $util = $this->Admin->checkToken();
                if($this->Fonction->IsNullOrEmptyString($code) || $this->Fonction->IsNullOrEmptyString($quantite)){
                    throw new Exception("Veuiller remplir le formulaire.");
                }
                if($quantite <= 0 ){
                    throw new Exception("Quantite invalide");
                }
                $article = $this->Article->select($code);
                //return $this->Fonction->toJson('success',$article,$message='Achat insere');
                $ifArtExist = sizeof($article);
                if($ifArtExist == 0){
                    throw new Exception("Aucun article ne correspond a ce code");
                }

                $idArticle = $article[0]["idarticle"];

                $identifiant = 'ACH';
                $seq = 'achat_seq';
                $idAchat = $this->Fonction->getSeq($identifiant,$seq);
                $now = $this->Fonction->dateNow();

                $articleComplet = $this->Article->selectComplet($idArticle);
                $prix = $articleComplet[0]['prixunitaire'] * $quantite;

                $achat = array(
                    'idachat' => $idAchat,
                    'idarticle' => $idArticle,
                    'dateachat' => $now,
                    'quantiteprod' => $quantite,
                    'prixtotal' => $prix,
                    'etat' => 1,
                );
                $this->db->insert('achat',$achat);
                $res = $this->Fonction->toJson('success',$achat,$message='Achat insere');
                return $res; 
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

        public function valider($idAchat){
            try{
                $util = $this->Admin->checkToken();
                if($this->Fonction->IsNullOrEmptyString($idAchat)){
                    throw new Exception("Veuiller remplir le formulaire.");
                }
                else{
                    $this->db->set('etat', 10);
                    $this->db->where('idachat', $idAchat);
                    $this->db->update('achat');

                    $res = array (
                        'idachat' => $idAchat,
                    );
                    return $this->Fonction->toJson('success',$res,'Achat valider');
                }
            }catch(Exception $ex){
                throw $ex;
            }
        }

        public function select($idAchat){
            $sql = "SELECT * from achatcomplet WHERE idachat like '".$idAchat."'";
            $res = $this->db->query($sql);
            $result = $res->result_array();
            return $result;
        }

        public function getTicket($idAchat){
            try{
                $util = $this->Admin->checkToken();
                $achatComplet = $this->Achat->select($idAchat);
                
            }
            catch(Exception $ex){
                throw $ex;
            }
        }

        public function getRemisePourcentage($prixUnitaire,$pourcentage){
            return ($prixUnitaire * $pourcentage) / 100;
        }

        public function getRemiseGratuit($qte,$min,$gratuit){

            $obtenu = 0 ; //le fanampiny oatra oe 5 teo am caisse de 7 no azo de 2 zany ty
            $aPayer = 0; //le andoavana vola
            $free = 0; //le azo gratuitement tamle nomena teo amle caisse
            $qteDeb = $qte;
            $qteTotal = $qte;

            while ($qte > 0 ){

                if($qte - $min >= 0){
                    $aPayer += $min; 
                    $qte -= $min;
                    if($qte - $gratuit >= 0){
                        $free += $gratuit;
                        $qte -= $gratuit;
                    }
                    else{
                        if($qte == 0){
                            $obtenu += $gratuit;
                        }
                        else{
                            $free = $qte;
                            $obtenu = $gratuit - $qte;
                            $qte = 0;
                        }
                    }  
                }
                else{
                    $aPayer += $qte; 
                    $qte = 0;
                }
            }
            $qteTotal += $obtenu;

            $result = array (
                'min' => $min,
                'gratuit' => $gratuit,
                'qteCaisse' => $qteDeb,
                'aPayer' => $aPayer,
                'free' => $free,
                'obtenu' => $obtenu,
                'qteTotal' => $qteTotal
            ); 
            
            //$res = $this->Fonction->toJson('success',$result,$message='pourcentage ok');
            return $result;
        }
    }
?>