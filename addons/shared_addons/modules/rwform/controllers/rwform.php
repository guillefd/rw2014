<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @package  	PyroCMS
 * @subpackage  Rwform 
 * @category  	Module
 */
class Rwform extends Public_Controller 
{
	/**
	 * Array that contains the validation rules
	 * @access protected
	 * @var array
	 */
	protected $validation_rules = array(
                                        array(
                                            'field' => 'formid',
                                            'label' => 'lang:rwform:form_label',
                                            'rules' => 'trim'
                                        ),         
                                		array(
                                			'field' => 'email',
                                			'label' => 'lang:rwform:email_label',
                                			'rules' => 'trim|valid_email|required'
                                		),    
                                        array(
                                            'field' => 'subject',
                                            'label' => 'lang:rwform:reason_label',
                                            'rules' => 'trim|required'
                                        ), 
                                        array(
                                            'field' => 'sender_name',
                                            'label' => 'lang:rwform:name_label',
                                            'rules' => 'trim'
                                        ),
                                        array(
                                            'field' => 'sender_phone',
                                            'label' => 'lang:rwform:phone_label',
                                            'rules' => 'trim'
                                        ),   
                                        array(
                                            'field' => 'sender_movil',
                                            'label' => 'lang:rwform:movil_label',
                                            'rules' => 'trim'
                                        ),
                                        array(
                                            'field' => 'sender_city',
                                            'label' => 'lang:rwform:city_label',
                                            'rules' => 'trim'
                                        ),   
                                        array(
                                            'field' => 'sender_company',
                                            'label' => 'lang:rwform:company_label',
                                            'rules' => 'trim'
                                        ),
                                        array(
                                            'field' => 'msg_location',
                                            'label' => 'lang:rwform:location_label',
                                            'rules' => 'trim'
                                        ),                                        
                                        array(
                                            'field' => 'msg_hours',
                                            'label' => 'lang:rwform:hours_label',
                                            'rules' => 'trim'
                                        ),                   
                                        array(
                                            'field' => 'msg_days',
                                            'label' => 'lang:rwform:days_label',
                                            'rules' => 'trim'
                                        ), 
                                        array(
                                            'field' => 'msg_startdate',
                                            'label' => 'lang:rwform:startdate_label',
                                            'rules' => 'trim'
                                        ),
                                        array(
                                            'field' => 'msg_enddate',
                                            'label' => 'lang:rwform:startdate_label',
                                            'rules' => 'trim'
                                        ),                                        
                                        array(
                                            'field' => 'msg_schedule_1',
                                            'label' => 'lang:rwform:schedule_label',
                                            'rules' => 'trim'
                                        ),
                                        array(
                                            'field' => 'msg_schedule_2',
                                            'label' => 'lang:rwform:schedule_label',
                                            'rules' => 'trim'
                                        ),
                                        array(
                                            'field' => 'msg_pax',
                                            'label' => 'lang:rwform:pax_label',
                                            'rules' => 'trim'
                                        ),      
                                        array(
                                            'field' => 'msg_comments',
                                            'label' => 'lang:rwform:comment_label',
                                            'rules' => 'trim|required'
                                        ),   
                                        array(
                                            'field' => 'captcha',
                                            'label' => 'lang:rwform:captcha_label',
                                            'rules' => 'trim|required|callback_check_captcha'
                                        ),                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
                                	);
    
    public function __construct()
    {
        parent::__construct();
        $this->lang->load(array('rwform'));
        $this->load->library(array('form_validation'));
        $this->load->model('rwform_m');
    }        
    
    /**
     * Submits email address posted via ajax
     * @return json string
     */
    public function submit()
    {
        //json response
        $rwform_data->response = false;
        $this->form_validation->set_rules($this->validation_rules);           
        // Validate the data
        if ($this->form_validation->run())
        {
            $processdata = $this->process_data();             
            $sendTo = $this->getContactEmail($processdata['msg']['currenturl']);                  
            $data = array(
                'email'=>$this->input->post('email'),
                'userid'=>$this->current_user->id,
                'sender_data' =>serialize( $processdata['sender'] ),
                'message_data' => serialize( $processdata['msg'] ),
                'ip_address'=>$this->session->userdata('ip_address'),
                'user_agent'=>$this->session->userdata('user_agent'),
                'date'=> now()
            );         
            if($this->rwform_m->insert($data))
            {    
                date_default_timezone_set('America/Buenos_Aires');
                $now = time();
                if( $mail = $this->send_email($processdata, $now, 'office', $sendTo) )
                {
                    $mail = $this->send_email($processdata, $now, 'sender', $sendTo);
                    //var_dump($mail);
                } 
                // else
                // {
                //     var_dump($this->email->print_debugger());
                // }      
                //json response          
                $rwform_data->response = 'OK';
                $rwform_data->message = lang('rwform:submited'); 
                $rwform_data->cssclass = 'alert-success';
            }
            else
            {
                $rwform_data->response = 'ERROR';
                $rwform_data->message = lang('rwform:submiterror');
                $rwform_data->cssclass = 'alert-danger';                 
            }
        }
        else
        {
            $rwform_data->response = 'ERROR';
            $rwform_data->message = validation_errors();
            $rwform_data->cssclass = 'alert-danger';            
        }
        echo json_encode($rwform_data);
    }

    public function process_data()
    {
        $result = array();
        $sender_array = array('email','name','phone','movil','city','company');
        $msg_array = array('currenturl','subject','msg_location','msg_hours','msg_totdays','msg_startdate','msg_enddate','msg_schedule_1','msg_schedule_2','msg_pax','msg_comments');
        foreach($sender_array as $key)
        {
            $result['sender'][$key] = $this->input->post($key) ? $this->input->post($key) : '--';
        }
        foreach($msg_array as $key)
        {
            $result['msg'][$key] = $this->input->post($key) ? $this->input->post($key) : '--';
        }        
        return $result;
    }


