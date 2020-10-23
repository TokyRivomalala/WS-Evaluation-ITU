<?php

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: *');
    header("Access-Control-Allow-Methods: GET,POST,DELETE, OPTIONS");

    class AdminController extends CI_Controller{

        public function checkLogin(){
            $email = $this->input->post('email');
            $mdp = $this->input->post('mdp');
            try{
                $res = $this->Admin->checkLogin($email,$mdp);
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
                $res = $this->Admin->checkToken();
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
                $res = $this->Admin->deconnexion();
                echo $res;
            }catch(Exception $ex){
                $erreur = array(
                    'exception' => $ex->getMessage()
                );
                $res = $this->Fonction->toJson('error',$erreur,$message='Erreur de deconnexion');
                echo $res;
            }   
        }

        public function nouveauDate(){
            try{
                $date = $this->input->post('date');
                $res = $this->Admin->nouveauDate($date);
                echo $res;
            }catch(Exception $ex){
                $erreur = array(
                    'exception' => $ex->getMessage()
                );
                $res = $this->Fonction->toJson('error',$erreur,$message='Erreur de d\'insertion');
                echo $res;
            }   
        }
    }

?>