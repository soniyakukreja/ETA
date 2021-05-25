<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');
 
require_once APPPATH.'third_party/Spout/Autoloader/autoload.php';

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;


use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

class SpoutLib {
 
    public $writer;
 
    public function __construct()
    {
        //$read_spout = new ReaderEntityFactory();
    }

    public function write_file($fileName)
	{

		$writer = WriterEntityFactory::createXLSXWriter();
		$writer->openToBrowser($fileName); // stream data directly to the browser

		$cells = [
		    WriterEntityFactory::createCell('Carl'),
		    WriterEntityFactory::createCell('is'),
		    WriterEntityFactory::createCell('great!'),
		];



		/** add multiple rows at a time */
		$multipleRows = [
		    WriterEntityFactory::createRow($cells),
		    WriterEntityFactory::createRow($cells),
		];
		$writer->addRows($multipleRows); 

		$writer->close();
	}
}