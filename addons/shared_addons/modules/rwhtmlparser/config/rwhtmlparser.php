<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['sourcetypes'] = array(
							'webpage'=>'Website page',
							'rss'=>'Rss',
				 			);

$config['createsource_form_rules'] = array(
											array(
								                    'field'=>'sourcetype', 
								                    'label'=>'lang:rwhtmlparser:sourcetype', 
								                    'rules'=>'required',
								                  ),
											array(
								                    'field'=>'uri', 
								                    'label'=>'lang:rwhtmlparser:uri', 
								                    'rules'=>'required',
								                  ),
											array(
								                    'field'=>'htmlelement', 
								                    'label'=>'lang:rwhtmlparser:htmlelement', 
								                    'rules'=>'required',
								                  ),
											);

$config['content_blocks'] = array(
									'title',
									'subtitle',
									'date',
									'author',
									'content',	
								  );