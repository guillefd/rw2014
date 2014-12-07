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

    public function insert_template_map($data)
    {
    	return $this->db->insert(self::T_MAPS, $data); 
    }

    public function insert_template_map_rules($data_batch)
    {
    	return $this->db->insert_batch(self::T_MAP_RULES, $data_batch);
    }


}    