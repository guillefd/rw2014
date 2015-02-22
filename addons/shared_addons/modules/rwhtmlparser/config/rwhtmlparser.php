<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['sourcetypes'] = array(
							'webpage'=>'Website page',
							'rss'=>'Rss',
				 			);

$config['createsource_form_rules'] = array(
											array(
								                    'field'=>'mapname', 
								                    'label'=>'lang:rwhtmlparser:mapname', 
								                    'rules'=>'required',
								                  ),
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
											array(
								                    'field'=>'htmlelementparam', 
								                    'label'=>'lang:rwhtmlparser:htmlelementparam', 
								                    'rules'=>'',
								                  ),
											);

$config['content_blocks'] = array(
									'title'=>'Title',
									'subtitle'=>'Subtitle',
									'date'=>'Date',
									'author'=>'Author',
									'subtitlecontent'=>'Subtitle content',
									'textcontent'=>'Text content',
									'mediacontent'=>'Media content',	
									'link'=>'Link',
								  );

$config['node_properties'] = array(
									'plaintext',
									'outertext',
									'innertext',
									);