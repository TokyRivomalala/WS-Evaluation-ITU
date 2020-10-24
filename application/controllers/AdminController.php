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

        public function sortArray(){
            try{

                $array[] = array(
                    'nom' => 'Toky',
                    'age' => 21,
                    'datenaiss' => '01-01-1999'
                );  
                $toPush1 = array(
                    'nom' => 'Fetra',
                    'age' => 23,
                    'datenaiss' => '01-01-1997'
                );
                $toPush2 = array(
                    'nom' => 'Balita',
                    'age' => 19,
                    'datenaiss' => '01-01-2000'
                );

                $res = $this->Fonction->pushArray($array,$toPush1);
                $res = $this->Fonction->pushArray($res,$toPush2);
                
                $colonne = 'datenaiss';
                $res = $this->Fonction->sortArray($res,$colonne,$order = SORT_ASC);

                $res = $this->Fonction->toJson('success',$res,$message='Sort array ok');
                echo $res;
            }catch(Exception $ex){
                $erreur = array(
                    'exception' => $ex->getMessage()
                );
                $res = $this->Fonction->toJson('error',$erreur,$message='Erreur push array');
                echo $res; 
            }
        }
    }

?>