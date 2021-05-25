<?php 
require_once __DIR__ . '/vendor/autoload.php';
class GeneratePdf{
	public static function save($content='',$filename){
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->WriteHTML($content);
		$mpdf->showImageErrors = true;
        $mpdf->Output($filename, 'F'); 
    }
    
    public static function download($content='',$filename){
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->WriteHTML($content);
		$mpdf->showImageErrors = true;
        $mpdf->Output($filename, 'D'); 
    }
}
?>