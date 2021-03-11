<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Http\Exception\NotFoundException;
use \Imagick;

/**
 * Rooms Controller
 *
 * @property \App\Model\Table\RoomsTable $Rooms
 *
 * @method \App\Model\Entity\Room[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TestsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {

        $pdf = WWW_ROOT."1.pdf";
        $info = pathinfo($pdf);
        $file_name =  basename($pdf,'.'.$info['extension']);
        echo $file_name;
        $pdf = "1.pdf[0]";
        exec("convert ".WWW_ROOT.$pdf." ".WWW_ROOT.$file_name.".jpg");  

        $this->autoRender = false; 
        //echo 'image-0.jpg';
        

        /*$response = $this->response->withType('application/json')
          ->withStringBody(json_encode($res));
        return  $response;*/
    }

    
}
