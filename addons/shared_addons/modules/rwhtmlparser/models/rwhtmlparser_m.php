<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Rooms model
 * @package		PyroCMS
 * @subpackage          Rwform
 * @category            Modules
 */
class Rwhtmlparser_m extends MY_Model
{
	const T_MAPS = 'rwhtmlparser_maps';
    const T_MAP_RULES = 'rwhtmlparser_map_rules'; 

    public function __construct()
    {		
        parent::__construct();          
    }

    ////////////////
    // INSERTS // //
    ////////////////

    public function insert_template_map($data)
    {
    	return $this->db->insert(self::T_MAPS, $data); 
    }

    public function insert_template_map_rules($data_batch)
    {
    	return $this->db->insert_batch(self::T_MAP_RULES, $data_batch);
    }

    ////////////////
    // SELECTS // //
    ////////////////

    public function get_template_maps($params = array())
    {
    	$q = $this->db->get(self::T_MAPS);
    	return $q->result();
    }

    public function get_template_map($id)
    {
    	# queries
    	$q = $this->db->get_where(self::T_MAPS, array('id'=>$id));
    	if($q->row())
    	{
    		$result = new stdClass();
    		$result->map = $q->row();
    		$result->rules = $this->db->get_where(self::T_MAP_RULES, array('map_id'=>$id))->result();
    	}
    	else
	    	{
	    		$result = false;
	    	}
    	return $result;
    }    



    ////////////
    // AUX // //
    ////////////

    private function get_sqlQueryAlias_of_tableFields($table, $table_prefix, $alias_prefix)
    {
        $fldArr= $this->db->list_fields($table);
        $query = '';
        $i = 0;
        foreach($fldArr as $fld)
        {
            $i++;
            $query.= $table_prefix.'.'.$fld.' as '.$alias_prefix.$fld;
            $query.= $i<count($fldArr) ? ', ' : ' '; 
        }  
        return $query;      
    } 

}    