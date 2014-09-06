<?php defined('BASEPATH') or exit('No direct script access allowed');
 
class Module_Rwform extends Module {
 
    public $version = '1.0';
 
    public function info()
    {
        return array(
            'name' => array(
                'en' => 'Rw Form',
                'es' => 'Rw Form'

            ),
            'description' => array(
                'en' => 'Forntpage Contact form',
                'es' => 'Formulario de contacto para el sitio'
            ),
            'frontend' => false,
            'backend' => true,
            'menu' => 'design', // You can also place modules in their top level menu. For example try: 'menu' => 'Sample',
            'sections' => array(
                'create' => array(
                    'name'  => 'rwform:items', // These are translated from your language file
                    'uri'   => 'admin/rwform/index',
                        'shortcuts' => array(
                            'create' => array(
                                'name'  => 'rwform:create',
                                'uri'   => 'admin/rwform/create',
                                'class' => 'add'
                                )
                            )
                        )              
                )
        );
    }

    public function install()
    {
        $this->dbforge->drop_table('rwform');
        $this->db->delete('settings', array('module' => 'rwform'));
 
        $rwform = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'auto_increment' => true
            ),
            'userid' => array(
                'type' => 'INT',
                'constraint' => '11',
                'null' => TRUE
            ),            
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => '150'
            ),
            'sender_data' => array(
                'type' => 'TEXT'
            ),
            'message_data' => array(
                'type' => 'TEXT'
            ),                        
            'ip_address' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            ),            
            'user_agent' => array(
                'type' => 'VARCHAR',
                'constraint' => '150'
            ),
            'date' => array(
                'type' => 'VARCHAR',
                'constraint' => '50'
            )                       
        );

        $this->dbforge->add_field($rwform);
        $this->dbforge->add_key('id', true);
 
        // Let's try running our DB Forge Table and inserting some settings
        if ( ! $this->dbforge->create_table('rwform'))
        {
            return false;
        }
 
        // We made it!
        return true;
    }

    public function uninstall()
    {
        $this->dbforge->drop_table('rwform');
 
        $this->db->delete('settings', array('module' => 'rwform'));
 
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