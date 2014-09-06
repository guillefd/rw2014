<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Rwform Plugin
 *
 *
 * @author		Guillermo Dova
 * @package		PyroCMS\Addon\Plugins
 * @copyright	Copyright (c) 2012 PyroCMS
 */
class Plugin_rwform extends Plugin
{
    /**
        * Show form
        *
        * Usage:
        * {{ rwform:buildform }}
        *
        * @return string
        */
    
    public function __construct()
    {
        //language file
        $this->lang->load(array('rwform'));
        $this->load->library('session');   
        //module absolute path
        if (!defined('MODULE_ABS_PATH')) define("MODULE_ABS_PATH", BASE_URL.SHARED_ADDONPATH.'modules/rwform/');
        if (!defined('MODULE_ROUTE_AJX')) define("MODULE_ROUTE_AJX", BASE_URL.'rwform/submit');
    }    
   
    /**
     * Generates the javascript variables form / ajax
     * For later adding after form markup as a <script> TAG
     * @return string 
     */
    private function javascript_vars()
    {
        $script = '<script type="text/javascript">'
                 .' var rwform_input = $(\'input[name="submitEmail"]\'); '
                 .' var rwform_img_loader = \'<img src="'.MODULE_ABS_PATH.'img/rwform_indicator.gif" style="margin:5px;" id="rwform_loader"/></div>\'; '
                 .' var rwform_img_ok = \'<img src="'.MODULE_ABS_PATH.'img/img_ok.png" style="margin:5px;" id="rwform_ajximg"/></div>\'; '
                 .' var rwform_img_error = \'<img src="'.MODULE_ABS_PATH.'img/img_error.png" style="margin:5px;" id="rwform_ajximg"/></div>\'; '                 
                 .' var rwform_target = \''.MODULE_ROUTE_AJX.'\'; '
                 // .' var rwform_alertbar_div = $("#rwform_alertbar"); '
                 .'</script>
                 ';   
        return $script;
    }    
    
