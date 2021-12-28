<?php
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;

    $app = new \Slim\App;
    
    //GET
    $app->get('/api/clientes',function(Request $request, Response $response){
       try{
            $conn = new Conexion();
            $conn = $conn->connection();
            $sql = $conn->query("SELECT * FROM clientes");            
            $sql->execute();

            if(  $sql->rowCount() > 0  ){
                $clientes = $sql->fetchAll(PDO::FETCH_OBJ);
                echo json_encode($clientes);
            }else{
                echo json_encode("No existen clientes en la base de datos");
            }
       }catch (PDOException $e){
         echo json_encode("Error: $e->getMessage()");
       }finally{
        $sql = NULL;
        $conn = NULL;
       }
    });

    //GET {id}
    $app->get('/api/clientes/{id}',function(Request $request, Response $response){
        $id = $request->getAttribute('id');
        
        try{
            $conn = new Conexion();
            $conn = $conn->connection();
            $sql = $conn->prepare("SELECT * FROM clientes WHERE id = ?");            
            $sql->execute(array($id));

            if(  $sql->rowCount() > 0  ){
                $clientes = $sql->fetchAll(PDO::FETCH_OBJ);
                echo json_encode($clientes);
            }else{
                echo json_encode("El cliente con el id $id no existe en la base de datos");
            }

        }catch (PDOException $e){
          echo json_encode($e->getMessage());
        }finally{
            $sql = NULL;
            $conn = NULL;
        }
    });

    //POST
    $app->post('/api/clientes/nuevo',function(Request $request, Response $response){

        $nombres = $request->getParam('nombres');
        $apellidos = $request->getParam('apellidos');
        $telefono = $request->getParam('telefono');
        $email = $request->getParam('email');
        $ciudad = $request->getParam('ciudad');
        $direccion = $request->getParam('direccion'); 
       
        try{
            $conn = new Conexion();
            $conn = $conn->connection();
            $sql = $conn->prepare("INSERT INTO clientes(nombres,apellidos,telefono,email,ciudad,direccion) VALUES(?,?,?,?,?,?)");
            $sql->execute(array($nombres,$apellidos,$telefono,$email,$ciudad,$direccion));
            
            if(  $sql->rowCount() > 0  ){
                echo json_encode("Nuevo cliente creado");
            }else{
                echo json_encode("Error al crear el nuevo cliente");
            }
 
        }catch (PDOException $e){
            echo json_encode($e->getMessage());
        }finally{
            $sql = NULL;
            $conn = NULL;
        }
    });

    //UPDATE {id}
    $app->put('/api/clientes/modificar/{id}',function(Request $request, Response $response){
        $id = $request->getAttribute('id');
        $nombres = $request->getParam('nombres');
        $apellidos = $request->getParam('apellidos');
        $telefono = $request->getParam('telefono');
        $email = $request->getParam('email');
        $ciudad = $request->getParam('ciudad');
        $direccion = $request->getParam('direccion'); 
       
        try{
            $conn = new Conexion();
            $conn = $conn->connection();
            $sql = $conn->prepare("UPDATE clientes SET nombres=?,apellidos=?,telefono=?,email=?,ciudad=?,direccion=? WHERE id=?");
            $sql->execute(array($nombres,$apellidos,$telefono,$email,$ciudad,$direccion,$id));

            if(  $sql->rowCount() > 0  ){                
                echo json_encode("El cliente $id ha sido actualizado");
            }else{
                echo json_encode("El cliente con el id $id no existe en la base de datos");
            }
 
        }catch (PDOException $e){
            echo json_encode($e->getMessage());
        }finally{
            $sql = NULL;
            $conn = NULL;
        }
    });

    //DELETE {id}
    $app->delete('/api/clientes/eliminar/{id}',function(Request $request, Response $response){
        $id = $request->getAttribute('id');
              
        try{
            $conn = new Conexion();
            $conn = $conn->connection();
            $sql = $conn->prepare("DELETE FROM clientes WHERE id=?");
            $sql->execute(array($id));

            if(  $sql->rowCount() > 0  ){                
                echo json_encode("El cliente $id ha sido eliminado");
            }else{
                echo json_encode("El cliente con el id $id no existe en la base de datos");
            }
            
        }catch (PDOException $e){
            echo json_encode($e->getMessage());
        }finally{
            $sql = NULL;
            $conn = NULL;
        }
    });
?>