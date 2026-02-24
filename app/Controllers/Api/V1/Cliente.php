<?php
namespace App\Controllers\Api\V1;

use App\Controllers\BaseController;
use OpenApi\Attributes as OAT;
use CodeIgniter\API\ResponseTrait;

class Cliente extends BaseController
{
    use ResponseTrait;

    #[OAT\Get(path: '/api/v1/cliente/{id}', summary:"Lista o cliente de acordo com o ID informado", tags:["Cliente"])]
    #[OAT\Parameter(name:"id", in:"path", required:true, description:"ID do Usuário")]
    #[OAT\Response(response: '200', description: 'Exemplo consulta cliente por ID')]
    public function index($id)
    {
        $query = $this->db->table('cliente')->select('*')->where('id', $id)->get();
        $client = $query->getRowArray();
        
        if( !isset($client) )
            return $this->failNotFound('Cliente não encontrado');

        return $this->respond([
            'status' => 'success',
            'messages' => 'Cliente encontrado com sucesso!',
            'data'   => $client
        ], 200);
    }

    #[OAT\Post(path: '/api/v1/cliente/{id}', summary:"Insere um cliente novo", tags:["Cliente"])]
    #[OAT\Response(response: '200', description: 'Exemplo inserir e editar cliente')]
    public function add($data): string
    {
        $query   = $this->db->query('SELECT * FROM cliente');
        $results = $query->getResultArray();
        var_dump($results);
        die;
        return view('welcome_message');
    }

}