    /**
     * Initialization of plugin assets 
     * @return null
     */
    private function load_template_assets()
    {
        // //append CSS styles
           Asset::add_path ('rwform', BASE_URL.SHARED_ADDONPATH.'modules/rwform/');                      
           $this->template->append_css('rwform::rwform.css');        
        // $this->template->append_js('rwform::rwform_plugin.js');       
    }        

    
    public function buildform()
    {
        $this->load_template_assets();
        $captcha = $this->gen_captcha();

        switch( $this->attribute('template') )
        {
            case 'contacto':
                            $output =   '<form class="rwform" id="formE" href="#" onclick="return false;" role="form">'
                                        .'<div class="form-group">'
                                            .'<label>'.lang('rwform:name_label').'</label>'                                          
                                            .'<input name="name" class="form-control input-lg" placeholder="'.lang('rwform:name_placeholder').'" type="text" value="{{ user:first_name }}" />'
                                        .'</div>' 
                                        .'<div class="form-group">'     
                                        .'<label>'.lang('rwform:email_label').'</label>'                                     
                                            .'<input name="email" class="form-control input-lg rwform required" placeholder="'.lang('rwform:email_placeholder').'" type="email" value="{{ user:email }}"/>'                            
                                        .'</div>'
                                        .'<div class="form-group">'
                                            .'<label>'.lang('rwform:phone_label').'</label>'  
                                            .'<input name="phone" class="form-control input-lg rwform required" placeholder="'.lang('rwform:phone_placeholder').'" type="text" value="" />'
                                        .'</div>'                                                                        
                                        .'<div class="form-group">'
                                                .'<label>'.lang('rwform:reason_label').'</label>'                         
                                                .'<select name="subject" class="form-control input-lg rwform required">'
                                                    .'<option value="">Selecciona</option>'
                                                    .'<option value="Presupuesto">Solicitar presupuesto</option>'
                                                    .'<option value="consulta">Consulta</option>'                                
                                                .'</select>'
                                        .'</div>'                                              
                                        .'<div class="form-group">'
                                                .'<label>'.lang('rwform:comments_label').'</label>'  
                                                .'<textarea class="form-control input-lg" name="msg_comments" rows="3" placeholder="'.lang("rwform:comments_placeholder").'"></textarea>'                                                                                                                    
                                        .'</div>'    
                                        .'<div class="form-group">'                                        
                                            .'<label>'.lang('rwform:captcha_label').': </label>'
                                            .'<span class="captcha-text"> '.$captcha.' </span>'                            
                                            .'<select name="captcha" class="form-control input-lg rwform required">'
                                            .$this->dropdown_range_number_helper(-1,10)
                                            .'</select>'                             
                                            .'<br><button id="submit" class="btn btn-danger btn-lg pull-right" type="submit">'.lang('rwform:submit_btn').'</button><br>'
                                            .'<div id="rwform_alertbar" class="alert alert-danger" style="margin-top:5px"></div>'
                                        .'</div>'                                               
                                        .'</form>';
                            break;

            default:        
                            $output =   '<form class="rwform" id="formE" href="#" onclick="return false;">'
                    .'<input name="currenturl" type="hidden" value="{{ url:uri_string }}" />'
                    .'<div class="row-fluid">'
                        .'<div class="span4">'                    
                            .'<label>'.lang('rwform:name_label').'</label>'
                            .'<input name="name" class="input-medium" placeholder="'.lang('rwform:name_placeholder').'" type="text" value="{{ user:first_name }}" />'
                        .'</div>'
                        .'<div class="span4">'
                            .'<label>'.lang('rwform:email_label').'</label>'
                            .'<input name="email" class="input-medium rwform required" placeholder="'.lang('rwform:email_placeholder').'" type="email" value="{{ user:email }}"/>'                            
                        .'</div>' 
                        .'<div class="span4">' 
                            .'<label>'.lang('rwform:phone_label').'</label>'
                            .'<input name="phone" class="input-medium rwform required" placeholder="'.lang('rwform:phone_placeholder').'" type="text" value="" />'
                        .'</div>'                                                                        
                    .'</div>'
                    .'<br>'                    
                    .'<div class="row-fluid">' 
                        .'<div class="span6">'
                            .'<label>'.lang('rwform:reason_label').'</label>'                         
                            .'<select name="subject" class="span11 rwform required">'
                                .'<option value="">'.lang('rwform:reason_placeholder').'</option>'
                                .'<option value="Visita">Coordinar Visita de Salas</option>'
                                .'<option value="Presupuesto">Solicitar Presupuesto</option>'
                                .'<option value="disponibilidad">Consultar Disponibilidad</option>'
                                .'<option value="prereserva">Solicitar Pre-reserva</option>'                                
                                .'<option value="consulta">Otras Consultas</option>'                                
                            .'</select>'
                        .'</div>'    
                        .'<div class="span6">'                            
                            .'<label>'.lang('rwform:location_label').'</label>'
                            .'<input name="msg_location" class="span11 " placeholder="'.lang('rwform:location_label').'" type="text" value="{{ url:segments segment="3" }}/{{ url:segments segment="4" }}" readonly/>'                                 
                        .'</div>'                                             
                    .'</div>'                                        
                    .'<div class="row-fluid">'  
                        .'<div class="span6">'                                      
                            .'<label>'.lang('rwform:schedule_label').'</label>'
                            .'<select name="msg_schedule_1" id="msg_schedule_1" class="input-small rwform required">'
                            .$this->dropdown_range_hour_helper(7,18,9)
                            .'</select> a '                
                            .'<select name="msg_schedule_2" id="msg_schedule_2" class="input-small rwform required">'
                            .$this->dropdown_range_hour_helper(9,22,13)
                            .'</select>'                                                                                
                            .'<label>'.lang('rwform:pax_label').'</label>'
                            .'<select name="msg_pax" class="input-medium">'
                            .'<option value="">Elija</option>'                            
                            .'<option value="1-5">h/ 5 personas</option>'
                            .'<option value="6-10"> h/ 10 personas</option>'
                            .'<option value="11-20"> h/ 20 personas</option>' 
                            .'<option value="21-30"> h/ 30 personas</option>' 
                            .'<option value="31-40"> h/ 40 personas</option>' 
                            .'<option value="41-70"> h/ 70 personas</option>' 
                            .'<option value="71+">mas de 70 personas</option>'                                                                                                                                                                        
                            .'</select>'
                        .'</div>'
                        .'<div class="span3">'        
                            .'<label>'.lang('rwform:hours_label').'</label>'
                            .'<select name="msg_hours" class="input-small">'
                            .'<option value="">Elija</option>'
                            .'<option value="1-3">h/ 2 hs</option>'
                            .'<option value="1-3">h/ 3 hs</option>'
                            .'<option value="4">4 hs</option>'
                            .'<option value="5">5 hs</option>' 
                            .'<option value="6">6 hs</option>' 
                            .'<option value="7">7 hs</option>' 
                            .'<option value="8-9">h/ 9 hs</option>' 
                            .'<option value="9+">mas de 9 hs</option>'                                                                                                                                                                        
                            .'</select>'                            
                            .'<label>'.lang('rwform:startdate_label').'</label>'
                            .'<input name="msg_startdate" id="msg_startdate" data-date-format="dd/mm/yy" class="input-small datepicker" placeholder="'.lang('rwform:startdate_placeholder').'" type="text" />'                                
                        .'</div>' 
                        .'<div class="span3">' 
                            .'<label>'.lang('rwform:totdays_label').'</label>'
                            .'<select name="msg_totdays" class="input-small">'
                            .$this->dropdown_range_number_helper(1,30)
                            .'<option value="30+">mas de 30 días</option>'                                                                                                                                            
                            .'</select>'                            
                            .'<label>'.lang('rwform:enddate_label').'</label>'
                            .'<input name="msg_enddate" id="msg_enddate" data-date-format="dd/mm/yy" class="input-small datepicker" placeholder="'.lang('rwform:enddate_placeholder').'" type="text" />'   
                        .'</div>'
                    .'</div>'    
                    .'<div class="row-fluid">' 
                        .'<div class="span12">'   
                            .'<label>'.lang('rwform:comments_label').'</label>'  
                            .'<textarea class="span12" name="msg_comments" rows="2" placeholder="'.lang("rwform:comments_placeholder").'"></textarea>'                                                                                                                    
                            .'<label>'.lang('rwform:captcha_label').'</label>'
                            .'<span class="text-info">'.$captcha.' </span>'                            
                            .'<select name="captcha" class="input-mini rwform required">'
                            .$this->dropdown_range_number_helper(-1,10)
                            .'</select>'                             
                            .'<br><button id="submit" class="btn btn-primary pull-right" type="submit">'.lang('rwform:submit_btn').'</button><br>'
                            .'<div id="rwform_alertbar" class="alert" style="margin-top:5px"></div>'
                        .'</div>'   
                    .'</div>'                                               
                    .'</form>';         
        }           
        $output.= $this->javascript_vars();        
        return $output;
    }


    public function dropdown_range_number_helper($start = 0, $end = 10)
    {
        $options = '';
        for($i=$start; $i<=$end; $i++)
        {
            $options.='<option value="'.$i.'">'.$i.'</option>';
        }
        return $options;
    }


    public function dropdown_range_hour_helper($start = 7, $end = 18, $selected="")
    {
        $options = '';
        for($i=$start;$i<=$end;$i++)
        {
            $options.='<option value="'.$i.'"';
            if($selected == $i) 
                { 
                    $options.=' selected';
                } 
            $options.='>'.$i.':00</option>';
        }
        return $options;
    }


    public function gen_captcha()
    {
        $sumandos = array('cero','uno','dos','tres','cuatro','cinco');
        $n1 = rand(0,5);
        $n2 = rand(0,5);        
        $txt1 = $sumandos[$n1];
        $txt2 = $sumandos[$n2];        
        $question = 'Cuanto es '.$txt1.' mas '.$txt2.' ?';
        $result = $n1 + $n2;
        $this->session->set_userdata(array('captcharesult'=>$result));
        return $question;        
    } 
    

}

/* End of file Rwform.php */