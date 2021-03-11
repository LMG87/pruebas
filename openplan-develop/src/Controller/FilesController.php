<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Http\Exception\NotFoundException;

/**
 * Files Controller
 *
 * @property \App\Model\Table\FilesTable $Files
 *
 * @method \App\Model\Entity\File[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FilesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Items']
        ];
        $files = $this->paginate($this->Files);

        $this->set(compact('files'));
    }

    /**
     * View method
     *
     * @param string|null $id File id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $file = $this->Files->get($id, [
            'contain' => ['Users', 'Items']
        ]);

        $this->set('file', $file);
    }

    public function download($filename) {
        $this->autoRender = false;
        // Retrieve the file ready for download
        $file = $this->Files->findByFilename($filename)->first();
        if (empty($file)) {
            throw new NotFoundException('error: 404');
        }
        $path='uploads/files/'.$file->filename;
        $this->response->file(
            $path,
            array(
                'download' => true,
                'name' => $file->name
            )
        );
        return $this->response;
    }

    private function convertToReadableSize($size){
      $base = log($size) / log(1024);
      $suffix = array(" bytes", " KB", " MB", " GB", " TB");
      $f_base = floor($base);
      return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
    }

    private function getExtension($filename) {
       // $path = $_FILES['image']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        return $ext;
    }

    private function getIcon($filename) { 
        switch($this->getExtension($filename)) {
            //if .jpg/.gif/.png do something
            case 'jpg': case 'gif': case 'png':
                $iconFile='fa-file-image-o';
                break;
            //if .zip/.rar do something else
            case 'zip': case 'rar':
                $iconFile='fa-file-zip-o';
                break;

            case 'txt':
                $iconFile='fa-file-text-o';
                break;

            case 'js': case 'php': case 'html': case 'css':  case 'htaccess':  case 'json':  case 'phar':  case 'scss':  case 'ctp':
                $iconFile='fa-file-code-o';
                break;

            case 'xlsx': case 'xlsm': case 'xlsb': case 'xltx': case 'xltm': case 'xls': case 'xlt': case 'xml': case 'xlam': case 'xla': case 'xlw': case 'csv': case 'ods':
                $iconFile='fa-file-excel-o';
                break;

            case 'pptx': case 'pptm': case 'ppt': case 'xps': case 'potx': case 'potm': case 'pot': case 'thmx': case 'ppsx': case 'ppsm': case 'pps': case 'ppam': case 'ppa': case 'odp':
                $iconFile='fa-file-powerpoint-o';
                break;

            case 'docx': case 'docm': case 'dotx': case 'dotm': case 'doc':
                $iconFile='fa-file-word-o';
                break;

            //if .pdf do something else
            case 'pdf':
                $iconFile='fa-file-pdf-o';
                break;

            default:
                $iconFile='fa-file-o';
            break;
        }
        return $iconFile;
    }

    //public function 
    public function addFiles($item_id=null, $files=null)
    {
        /*debug($this->request->data['file']);
        exit();*/
        $this->loadModel('Users');
        $this->autoRender = false;        
        if ($this->request->is('ajax') && $this->request->is('post') ){
            //$file = $this->Files->patchEntity($file, $this->request->getData());
            if (!$files){ $files=$this->request->data['file']; }
            //$files=$this->request->data['file'];
           // debug($item_id);
            if (is_array($files)){
                $attachments=array();
                foreach ($files as $attach) {
                    //debug($attach);
                    if(!empty($attach['name'])){
                        //debug($attach);
                        $size = $this->convertToReadableSize($attach['size']);
                        $fileName = $attach['name'];
                        $user_id=$this->UserAuth->getUserId();
                        if (!$item_id){ $item_id=$this->request->getData('item_id'); }
                        //$item_id=$this->request->getData('item_id');
                        $now = md5($user_id.$item_id.date("YmdH:i:s:u:v")."Jef".$fileName);
                        $ext = $this->getExtension($fileName);
                        //pathinfo($fileName, PATHINFO_EXTENSION);
                        //debug($now);
                        $filename = $now.".".$ext;
                        $uploadPath = 'uploads/files/';
                        $uploadFile = $uploadPath.$filename;
                        if(move_uploaded_file($attach['tmp_name'],$uploadFile)){
                            $uploadData = $this->Files->newEntity();
                            $uploadData->name = $fileName;
                            $uploadData->filename = $filename;
                            $uploadData->path = $uploadPath;
                            $uploadData->size = $size;
                            $uploadData->icon= $this->getIcon($filename);
                            $uploadData->user_id=$user_id;
                            $uploadData->item_id=$item_id;
                            $uploadData->created = date("Y-m-d H:i:s");
                            $uploadData->modified = date("Y-m-d H:i:s");
                            if ($file=$this->Files->save($uploadData)) {
                                //$file->total_files=$this->Comments->findAllByItemId($comment->item_id)->count();
                                $u = $this->Users->get($file->user_id);
                                $user= (object) array('first_name' => $u->first_name, 'last_name' => $u->last_name);
                                $file->user=$user;
                                $attachments[]=$file; 
                            }else{
                                throw new NotFoundException(__('Unable to upload file, please try again.1'));
                            }
                        }else{
                           throw new NotFoundException(__('Unable to upload file, please try again.2'));
                        }
                    }else{
                        throw new NotFoundException(__('Please choose a file to upload.3'));
                    }
                }
                $response = $this->response->withType('application/json');
                $response = $response->withStringBody(json_encode($attachments));
                return  $response;
            }else{
                throw new NotFoundException(__('Please choose a file to upload.4'));
            }
            //$this->Flash->error(__('The file could not be saved. Please, try again.'));
        }else{
            throw new NotFoundException(__('error: 404'));
        }
        /*$users = $this->Files->Users->find('list', ['limit' => 200]);
        $items = $this->Files->Items->find('list', ['limit' => 200]);
        $this->set(compact('file', 'users', 'items'));*/
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $file = $this->Files->newEntity();
        if ($this->request->is('post')) {
            $file = $this->Files->patchEntity($file, $this->request->getData());
            if ($this->Files->save($file)) {
                $this->Flash->success(__('The file has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The file could not be saved. Please, try again.'));
        }
        $users = $this->Files->Users->find('list', ['limit' => 200]);
        $items = $this->Files->Items->find('list', ['limit' => 200]);
        $this->set(compact('file', 'users', 'items'));
    }

    /**
     * Edit method
     *
     * @param string|null $id File id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $file = $this->Files->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $file = $this->Files->patchEntity($file, $this->request->getData());
            if ($this->Files->save($file)) {
                $this->Flash->success(__('The file has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The file could not be saved. Please, try again.'));
        }
        $users = $this->Files->Users->find('list', ['limit' => 200]);
        $items = $this->Files->Items->find('list', ['limit' => 200]);
        $this->set(compact('file', 'users', 'items'));
    }

    /**
     * Delete method
     *
     * @param string|null $id File id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $file = $this->Files->get($id);
        if ($this->Files->delete($file)) {
            $this->Flash->success(__('The file has been deleted.'));
        } else {
            $this->Flash->error(__('The file could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteFront($id = null)
    {
        $this->autoRender = false; 
        if ($this->request->is('ajax') && $this->request->is('post') ){
            $this->request->allowMethod(['post', 'delete']);
            $file = $this->Files->get($id);
            if ($del=$this->Files->delete($file)) {
                if(unlink(WWW_ROOT."/uploads/files/".$file->filename)){
                    $response = $this->response->withType('application/json');
                    $response = $response->withStringBody(json_encode($file));
                    return  $response;
                } 
            } else {
                throw new NotFoundException(__('error: 404'));
            }
        }else{
            throw new NotFoundException(__('error: 404'));
        }
    }
}
