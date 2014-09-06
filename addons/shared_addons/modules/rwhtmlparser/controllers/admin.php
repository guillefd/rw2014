<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 *
 * @author 		Rewrite
 * @website		http://rewrite-media.com
 * @package             RW for PyroCMS
 * @subpackage 	        
 */
class Admin extends Admin_Controller
{

    protected $section = "items";    

    public function __construct()
    {
        parent::__construct();
        $this->lang->load(array('rwhtmlparser'));
        $this->load->model('rwhtmlparser_m');
    }
    
    public function index()
    {
        $items = array();
        //construye template
        $this->template
                ->title($this->module_details['name'], lang('rwform:items'))
                ->set('items', $items)                      
                ->build('admin/index');        
    }    
    
    
}