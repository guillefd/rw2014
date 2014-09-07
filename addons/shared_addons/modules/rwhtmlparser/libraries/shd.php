<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 *
 * @author 		Rewrite
 * @website		http://rewrite-media.com
 * @package             RW for PyroCMS
 * @subpackage 	        
 */
class Shd
{
	public $htmldom;
	private $uri;

	public $html;

	public function __construct()
    {
    	// load library
    	include_once 'simple_html_dom/simple_html_dom.php';
    	// init
    	$this->set_htmlDom();
    	$this->set_html();
    }


    public function set_target($uri = false)
    {
    	if($uri)
    	{
    		$this->set_uri($uri);
    		$this->load_uri();
    		$this->set_html_plaintext();
    	}
    }	


    ///////////////////////////////////////////////
    // PRIVATE ------------------------------ // //
    ///////////////////////////////////////////////
    
    private function load_uri()
    {
    	$this->htmldom->load_file($this->uri);
    }

    private function set_html_plaintext()
    {
    	$this->html->plaintext = $this->htmldom->plaintext;
    }


    ## GETTERS


    ## SETTERS 

    private function set_uri($uri)
    {
    	$this->uri = $uri;
    }

    private function set_htmlDom()
    {
    	$this->htmldom = new simple_html_dom();
    }

    private function set_html()
    {
    	$this->html = new stdClass();
    }


}	