    public function check_captcha($num)
    {
        if (trim($num) != $this->session->userdata('captcharesult'))
        {
            $this->form_validation->set_message('check_captcha', lang('rwform:captchaerror'));
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }


    public function send_email($data, $now, $target, $sendTo_address)
    { 
        //config
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'utf-8';

        $this->email->initialize($config);        

        switch($target)
        {
            case 'office':
                        //message
                        $from      = $data['sender']['email'];
                        $from_name = ($data['sender']['name']!='') ? $data['sender']['name'] : 'Contacto web';
                        $reply_to  = $data['sender']['email'];
                        $to        = $sendTo_address;
                        $subject   = 'ReWrite | form - ['.$data['msg']['subject']. ' #'.now().'';
                        $body      = $this->gen_email_message($data, $now, $target); 
                        break;
            case 'sender':
                        //message
                        $from      = 'info@rewrite.com.ar';            
                        $from_name = 'ReWrite';
                        $reply_to  = $sendTo_address; 
                        $to        = $data['sender']['email'];
                        $subject   = 'ReWrite - Recibimos tu mensaje - [Ref:'.$data['msg']['subject']. ' #'.now().'';
                        $body      = $this->gen_email_message($data, $now, $target); 
                        break;                        
        }        

        //send
        $this->email->from($from, $from_name);
        $this->email->reply_to($reply_to);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($body);        

        return $this->email->send();        
    } 


    public function gen_email_message($data, $now, $target)
    {
        $sender = $data['sender'];
        $msg = $data['msg'];

        switch($target)
        {
            case 'office':
                            $html = '<p><strong>Mensaje completo:</strong></p>'
                                    .'<p><strong>Asunto: </strong>'.$msg["subject"].'<br>'
                                    .'<table cellpadding="4" style="border: 1px solid #ddd; width:100%; padding:5px;">'
                                    .'<tr>'
                                        .'<td>Fecha</td><td>'.unix_to_human($now).' [GMT -3] </td>'
                                    .'</tr>'
                                    .'<tr>'  
                                        .'<td>Nombre</td><td>'.$sender["name"].'</td>'     
                                    .'</tr>'
                                    .'<tr>'                    
                                        .'<td>Email</td><td>'.$sender["email"].'</td>' 
                                    .'</tr>'
                                    .'<tr>'                                             
                                        .'<td>Telefono</td><td>[tel: '.$sender["phone"].']  [cel: '.$sender["movil"].']</td>' 
                                    .'</tr>'
                                    .'<tr>'                   
                                        .'<td colspan="2">&nbsp;</td>'    
                                    .'</tr>'                    
                                    .'<tr>'                   
                                        .'<td>Asunto</td><td>'.$msg["subject"].'</td>'    
                                    .'</tr>'                                                           
                                    .'<tr>'                   
                                        .'<td>Mensaje: </td><td>'.$msg["msg_comments"].'</td>'    
                                    .'</tr>'                                
                                    .'</table>'
                                    .'<p>Origen: [IP: '.$this->session->userdata("ip_address").'] [User ID: '.$this->current_user->id.']</p>'                                
                                    .'<p><small> &#169;'.date("Y").' &#183; Powered by ReWrite</small></p>';
                            break;
            case 'sender':    
                            $html = '<h3>Contacto Web | Rewrite.com.ar <br><br>'
                                    .'Enviaste un mensaje desde '.site_url().$msg["currenturl"].'</h3>'
                                    .'<p>Gracias por visitarnos!<br>'
                                    .'Recibimos tu mensaje, ya lo estamos procesando y te responderemos muy pronto.<br>'
                                    .'Abajo transcribimos tu mensaje completo.</p>'
                                    .'<p>Asunto: <strong>'.$msg["subject"].'</strong></p>'
                                    .'<table cellpadding="4" style="border: 1px solid #ddd; width:100%; padding:5px;">'
                                    .'<tr>'
                                        .'<td>Fecha</td><td>'.unix_to_human($now).' [GMT -3] </td>'
                                    .'</tr>'
                                    .'<tr>'  
                                        .'<td>Nombre</td><td>'.$sender["name"].'</td>'     
                                    .'</tr>'
                                    .'<tr>'                    
                                        .'<td>Email</td><td>'.$sender["email"].'</td>' 
                                    .'</tr>'
                                    .'<tr>'                                             
                                        .'<td>Telefono</td><td>[tel: '.$sender["phone"].']  [cel: '.$sender["movil"].']</td>' 
                                    .'</tr>'
                                    .'<tr>'                   
                                        .'<td colspan="2">&nbsp;</td>'    
                                    .'</tr>'                    
                                    .'<tr>'                   
                                        .'<td>Asunto</td><td>'.$msg["subject"].'</td>'    
                                    .'</tr>'                                                           
                                    .'<tr>'                   
                                        .'<td>Mensaje: </td><td>'.$msg["msg_comments"].'</td>'    
                                    .'</tr>'                                
                                    .'</table>'
                                    .'<p></p>'                                
                                    .'<p><small> &#169;'.date("Y").' &#183; Powered by ReWrite</small></p>';
                                    break;
        }
        return $html;        
    }


    public function getContactEmail($currenturl)
    {
        if($currenturl!='')
        {
            if( ($page = $this->rwform_m->getPageData($currenturl)) && (isset($page->contact_email)) )
            {
                return $page->contact_email; 
            }  
            else
                {
                    return Settings::get('mail_smtp_user');
                }  
        }
        else
            {
                return Settings::get('mail_smtp_user');
            }        
    }          
}

/* End of file rwform.php */