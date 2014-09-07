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
        $this->load->library('shd');
        $this->load->model('rwhtmlparser_m');

        // FULL DEBUG ##########################
        if(ENVIRONMENT == PYRO_DEVELOPMENT)
        {
            $this->set_full_dump();
        }
        // #####################################        
    }
    
    public function index()
    {
        $this->shd->set_target('http://www.smashingmagazine.com/2014/08/27/customizing-wordpress-archives-categories-terms-taxonomies/');
        
        
        // html object
        //var_dump($this->shd->htmldom);

        // find
        $nodes = $this->shd->htmldom->find('article');

        foreach($nodes as $node)
        {
            echo '### {'.$node->tag.'}<br>';
            foreach($node->children as $child)
            {
                echo '###### {'.$child->tag.'} <br>';
                var_dump($child->tag);
                var_dump($child->attr);
                var_dump($child->plaintext);
                var_dump($child->innertext);
                var_dump($child->outertext);
                if(count($child->children)>0)
                {
                    foreach($child->children as $child1)
                    {
                        echo '######### {'.$child1->tag.'}<br>';
                        var_dump($child1->plaintext);                        
                        var_dump($child1->tag);
                        var_dump($child1->attr);
                        echo '######### end <br>';
                    }
                }
                echo '###### end {'.$child1->tag.'}<br>';
            }
            echo '### NODE <br>';
        }



        //var_dump($nodes);

        die;

        $items = array();
        //construye template
        $this->template
                ->title($this->module_details['name'], lang('rwhtmlparser:items'))
                ->set('items', $items)                      
                ->build('admin/index');        
    }

    public function target()
    {
        $this->template
                ->title($this->module_details['name'], lang('rwhtmlparser:settarget_title'))                   
                ->build('admin/settarget');        
    }    
    


    //////////////////////////////
    // DEBUG --------------- // //
    //////////////////////////////

    private function set_full_dump()
    {
        ini_set('xdebug.var_display_max_depth', 3);
        ini_set('xdebug.var_display_max_children', 25);
        ini_set('xdebug.var_display_max_data', 150);       
    }   

    
}