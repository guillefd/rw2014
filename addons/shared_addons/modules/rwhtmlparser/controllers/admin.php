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
    private $CFG;    
    private $parser;
    private $parserIndexed;
    private $postvalues;

    public function __construct()
    {
        parent::__construct();
        $this->lang->load(array('rwhtmlparser'));
        $this->load->model('rwhtmlparser_m');
        $this->load->helper('rwhtmlparser');
        // set CFG
        $this->config->load('rwhtmlparser', true);
        $this->CFG = $this->config->item('rwhtmlparser');
        // load assets
        $this->set_common_template_metadata();

        // FULL DEBUG ##########################
        if(ENVIRONMENT == PYRO_DEVELOPMENT) $this->set_full_dump();
        // #####################################        
    }
    
    public function index()
    {
        $items = array();
        //construye template
        $this->template
                ->title($this->module_details['name'], lang('rwhtmlparser:items'))
                ->set('items', $items)                      
                ->build('admin/index');        
    }


    public function create()
    {
        $this->form_validation->set_rules($this->CFG['createsource_form_rules']);
        //populate
        $this->set_postvalues();
        if($this->form_validation->run())
        {
            $this->init_parser();
            $this->run_parser();
            $this->tagindex_parser_result();
        }
        //construye template
        $this->template
                ->title($this->module_details['name'], lang('rwhtmlparser:createsource'))
                ->set( array(
                             'sourcetypes'=>$this->CFG['sourcetypes'],
                             'node_properties'=>$this->CFG['node_properties'],
                             'content_blocks'=>$this->CFG['content_blocks'],
                             'postvalues'=>$this->postvalues,  
                             'parser'=>$this->parser,
                             ))                      
                ->build('admin/createsource');  
        # clean dom        
        $this->clean_parser();                        
    }

    public function createparsertemplate()
    {
var_dump($this->input->post());

    }
 
    ///////////////////////////////////////
    // PRIVATE ------------------------- //
    ///////////////////////////////////////

    private function init_parser()
    {
        // load Simple Html DOM Library
        $this->load->library('shd');
        // init parser object
        $this->parser = new stdClass();
        $this->parser->sourcetype = $this->postvalues['sourcetype'];
        $this->parser->uri = $this->postvalues['uri'];
        $this->parser->htmlelement = $this->postvalues['htmlelement'];
        $this->parser->htmlelementparam = $this->postvalues['htmlelementparam'];       
    }


    private function run_parser()
    {
        set_time_limit(600);
        switch($this->parser->sourcetype)
        {
            case 'webpage':
                            $this->shd->set_target($this->parser->uri);
                            if($this->parser->htmlelementparam)
                            {
                                $this->parser->result['nodes'] = $this->shd->htmldom->find($this->parser->htmlelement, $this->parser->htmlelementparam);
                            }   
                            else
                                {
                                    $this->parser->result['nodes'] = $this->shd->htmldom->find($this->parser->htmlelement);
                                }                         
                            break;

            default:
                            $this->parser->result = null;
                            break;                
        }
    }


    private function tagindex_parser_result()
    {
        if(isset($this->parser->result))
        {
            $this->parserIndexed = array();
            foreach($this->parser->result['nodes'] as $node)
            {
                $newnode = new stdClass();
                $newnode->tag = $node->tag;
                $newnode->plaintext = $node->plaintext;
                $newnode->innertext = $node->innertext;
                $newnode->outertext = $node->outertext;
                $newnode->attr = $node->attr; 
                $this->parserIndexed[$node->tag][] = $newnode;
            }
        }
echo '<pre>';
print_r($this->parserIndexed);
echo '</pre>';
die;
    }


    private function clean_parser()
    {
        if(isset($this->parser->result))
        {
            $this->shd->clean_htmldom();
        }
    }    


    //////////////////////////
    // AUX --------------// //
    //////////////////////////

    private function set_common_template_metadata()
    {
        // common assets
        $this->template->append_metadata('<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">');
        Asset::css('module::admin_rwhtmlparser.css');
    }

    private function set_postvalues()
    {
        foreach($this->CFG['createsource_form_rules'] as $rArr)
        {
            $this->postvalues[$rArr['field']] = $this->input->post($rArr['field']); 
        }
        //validate
        $this->postvalues['uri'] = $this->postvalues['uri']!='' ? $this->get_validated_uri_string($this->postvalues['uri']) : '';
    }

    private function get_validated_uri_string($uri)
    {
        if(strripos($uri, 'http://')===false)
        {
            $uri = 'http://'.$uri;
        }      
        return $uri;
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



        // $this->shd->set_target('http://www.smashingmagazine.com/2014/08/27/customizing-wordpress-archives-categories-terms-taxonomies/');
        
        
        // // html object
        // //var_dump($this->shd->htmldom);

        // // find
        // $nodes = $this->shd->htmldom->find('article');

        // foreach($nodes as $node)
        // {
        //     echo '### {'.$node->tag.'}<br>';
        //     foreach($node->children as $child)
        //     {
        //         echo '###### {'.$child->tag.'} <br>';
        //         var_dump($child->tag);
        //         var_dump($child->attr);
        //         var_dump($child->plaintext);
        //         var_dump($child->innertext);
        //         var_dump($child->outertext);
        //         if(count($child->children)>0)
        //         {
        //             foreach($child->children as $child1)
        //             {
        //                 echo '######### {'.$child1->tag.'}<br>';
        //                 var_dump($child1->plaintext);                        
        //                 var_dump($child1->tag);
        //                 var_dump($child1->attr);
        //                 echo '######### end <br>';
        //             }
        //         }
        //         echo '###### end {'.$child1->tag.'}<br>';
        //     }
        //     echo '### NODE <br>';
        // }

        // //var_dump($nodes);

        // die;

    
}