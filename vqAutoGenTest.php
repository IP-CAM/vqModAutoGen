<?php
	
	include_once('vqAutoGen.php');
	
	$vqAutoGen = new vqAutoGen();
	$options   = getopt("f::i::v::");
	$vqAutoGen->setOptions($options);
	$generatedXml = $vqAutoGen->replace('return $url;', 'return "#";', 'system/library/url.php')->generateXml();
	$vqAutoGen->writeXml($generatedXml);