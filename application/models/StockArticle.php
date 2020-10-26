<?php
    class StockArticle extends CI_Model{

        public function nouveau($idArticle,$quantiteStock,$prixUnitaire){
            try{
                if($quantiteStock <= 0 ){
                    throw new Exception("Quantite invalide");
                }
                if($prixUnitaire <= 0 ){
                    throw new Exception("Prix invalide");
                }
                $stockArticle = array(
                    'idarticle' => $idArticle,
                    'quantitestock' => $quantiteStock,
                    'prixunitaire' => $prixUnitaire
                );
                $this->db->insert('stockarticle',$stockArticle);
                //return $this->Fonction->toJson('success',$util,'Article insere');
            }
            catch(Exception $ex){
                throw $ex;
            }
        }

    }
?>