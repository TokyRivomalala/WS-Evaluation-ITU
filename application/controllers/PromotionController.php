<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: *');
    header("Access-Control-Allow-Methods: GET,POST,DELETE, OPTIONS");

    class PromotionController extends CI_Controller{

        public function recherche($currPage){
            $email = $this->input->get('email');
            $nom = $this->input->get('nom');
            $orderBy = $this->input->get('orderBy');
            $order = $this->input->get('order');
            $dateDeb = $this->input->get('dateDeb');
            $dateFin = $this->input->get('dateFin');
            try{
                $limit = 20;
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

        public function nouveauPourcentage(){
            $pourcentage = $this->input->post('pourcentage');
            try{
                $res = $this->Pourcentage->nouveau($pourcentage);
                echo $res;
            }catch(Exception $ex){
                $erreur = array(
                    'exception' => $ex->getMessage()
                );
                $res = $this->Fonction->toJson('error',$erreur,$message='Erreur d\'insertion');
                echo $res;
            }
        }

        public function nouveauGratuit(){
            $nbMin = $this->input->post('nbmin');
            $nbGratuit = $this->input->post('nbgratuit');
            try{
                $res = $this->Gratuit->nouveau($nbMin,$nbGratuit);
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