<?php

class RddfParser
{

# some relevent information on dataset from rdf file
	public $site_url;
	public $title;
	public $body;
	public $dataset_url;
	public $source_name;
	public $source_url;
	public $time_period;

# constructor taking a rdf file 
	function __construct($file){
	# checking file exist or not
		if (file_exists(SITE_ROOT.DS.'rdf'.DS.$file)) {
		# getting contents from file
			$rdf = file_get_contents(SITE_ROOT.DS.'rdf'.DS.$file);
		# making rdf file xml compatible by replacing ':' with '_'
			$rdf = str_replace(':', '_', $rdf);
			$rdf = str_replace('_ ', ': ', $rdf);
				$rdf = str_replace('p_/', 'p:/', $rdf);

			$xml = new SimpleXMLElement($rdf);
		# extracting data from xml object
			$this->site_url = $xml->site_Dataset['rdf_about'];
			$this->title = $xml->site_Dataset[0]->site_dataset_Title;
			$this->body = $xml->site_Dataset[0]->site_dataset_Body;
			$this->dataset_url = $xml->site_Dataset[0]->site_dataset_Data['rdf_resource'];
			$this->source_name = $xml->site_Dataset[0]->site_dataset_Source_name;
			$this->source_url = $xml->site_Dataset[0]->site_dataset_Source_url['rdf_resource'];
			$this->time_period = $xml->site_Dataset[0]->site_dataset_Time_period;
		} else {
		# file does not exist and exiting
			exit('Failed to open '.$file);
		}
	}
}

