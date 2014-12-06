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
            $this->template->set(array(
                                     'nodes'=>$this->parserIndexed->nodes,
                                     'count'=>$this->parserIndexed->count,
                                     'tagsArr'=>$this->parserIndexed->tags,
                                    ));
        }
        //construye template
        $this->template
                ->title($this->module_details['name'], lang('rwhtmlparser:createsource'))
                ->set( array(
                             'sourcetypes'=>$this->CFG['sourcetypes'],
                             'node_properties'=>$this->CFG['node_properties'],
                             'content_blocks'=>$this->CFG['content_blocks'],
                             'postvalues'=>$this->postvalues,
                             ))                      
                ->build('admin/createsource');  
        # clean dom        
        $this->clean_parser();                        
    }

    public function createparsertemplate()
    {
        if($this->input->post() 
            && is_array($this->input->post('childnode')) 
            && count($this->input->post('childnode'))>0 )
        {
            $this->createparsertemplate_process();

        }
        else
            {
                $this->session->set_flashdata('error', lang('rwhtmlparser:createparsermap_empty'));
                redirect('admin/rwhtmlparser/create');
            }


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
        $nodeorder = 0;
        $childorder = 0;
        $count = 0;
        $this->parserIndexed = new stdClass();
        $this->parserIndexed->nodes = array();
        $this->parserIndexed->count = 0;
        $this->parserIndexed->tags = array();
        if(isset($this->parser->result))
        {
            foreach($this->parser->result['nodes'] as $node)
            {
                $newnode = new stdClass();
                $newnode->order = $nodeorder;
                $newnode->tag = $node->tag;
                $newnode->tags = array();
                $newnode->plaintext = trim($node->plaintext);
                $newnode->innertext = trim($node->innertext);
                $newnode->outertext = trim($node->outertext);
                $newnode->attr = $node->attr;
                $childorder = 0; 
                foreach($node->children as $child)
                {                 
                    $newchild = new stdClass();
                    $newchild->tag = $child->tag;
                    $newchild->plaintext = trim($child->plaintext);
                    $newchild->innertext = trim($child->innertext);
                    $newchild->outertext = trim($child->outertext);
                    $newchild->attr = $child->attr;  
                    $newchild->order = $childorder;                 
                    $child2order = 0; 
                    // save tag
                    $this->parserIndexed->tags[$child->tag][$child->tag] = isset($this->parserIndexed->tags[$child->tag][$child->tag])
                                                                                   ? $this->parserIndexed->tags[$child->tag][$child->tag] + 1
                                                                                   : 1; 
                    foreach($child->children as $child2)
                    {
                        $newchild2 = new stdClass();
                        $newchild2->tag = $child->tag.' '.$child2->tag;
                        $newchild2->plaintext = trim($child2->plaintext);
                        $newchild2->innertext = trim($child2->innertext);
                        $newchild2->outertext = trim($child2->outertext);
                        $newchild2->attr = $child2->attr;  
                        $newchild2->order = $child2order;
                        $newchild->child2nodes[$newchild2->tag][$child2order] = $newchild2; 
                        // save tags                   
                        $this->parserIndexed->tags[$child->tag][$newchild2->tag] = isset($this->parserIndexed->tags[$child->tag][$newchild2->tag])
                                                                                   ? $this->parserIndexed->tags[$child->tag][$newchild2->tag] + 1
                                                                                   : 1;                                                                        
                        $child2order++; 
                    }
                    // save node
                    $newnode->childnodes[$child->tag][$childorder] = $newchild;                    
                    $childorder++;
                    $count+= $child2order;
                }
                $this->parserIndexed->nodes[] = $newnode;
                $nodeorder++;
                $count+= $childorder;
            }
            $this->parserIndexed->count = $count;
        }
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


    ////////////////////////////
    // Process Parser Mapping //
    ////////////////////////////

    private function createparsertemplate_process()
    {
        # init
        $parsermap = array(
                        'type'=>'',
                        'uri'=>'',
                        'node'=>'',
                        'map'=>array(),
                        );
        # post input data
        $p_childnodes = $this->input->post('childnode');  
        $p_required = $this->input->post('required');
        $p_nodepropertyselector = $this->input->post('nodepropertyselector');
        $p_condition = $this->input->post('condition');
        $p_contentblockselector = $this->input->post('contentblockselector');
        # iterate      
        foreach($p_childnodes as $childnode)
        {
            $map = array(
                        'childnode'=>$childnode,
                        'required'=>isset($p_required[$childnode]) ? $p_required[$childnode] : 0,
                        'nodepropertyselector'=>$p_nodepropertyselector[$childnode],
                        'condition_notempty'=>$p_condition['notempty'][$childnode],
                        'condition_keywordyesvalue'=>$p_condition['keywordyesvalue'][$childnode],
                        'condition_keywordnovalue'=>$p_condition['keywordnovalue'][$childnode],
                        'contentblockselector'=>$p_contentblockselector[$childnode],    
                        );
            $parsermap['map'][$childnode] = $map;    
        }
var_dump($parsermap);

    }


    //////////////////////////////
    // DEBUG --------------- // //
    //////////////////////////////

    private function set_full_dump()
    {
        ini_set('xdebug.var_display_max_depth', 9);
        ini_set('xdebug.var_display_max_children', 25);
        ini_set('xdebug.var_display_max_data', 150);       
    }   

    
}