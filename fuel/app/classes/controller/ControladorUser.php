<?php
use \Model\Users;
use Firebase\JWT\JWT;
class Controller_ControladorUser extends Controller_Rest
{
    private static $secret_key = 'kikeceano';
    private static $encrypt = ['HS256'];
    private static $aud = null;

    public function post_create()
    {
        try {
            
            if ( !isset($_POST['userName'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita que el parametro se llame name'
                ));
                return $json;
            }
            $input = $_POST;
            $user = new Model_Users();
            $user->userName = $input['userName'];
            $user->password = $input['password'];
            $user->save();

            $json = $this->response(array(
                'code' => 200,
                'message' => 'usuario creado',
                'name' => $input['userName']
            ));
            return $json;
        } 

        catch (Exception $e) 
        {
            $json = $this->response(array(
                'code' => 500,
                'message' => 'error interno del servidor'
            ));
            return $json;
        }      
    }

    public function get_users()
    {
        $headers = apache_request_headers();
        $auth = json_decode($this->authenticate($headers), true);
        if($auth['bool']){
            $users = Model_Users::find('all');

            return $this->response(
                array(
                    'code' => 200,
                    'message' => 'correcto auth',
                    'data' => $users
                )
            );
        }else{
            return $this->response(
                array(
                    'code' => 401,
                    'message' => 'incorrecto auth'
                )
            );
        }
    	

    }

    public function post_delete()
    {
        $user = Model_Users::find($_POST['id']);
        $userName = $user->userName;
        $user->delete();

        $json = $this->response(array(
            'code' => 200,
            'message' => 'usuario borrado',
            'name' => $userName
        ));
        return $json;
    }

    public function post_login()
    {
        if ( !isset($_POST['userName']) || !isset($_POST['password'])) {
            $json = $this->response(array(
                    'code' => 400,
                    'message' => 'alguno de los datos esta vacio'
                ));
                return $json;
        }else{
            $input = $_POST;
            $user = Model_Users::find('all', array('where' => array(array('userName', '=', $input['userName']), array('password', '=', $input['password']))));
            if($user != null)
            {
                $time = time();
                $token = array(
                    'exp' => $time + (60*60),
                    'userName' =>  $input['userName'],
                    'password' =>  $input['password']
                );

                $token = JWT::encode($token, self::$secret_key);
                $json = $this->response(array(
                    'code' => 200,
                    'message' => 'Log In correcto',
                    'data' => $token
                    ));
                $_POST['loggedUser'] = $user;
                return $json;
            }else{
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'usuario no encontrado'
                ));
                return $json;
            }
        }
    }
    
    private function authenticate($headersRequest){
        $headers = $headersRequest;
        if(isset($headers['Authorization']) )
        {
            $token = $headers['Authorization'];
            if($decode = JWT::decode($token, self::$secret_key, array('HS256')))
            {
                 $decode_array = (array) $decode;
                var_dump($decode_array['userName']);
                $json = $this->response(array(
                        'code' => 200,
                        'message' => 'autenticacion correcta',
                        'bool' => true
                    ));
                return $json;
            }else{
                $json = $this->response(array(
                    'code' => 401,
                    'message' => 'autenticacion incorrecta',
                    'bool' => false,
                    'data' => $decode
                ));
                return $json;
            }
         }
    else{
        $json = $this->response(array(
            'code' => 403,
            'bool' => false,
            'message' => 'token inexsitente'
        ));
        return $json;
        }
    }
}
