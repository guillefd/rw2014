<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Rooms model
 * @package		PyroCMS
 * @subpackage          Rwform
 * @category            Modules
 */
class Rwform_m extends MY_Model
{
    public function __construct()
    {		
            parent::__construct();
            $this->_table = 'rwform';
            $this->_table_pages ='pages';
            $this->_table_pages_type ='page_types';            
    }
 
    // Metodos abajo
    /**
        * Searches items dado los parametros del vector
        * @param $data array
        * @return array
        */
    function search($mode,$data = array())
    {
        $query = "SELECT * FROM (`default_".$this->_table."`)";
        if (array_key_exists('active', $data))
        {
            $query.= ' WHERE `active` = '.$data['active'];                
        }     
        $query.= " ORDER BY `date` ASC";                        
        // Paginacion: limitar los resultados en función de cantidad de params 1 o 2 (2do es el offset)
        if (isset($data['pagination']['limit']) && is_array($data['pagination']['limit']))
        {
                $query.= " LIMIT ".$data['pagination']['limit'][1].", ".$data['pagination']['limit'][0];
        }        
        elseif (isset($data['pagination']['limit']))
        {    
                $query.= " LIMIT ".$data['pagination']['limit'];
        }        
        //ejecuta consulta
        $q = $this->db->query($query);
        //devuleve registros o solo la cantidad encontrados         
        if($mode =='counts')
        {                
            return $q->num_rows;
        }
        else
            {
                return $q->result();
            }
    } 

    function getPageData($url)
    {
        $this->db->select('*');
        $this->db->from($this->_table_pages); //
        $this->db->join($this->_table_pages_type, $this->_table_pages_type.'.id = '.$this->_table_pages.'.type_id');    
        $this->db->where($this->_table_pages.'.uri', $url); 
        $q = $this->db->get(); 
        if( $q->num_rows()>0 )
        {
            $page = $q->row();
            $this->db->from('pages_'.$page->slug);
            $this->db->where('id', $page->entry_id ); 
            $q2 = $this->db->get(); 
            if( $q2->num_rows()>0 )
            {
                return $q2->row();
            }
            else
            {
                return FALSE;
            }                        
        }
        else
        {
            return FALSE;
        }             
    }      
        
        
        
}
