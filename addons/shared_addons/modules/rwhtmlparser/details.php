<?php defined('BASEPATH') or exit('No direct script access allowed');
 
class Module_Rwhtmlparser extends Module {
 
    public $version = '1.0';
 
    public function info()
    {
        return array(
                    'name' => array(
                                    'en' => 'Content generator',
                                    'es' => 'Content generator'
                                    ),
                    'description' => array(
                                            'en' => 'HTML Content generator',
                                            'es' => 'Generador de contenido HTML'
                                            ),
                    'frontend' => false,
                    'backend' => true,
                    'menu' => 'content', // You can also place modules in their top level menu. For example try: 'menu' => 'Sample',
                    'sections' => array(
                                        'items' => array(
                                                        'name'  => 'rwhtmlparser:items', // These are translated from your language file
                                                        'uri'   => 'admin/rwhtmlparser',
                                                        'shortcuts' => array(
                                                                            'create' => array(
                                                                                             'name'  => 'rwhtmlparser:create',
                                                                                             'uri'   => 'admin/rwhtmlparser/create',
                                                                                             'class' => 'add'
                                                                                            )
                                                                            )
                                                            )              
                                        )
                    );
    }

    public function install()
    {
 
        // We made it!
        return true;
    }

    public function uninstall()
    {
        $this->db->delete('settings', array('module' => 'rwhtmlparser'));
        // Put a check in to see if something failed, otherwise it worked
        return true;
    }   

    public function upgrade($old_version)
    {
        // Your Upgrade Logic
        return true;
    }

    public function help()
    {
        // Return a string containing help info
        return "Here you can enter HTML with paragrpah tags or whatever you like";
 
        // or
 
        // You could include a file and return it here.
        return $this->load->view('help', null, true); // loads modules/sample/views/help.php
    }    

}