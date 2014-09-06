<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Rooms model
 * @package		PyroCMS
 * @subpackage          Rwform
 * @category            Modules
 */
class Rwhtmlparser_m extends MY_Model
{
    public function __construct()
    {		
            parent::__construct();
            $this->_table = 'rwhtmlparser';           
    }



}    