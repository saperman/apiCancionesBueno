<?php 
class Controller_Lists extends Controller_Rest
{
    public function post_create()
    {
            try {
                if ( ! isset($_POST['name'])) 
                {
                    $json = $this->response(array(
                        'code' => 400,
                        'message' => 'parametro incorrecto'
                    ));
                    return $json;
                }
                
                $input = $_POST;
                $name = $input['name'];
                $userId = $input['userId'];
                $list = new Model_Lists();
                $list->title = $name;
                $list->user = Model_Users::find($userId);
                $list->save();
                $json = $this->response(array(
                    'code' => 201,
                    'message' => 'lista creada',
                ));
                return $json;
            } 
            catch (Exception $e) 
            {
                $json = $this->response(array(
                    'code' => 500,
                    'message' => 'error interno del servidor',
                ));
                return $json;
            }
        
    }
    public function post_delete()
    {   
        $input = $_POST;   
        
            if ( ! isset($_POST['id'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'paramentro no encontrado'
                ));
                return $json;
            }
            $list = Model_Lists::find($_POST['id']);
            if(!empty($list))
            {
                $listName = $list->title;
                $list->delete();
                $json = $this->response(array(
                'code' => 200,
                'message' => 'lista borrada',
                'name' => $listName,
            }else{
                $json = $this->response(array(
                'code' => 400,
                'message' => 'lista no encontrada',
                ));
            }
            return $json;
    }
    
   
}