<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct(){
		parent ::__construct();
        $this->fmt = numfmt_create( 'en_US', NumberFormatter::CURRENCY );
        
        $this->userdata = $this->session->userdata('userdata');
        if(!empty($_SESSION)){ 

            $this->localtimzone =$this->userdata['timezone']; 
        }
        $this->dummy_img = 'dummy_profile_picture.png';
	}


    function uploadTmpImg($img){
        $data = $img;
        $image_array_1 = explode(";", $data);
        $image_array_2 = explode(",", $image_array_1[1]);
        $data = base64_decode($image_array_2[1]);
        $imageName = time().'.png';

        file_put_contents('tmp_upload/'.$imageName, $data);
        return $imageName;
    }

    public function unlinkTempFile(){
        $data = $_POST["filename"];
        $file = './tmp_upload/'.$data;
        if(file_exists($file)){
            unlink($file);
            echo true;
        }
    }

    public function uploadDoc($filename='' , $upload_path='',$allowed_extensions=''){

        $newname = time().$_FILES[$filename]['name'];
        $ext = pathinfo($newname, PATHINFO_EXTENSION);
        if(empty($allowed_extensions)){
            $allowed_extensions = array('docx','doc','pdf');
        }
        if(in_array($ext,$allowed_extensions)){

            $allowed_types = implode('|',$allowed_extensions);

            $config['file_name']            = $newname;
            $config['upload_path']          = $upload_path;
            $config['allowed_types']        = $allowed_types;
            //$config['allowed_types']        = 'docx|doc|pdf';
            // $config['max_size']             = 2000;
            // $config['max_width']            = 20240;
            // $config['max_height']           = 8680;
            //$config['encrypt_name']         = true;

            $this->upload->initialize($config);

            if ( ! $this->upload->do_upload($filename))
            {
                $data = array('error' => $this->upload->display_errors());
            }
            else
            {
                $data = $this->upload->data();
            }
        }else{
            $data = array('error' =>'File Type is not allowed');
        }
        return $data ;
    }

    public function sendGridMail($from="",$to,$subject,$message,$cc="",$attachment="",$attachmentname=""){


        $this->email->clear(TRUE);
        $this->load->library('email');
        // $this->email->initialize(array(
        //   'protocol' => 'smtp',
        //   'smtp_host' => 'smtp.office365.com',
        //   'smtp_user' => 'admin@ethicaltradealliance.com',
        //   'smtp_pass' => '4nzTeFSRKhHfMu%yCB',
        //   'smtp_port' => 587,
        //   'smtp_secure'=> 'encryption_starttls',
        //   'crlf' => "\r\n",
        //   'newline' => "\r\n"
        // ));

        // $this->email->initialize(array(
        //   'protocol' => 'smtp',
        //   'smtp_host' => 'smtp.sendgrid.net',
        //   'smtp_user' => 'noreply',
        //   'smtp_pass' => 'f6EbJqEHpA#T%g^mYU',
        //   'smtp_port' => 587,
        //   'crlf' => "\r\n",
        //   'newline' => "\r\n"
        // ));admin@ethicaltradealliance.com


         $this->email->initialize(array(
          'protocol' => 'smtp',
          'smtp_host' => 'ssl://techville.in',
          'smtp_user' => 'test@techville.in',
          'smtp_pass' => 'Mail@987456321',
          'smtp_port' => 465,
          'crlf' => "\r\n",
          'newline' => "\r\n"
        ));
        
        // if(empty($from)){
            $from = 'admin@ethicaltradealliance.com';
        // }
        
        //$from = 'admin@ethicaltradealliance.com';
        // $from = 'noreply@ethicaltradealliance.com';Server name: smtp.office365.com


       
        $this->email->from($from, 'ETA');
        $this->email->to($to);
        //$this->email->cc('another@another-example.com');
        //$this->email->bcc('them@their-example.com');
        $this->email->subject($subject);
        $this->email->set_mailtype('html');
        $this->email->message($message);


        $mailsent = $this->email->send();

        if($mailsent ==TRUE ){
            $return  =  "TRUE" ;
        }else{
            $return  =$this->email->print_debugger(array('headers'));
        }
        return $return ;
    
    }


/*  
    public function create_pdf($html,$filename){
        $this->m_pdf->pdf = new mPDF();
        $this->m_pdf->showImageErrors = true;
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($filename, 'F'); 
        return $filename;
    }
    */
    
}
