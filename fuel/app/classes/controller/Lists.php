<?php 
class Controller_Lists extends Controller_Rest
{
    public function post_create()
    {
        $auth = self::authenticate();
        if($auth == true)
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
                $decodedToken = self::decodeToken();

                $list = new Model_Lists();
                $list->title = $name;
                $list->user = Model_Users::find($decodedToken->id);
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
        
    }
    public function post_delete()
    {   
        $input = $_POST;   
        $auth = self::authenticate();
        if($auth == true)
        {
            if ( ! isset($_POST['id'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita que el parametro se llame id'
                ));
                return $json;
            }
            $list = Model_Lists::find($_POST['id']);
            if(!empty($list))
            {
                $listName = $list->title;
                $list->delete();
            }
            $json = $this->response(array(
                'code' => 200,
                'message' => 'lista borrada',
                'name' => $listName,
            ));
            return $json;
        }
        else
        {
            $json = $this->response(array(
                    'code' => 401,
                    'message' => 'Usuarios no autenticado',
            ));
            return $json;
        }
    }
    public function post_update()
    {
        $input = $_POST;   
        $auth = self::authenticate();
        if($auth == true)
        {
            if ( ! isset($_POST['id']) && ! isset($_POST['name']) ) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametros incorrectos'
                ));
                return $json;
            }
            $id = $_POST['id'];
            $updateList = Model_Lists::find($id);
            $title = $_POST['name'];
            if(!empty($updateList))
            {


                $decodedToken = self::decodeToken();
                if($decodedToken->id == $updateList->id_user)
                {
                    $updateList->title = $title;
                    $updateList->save();
                    $json = $this->response(array(
                    'code' => 200,
                    'message' => 'lista actualizada',
                    ));
                }
                else
                {
                    $json = $this->response(array(
                        'code' => 401,
                        'message' => 'No estas autorizado a cambiar esa lista'
                    ));
                    return $json;
                }
            }
            else
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'lista no encontrada'
                ));
                return $json;
            }
        }
        else
        {
            $json = $this->response(array(
                    'code' => 401,
                    'message' => 'Usuario no autenticado',
            ));
            return $json;
        }
    }    
    public function get_private_lists()
    {   
        $auth = self::authenticate();
        if($auth == true)
        {
            $decodedToken = self::decodeToken();
            $lists = Model_Lists::find('all', 
                                 ['where' => 
                                 ['id_user' => $decodedToken->id]]);
            
            if($lists != null)
            {
                $indexedLists = Arr::reindex($lists);
                foreach ($indexedLists as $key => $list) {
                    $title[] = $list->title;
                    $id[] = $list->id;
                }
               $json = $this->response(array(
                    'code' => 200,
                    'message' => 'Listas privadas',
                    'title' => $title,
                )); 
            }         
            else
            {
               $json = $this->response(array(
                    'code' => 200,
                    'message' => 'Listas privadas vacias',
                ));  
            }
            return $json;
        }else{
            $json = $this->response(array(
                    'code' => 401,
                    'message' => 'Usuarios no autenticado',
            ));
            return $json;
        }
        
    }
}