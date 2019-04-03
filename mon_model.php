<?php
/**
 * (c) Stephane Agoume  <agoumekoufanas@gmail.com>
 * Date: 26/08/2015
 */

/**
 * @author Stephane Agoume  <agoumekoufanas@gmail.com> <stephaneagoume.com>
 * @description :  Bibliotheque de gestion de la base de données s'appuyant sur l'active
 * record . Cette bibliotheque ou librairie s'integre facilement à CodeIgniter
 * 
 * @version  1.0
 * 03/10/2015
 */


class mon_model extends CI_Model
{
    private $table;
    public function __construct()
    {
        $this->table = "chambre";
    }

    public function set($table,$data)
    {
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    /**
     * @description : when 'id' is the attribute condition is based on
     * you can use this when your table content an attribute witch name is "id"
     * 
     * otherwise just use the "updates" function  , witch is more flexible
     * @param type $table
     * @param type $data
     * @param type $id
     */
    
    public function edit($table,$data,$id)
    {
        $this->db->where('id', $id);
        $this->db->update($table, $data);
    }
    
    /**
     * 
     * @param type $table : the concerned table
     * @param type $data  : set the new data , into an array 
     * @param type $data_where :  specify the condition of edit 
     * exemple $data_where = array("nom"=>"Léana")
     */
    public function updates($table,$data,$data_where)
    {
        $this->db->where($data_where);
        $this->db->update($table, $data);
    }
    
    /**
     *  mise à jour 02/02/2016
     *  @var field_order permet de definir l'attribut sur lequel une condition d'ordre existe
     *  @var order permet de definir le type d'ordre 
     * exemple get($table,'date_','ASC');  
     */

    public function get($table,$field_order = NULL,$order = NULL,$field_where = NULL)
    {
        // test s'il y'a une sur l'ordre
        
        if(($field_order != NULL)&&($order != NULL)){
           $this->db->order_by($field_order, $order); 
        }
        
        // test s'il y'a une condition sur Where 
        
        if($field_where != NULL){
           $this->db->where($field_where);  
        }
      
        $query = $this->db->get($table);
        return $query->result();
    }

    public function getbyid($table,$id)
    {
        $limit = 1;
        $offset = 0;
        $query = $this->db->get_where($table, array('id' => $id), $limit, $offset);
        return $query->row();
    }
    
    /*
     * j'appelle ce concept scène de ménage , ou guere des roles
     * parfois faire des chose dans une incompletude est benefique pour la personne qui doit continuer avec
     */
    
    public function getbyidinc($table,$id)
    {
        $limit = 1;
        $offset = 0;
        $query = $this->db->get_where($table, array('id' => $id), $limit, $offset);
        return $query;
    }

    public function getbyid_chambre($table,$id)
    {
        $limit = 1;
        $offset = 0;
        $query = $this->db->get_where($table, array('id_chambre' => $id), $limit, $offset);
        return $query->row();
    }

    /**
     * get the asking element in parameter array ( we can call data_where)
     * @param type $table
     * @param type $data_where
     * @return type
     */
    public function getbyelement($table,$data_where)
    {
        $query = $this->db->get_where($table, $data_where);
        return $query->row();
    }

    public function getAllbyelement($table,$data_where)
    {
        $query = $this->db->get_where($table, $data_where);
        return $query->result();
    }

    public function getAllelementwithrelation()
    {
        $this->db->select('*');
        $this->db->from('photo');
        $this->db->join('chambre', 'chambre.id = photo.id_chambre');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * @param int $id
     * @param array $photo
     * @return array
     */
    public function get_photo($id = null,$photo = null)
    {
        $id = 31;
        $photo = $this->chambre->getAllbyelement('photo',array('id_chambre'=>$id));
        return $photo;
    }

    /**
     * code portion of delete
     * NB : Never delete data from database
     */
    
    /**
     * 
     * @param type $table
     * @param type $id
     */
    
    public function delete($table,$data,$data_where)
    {
        $this->updates($table, $data, $data_where);
    }



   
}