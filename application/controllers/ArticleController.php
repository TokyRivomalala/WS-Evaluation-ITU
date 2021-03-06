<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: *');
    header("Access-Control-Allow-Methods: GET,POST,DELETE, OPTIONS");

    class ArticleController extends CI_Controller{

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

        public function selectComplet($currPage){
            try{
                $limit = 20000;
                $offset = $this->Fonction->getOffset($currPage,$limit);

                $res = $this->Article->selectArticle($limit,$offset);
                $resTotalRow = sizeof($this->Article->selectArticleRow());

                $nbPage = $this->Fonction->getNbPage($limit,$resTotalRow);

                $arr = array(
                    'article' => $res,
                    'nbPage' => $nbPage
                );
                $val = $this->Fonction->toJson('success',$arr, $resTotalRow.' article(s) trouvee');
                echo $val;
            }catch(Exception $ex){
                $erreur = array(
                    'exception' => $ex->getMessage()
                );
                $res = $this->Fonction->toJson('error',$erreur,$message='Aucun Article');
                echo $res;
            }
        }

        public function nouveau(){
            $designation = $this->input->post('designation');
            $code = $this->input->post('code');
            $quantiteStock = $this->input->post('quantitestock');
            $prixUnitaire = $this->input->post('prixunitaire');
            try{
                $res = $this->Article->nouveauArticle($designation,$code,$quantiteStock,$prixUnitaire);
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