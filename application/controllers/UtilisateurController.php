<?php
    class UtilisateurController extends CI_Controller{

        public function checkLogin(){
            $email = $this->input->post('email');
            $mdp = $this->input->post('mdp');
            try{
                $res = $this->Utilisateur->checkLogin($email,$mdp);
                echo $res;
            }catch(Exception $ex){
                $erreur = array(
                    'exception' => $ex->getMessage()
                );
                $res = $this->Fonction->toJson('error',$erreur,$message='Erreur de connexion');
                echo $res;
            }
        }

        public function checkToken(){
            try{
                $res = $this->Utilisateur->checkToken();
                echo $this->Fonction->toJson('success',$res,'Login ok');
            }catch(Exception $ex){
                $erreur = array(
                    'exception' => $ex->getMessage()
                );
                $res = $this->Fonction->toJson('error',$erreur,$message='Erreur de connexion');
                echo $res;
            }   
        }

        public function deconnexion(){
            try{
                $res = $this->Utilisateur->deconnexion();
                echo $res;
            }catch(Exception $ex){
                $erreur = array(
                    'exception' => $ex->getMessage()
                );
                $res = $this->Fonction->toJson('error',$erreur,$message='Erreur de deconnexion');
                echo $res;
            }   
        }

        public function recherche($currPage){
            $email = $this->input->get('email');
            $nom = $this->input->get('nom');
            $orderBy = $this->input->get('orderBy');
            $order = $this->input->get('order');
            $dateDeb = $this->input->get('dateDeb');
            $dateFin = $this->input->get('dateFin');
            try{
                $limit = 3;
                $offset = $this->Fonction->getOffset($currPage,$limit);

                $res = $this->Utilisateur->recherche($dateDeb,$dateFin,$email,$nom,$orderBy,$order,$limit,$offset);
                $resTotalRow = sizeof($this->Utilisateur->rechercheCount($dateDeb,$dateFin,$email,$nom,$orderBy,$order));

                $nbPage = $this->Fonction->getNbPage($limit,$resTotalRow);

                $arr = array(
                    'util' => $res,
                    'nbPage' => $nbPage
                );
                $val = $this->Fonction->toJson('success',$arr, $resTotalRow.' utilisateur(s) trouvee');
                echo $val;
            }catch(Exception $ex){
                $erreur = array(
                    'exception' => $ex->getMessage()
                );
                $res = $this->Fonction->toJson('error',$erreur,$message='Aucun Utilisateur');
                echo $res;
            }
        }

        public function nouveau(){
            $nom = $this->input->post('nom');
            $prenom = $this->input->post('prenom');
            $dateNaiss = $this->input->post('dateNaiss');
            $email = $this->input->post('email');
            $sexe = $this->input->post('sexe');
            $mdp = $this->input->post('mdp');
            try{
                $res = $this->Utilisateur->nouveau($nom,$prenom,$dateNaiss,$email,$sexe,$mdp);
                echo $res;
            }catch(Exception $ex){
                $erreur = array(
                    'exception' => $ex->getMessage()
                );
                $res = $this->Fonction->toJson('error',$erreur,$message='Erreur d\'insertion');
                echo $res;
            }
        }

        public function modifier(){
            try{
                $idutil = $this->input->post('idutil');
                $mdp = $this->input->post('mdp');
                $res = $this->Utilisateur->modifier($idutil,$mdp);
                echo $res;
            }catch(Exception $ex){
                $erreur = array(
                    'exception' => $ex->getMessage()
                );
                $res = $this->Fonction->toJson('error',$erreur,$message='Erreur de modification');
                echo $res;
            }   
        }

        public function supprimer($idutil){
            try{
                $res = $this->Utilisateur->supprimer($idutil);
                echo $res;
            }catch(Exception $ex){
                $erreur = array(
                    'exception' => $ex->getMessage()
                );
                $res = $this->Fonction->toJson('error',$erreur,$message='Erreur de suppression');
                echo $res;
            }   
        }
    }

?>