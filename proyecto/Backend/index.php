<?php
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Factory\AppFactory;
    use Slim\Psr7\Response as SlimResponse;
    
    require_once __DIR__ . '/../vendor/autoload.php';

    use myapi\Create\Create;
    use myapi\Read\Read;
    use myapi\Delete\Delete;
    use myapi\Update\Update;

    $app = AppFactory::create();
    $app->setBasepath("/Proyecto-TecWeb/proyecto/Backend");

    // Obtener un insecto específico por ID
    $app->get('/insects/{id:[0-9]+}', function (Request $request, Response $response, $args) {
        $read = new Read('bugweb'); 
        $read->single($args['id']);
        $data = $read->getData();
        $response->getBody()->write(json_encode($data ?: '{}'));
        return $response->withHeader('Content-Type', 'application/json');
    });

    // Listar todos los insectos
    $app->get('/insects', function ($request, $response, $args) {
        $read = new Read('bugweb');
        $read->list();
        $response->getBody()->write(json_encode($read->getData()));
        return $response->withHeader('Content-Type', 'application/json');
    });

    // Buscar insectos por término
    $app->get('/insects/{search}', function (Request $request, Response $response, $args) {
        $read = new Read('bugweb');
        $read->search($args['search']);
        $response->getBody()->write(json_encode($read->getData()));
        return $response->withHeader('Content-Type', 'application/json');
    });

    // Crear un nuevo insecto
    $app->post('/insects', function (Request $request, Response $response) {
        $body = json_decode($request->getBody(), true);
        
        if (!$body) {
            $response->getBody()->write(json_encode(['error' => 'JSON inválido']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
        
        // Validar campos requeridos
        $requiredFields = ['nombre', 'familia', 'nombre_c', 'estado', 'descripcion', 'habitad', 'alimentacion', 'longevidad'];
        foreach ($requiredFields as $field) {
            if (!isset($body[$field])) {
                $response->getBody()->write(json_encode(['error' => "Campo $field es requerido"]));
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }
        }
        
        $create = new Create('bugweb');
        $create->add($body);
        
        $response->getBody()->write(json_encode($create->getData()));
        return $response->withHeader('Content-Type', 'application/json');
    });

    // Actualizar un insecto existente
    $app->put('/insects', function (Request $request, Response $response) {
        $json = $request->getBody()->getContents();
        $data = json_decode($json, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            $response->getBody()->write(json_encode([
                'status' => 'error',
                'message' => 'JSON inválido'
            ]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
        
        if (!isset($data['id'])) {
            $response->getBody()->write(json_encode([
                'status' => 'error',
                'message' => 'Se requiere el ID del insecto'
            ]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
        
        $id = $data['id'];
        unset($data['id']);
        
        $update = new Update('bugweb');
        $update->edit($id, $data);
        
        $response->getBody()->write(json_encode($update->getData()));
        return $response->withHeader('Content-Type', 'application/json');
    });

    // Eliminar un insecto
    $app->delete('/insects', function (Request $request, Response $response) {
        $body = $request->getBody()->getContents();
        $data = json_decode($body, true);
        $id = $data['id'] ?? null;
        
        if (!$id) {
            $response->getBody()->write(json_encode([
                'status' => 'error',
                'message' => 'Se requiere el ID del insecto'
            ]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
        
        $delete = new Delete('bugweb');
        $delete->delete($id);
        
        $response->getBody()->write(json_encode($delete->getData()));
        return $response->withHeader('Content-Type', 'application/json');
    });

    // Obtener un libro específico por ID
    $app->get('/books/{id:[0-9]+}', function (Request $request, Response $response, $args) {
        $read = new Read('bugweb'); 
        $read->singleLibro($args['id']);
        $data = $read->getData();

        // Si devuelve un solo objeto, lo convertimos en array
        if ($data && isset($data['id'])) {
            $data = [$data];
        }

        $response->getBody()->write(json_encode($data ?: []));
        return $response->withHeader('Content-Type', 'application/json');
    });


    // Listar todos los libros
    $app->get('/books', function ($request, $response, $args) {
        $read = new Read('bugweb');
        $read->listLibro();
        $response->getBody()->write(json_encode($read->getData()));
        return $response->withHeader('Content-Type', 'application/json');
    });

    // Buscar libros por término
    $app->get('/books/{search}', function (Request $request, Response $response, $args) {
        $read = new Read('bugweb');
        $read->searchLibro($args['search']);
        $response->getBody()->write(json_encode($read->getData()));
        return $response->withHeader('Content-Type', 'application/json');
    });
    // Crear un nuevo libro
    $app->post('/books', function (Request $request, Response $response) {
        $body = json_decode($request->getBody(), true);
        
        if (!$body) {
            $response->getBody()->write(json_encode(['error' => 'JSON inválido']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
        
        // Validar campos requeridos
        $requiredFields = ['nombre', 'link'];
        foreach ($requiredFields as $field) {
            if (!isset($body[$field])) {
                $response->getBody()->write(json_encode(['error' => "Campo $field es requerido"]));
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }
        }
        
        $create = new Create('bugweb');
        $create->addLibro($body);
        
        $response->getBody()->write(json_encode($create->getData()));
        return $response->withHeader('Content-Type', 'application/json');
    });

    // Actualizar un libro existente
    $app->put('/books', function (Request $request, Response $response) {
        $json = $request->getBody()->getContents();
        $data = json_decode($json, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            $response->getBody()->write(json_encode([
                'status' => 'error',
                'message' => 'JSON inválido'
            ]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
        
        if (!isset($data['id'])) {
            return $response->withJson([
                'status' => 'error',
                'message' => 'Se requiere el ID del insecto'
            ], 400);
        }
        
        $id = $data['id'];
        unset($data['id']);
        
        $update = new Update('bugweb');
        $update->editLibro($id, $data);
        
        $response->getBody()->write(json_encode($update->getData()));
        return $response->withHeader('Content-Type', 'application/json');
    });

    // Eliminar un libro
    $app->delete('/books', function (Request $request, Response $response) {
        $body = $request->getBody()->getContents();
        $data = json_decode($body, true);
        $id = $data['id'] ?? null;
        
        if (!$id) {
            $response->getBody()->write(json_encode([
                'status' => 'error',
                'message' => 'Se requiere el ID del insecto'
            ]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
        
        $delete = new Delete('bugweb');
        $delete->deleteLibro($id);
        
        $response->getBody()->write(json_encode($delete->getData()));
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->get('/latest-books', function ($request, $response, $args) {
        $read = new Read('bugweb');
        $read->latestLibros();
        $response->getBody()->write(json_encode($read->getData()));
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->get('/latest-insects', function ($request, $response, $args) {
        $read = new Read('bugweb');
        $read->latestInsectos();
        $response->getBody()->write(json_encode($read->getData()));
        return $response->withHeader('Content-Type', 'application/json');
    });


    $app->run();
?>