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

    public function __construct()
    {
        parent::__construct();
        $this->lang->load(array('rwform'));
        $this->load->library(array('form_validation'));
        $this->load->model('rwform_m');
    }
    
    public function index()
    {
        // Crea links para paginación
        $total_rows = $this->rwform_m->search('counts');
        //parámetros de paginación: ruta del link, items por vista, links por pagina
        $post_data['pagination'] = create_pagination('admin/rwform', $total_rows, 10, 5); 
        // Ejecuta consulta SQL, con filtros enviados en post_data
        $items = $this->rwform_m->search('results',$post_data);
        //construye template
        $this->template
                ->title($this->module_details['name'], lang('rwform:list_title'))
                ->set('items', $items)
                ->set('pagination', $post_data['pagination'])                        
                ->build('admin/index');        
    }    
    
    
}
