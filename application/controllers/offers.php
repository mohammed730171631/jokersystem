<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class offers extends MY_Controller {

    public function __construct() {
        parent::__construct();
      
         
    if (!$this->auth->logged_in()) {
         redirect('site/login');
           
        }
      }
public function load_data(){
      $this->load->library('datatables_server_side', array(
      'table' => 'offers', //name of the table to fetch data from
      'get_url' => 'offers/get_offers', //primary key field name
      'delete_url' => 'offers/delete', //primary key field name
      // 'url' => base_url('offers/get_offers'), //primary key field name
      'custom_select_status' => 'true', //primary key field name
      'custom_select' => 'select offers.*,offer_image.image from offers  left join offer_image on  offers.id=offer_image.offer_id where offer_image.type="primary" or offer_image.type IS NULL ', //primary key field name
      'edit' => 'true', //primary key field name
      'delete' => 'true', //primary key field name
      'primary_key' => 'id', //primary key field name
      'columns' => array('id','name','description','order','is_active','image','action'), //zero-based array of field names. 
      'where' => array() //associative array or custom where string
    ));
       $this->datatables_server_side->process();
    
}



function index() {
        if (!$this->rbac->hasPrivilege('offers', 'can_view')) {
            access_denied();
        }
        $data['groups']=$this->groups_model->get();
        $this->session->set_userdata('top_menu', 'setting');
        $this->session->set_userdata('sub_menu', 'offers/index');
        $this->load_view('offers/offersList',$data);
    }


function add()
{
    if (!$this->rbac->hasPrivilege('offers', 'can_add') && !$this->rbac->hasPrivilege('offers', 'can_edit')) {
            access_denied();
        }
    
$data_image[] = array( );
    $uploaddir='./images/';
    $img_name='';
    if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
       die("Error creating folder $uploaddir");
               }
   if (isset($_FILES["image_primary"]) && !empty($_FILES['image_primary']['name'])) {
       $fileInfo = pathinfo($_FILES["image_primary"]["name"]);
       $img_name =gmdate("d-m-y-H-i-s", time()+3600*7) . 'primary.' . $fileInfo['extension'];
       move_uploaded_file($_FILES["image_primary"]["tmp_name"], "./images/" . $img_name);
       $data_image[] = array(
                'image' =>  $img_name,
                'type' =>  'primary',
                'offer_id' =>  'primary',
                 );
   } 
    if (isset($_FILES["OTHER_IMAGE"]) && !empty($_FILES['OTHER_IMAGE']['name'][0])) {
      // var_dump($_FILES["OTHER_IMAGE"]);
      for ($image=0; $image < count($_FILES["OTHER_IMAGE"]['name']) ; $image++) { 
         $fileInfo = pathinfo($_FILES['OTHER_IMAGE']["name"][$image]);
       $img_name =gmdate("d-m-y-H-i-s", time()+3600*7).$image . '.' . $fileInfo['extension'];
       move_uploaded_file($_FILES['OTHER_IMAGE']["tmp_name"][$image], "./images/" . $img_name);
                 $data_image[] = array(
                'image' =>  $img_name,
                'type' =>  '',
                'offer_id' =>  '',
                 );
               }  
      }
   //   foreach ($_FILES['OTHER_IMAGE'] as $key => $value) {
   //    var_dump($key);
       
    
     
   // }
   // die();

     $this->form_validation->set_rules('name',  $this->lang->line('name_offers'), 'trim|required|xss_clean');
     $this->form_validation->set_rules('description',  $this->lang->line('description'), 'trim|required|xss_clean');
     $this->form_validation->set_rules('order',  $this->lang->line('order'), 'trim|required|xss_clean|numeric');
    if ($this->form_validation->run() == FALSE) {
            $data = array(
                'name' => form_error('name'), 
                'is_active' => form_error('is_active'), 
                'description' => form_error('description'), 
                'order' => form_error('order'),
                'image_primary' => $this->upload->display_errors(),
                'image' => $this->upload->display_errors(),
            );
            $array = array('status' => 'fail', 'message' => $data);
             echo json_encode( $array );
        } else {  
           
            if ($this->input->post('id')!=null) {
               $data = array(
                'id' => $this->input->post('id'),
                'name' => $this->input->post('name'),
                'is_active' => $this->input->post('is_active'),
                'description' => $this->input->post('description'),
                'order' => $this->input->post('order'),
            );

             
            }
          else{
              $data = array(
                'name' => $this->input->post('name'),
                'is_active' => $this->input->post('is_active'),
                'description' => $this->input->post('description'),
                'order' => $this->input->post('order'),
            );
          }

            if(!empty($this->offers_model->add($data,$data_image))){
                 if ($this->input->post('id')!=null) {
               $array = array('status' => 'success', 'message' => 'تم عملية التعديل بنجاح');
                 }
                 else{
                    
               $array = array('status' => 'success', 'message' => 'تم الاضافة بنجاح<');
                 }
             echo json_encode( $array );
            }else{
                  if ($this->input->post('id')!=null) {
            $array = array('status' => 'fail1', 'message' => 'لم تتم عملية التعديل بنجا');
                  }else{

            $array = array('status' => 'fail1', 'message' => 'لم تتم عملية الاضافة بنجاح');
                  }
             echo json_encode( $array );
                }
}




}


function get_offers(){
    $id = $this->input->get('id');
    $offers =  $this->offers_model->get($id);
    echo json_encode($offers);
}

function delete(){
    $id = $this->input->get('id');
    if ($id) {
        if ($this->offers_model->remove($id)) {
            $array = array('status' => 'success', 'message' => 'تم عملية الحذف بنجاح');
        }
        else{
            $array = array('status' => 'fail', 'message' => 'لم تتم عملية الحذف ');
        }
     
    }
    else{
            $array = array('status' => 'fail', 'message' => 'خطا في البيانات المرسلة الرجاء المحاولة مرة اخرى');

    }
    echo json_encode($array);
}




}

?>
