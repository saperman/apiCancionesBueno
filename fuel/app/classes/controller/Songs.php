<?php 
class Controller_Songs extends Controller_Rest
{
	public function post_create()
    {
            try {
                if ( ! isset($_POST['title']) && ! isset($_POST['url'])) 
                {
                    $json = $this->response(array(
                        'code' => 400,
                        'message' => 'parametro incorrecto'
                    ));
                    return $json;
                }
                
                
                $title = $P0ST['title'];
                $url = $P0ST['url'];
                $song = new Model_Songs();
                $song->title = $title;
                $song->url = $url;
                $song->save();
                $json = $this->response(array(
                    'code' => 201,
                    'message' => 'Canción creada',
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
    public function get_songs()
    {   
        try {
            $songs = Model_Songs::find('all');
	       $indexedSongs = Arr::reindex($songs);
                $json = $this->response(array(
                    'code' => 200,
                    'songs' => $indexedSongs
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
}