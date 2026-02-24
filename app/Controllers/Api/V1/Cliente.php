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

    #[OAT\Post(path: '/api/v1/cliente', summary:"Insere um cliente novo", tags:["Cliente"])]
    #[OAT\RequestBody(
        description:"Objeto do cadastro", 
        required: true,
        content: new OAT\MediaType(
            mediaType: 'multipart/form-data',
            schema: new OAT\Schema(
                type: 'object',
                required: ['nome', 'email', 'document'],
                properties: [
                    new OAT\Property(property: 'nome', type: 'string', example:"Henrique"),
                    new OAT\Property(property: 'email', type: 'string', example:"henrique@gmail.com", format:"email"),
                    new OAT\Property(property: 'document', type: 'string', example:"000.000.000-99")
                ],
            )
        )
    )]
    #[OAT\Response(response: '200', description: 'Exemplo inserir cliente')]
    public function add()
    {
        $data = $this->request->getPost();
        $data['document'] = preg_replace('/[^0-9]/', '', $data['document']);

        $builder = $this->db->table('cliente');
        $builder->insert($data);
        $insertId = $this->db->insertID();
        
        if( !isset($insertId) || !$insertId )
            return $this->failNotFound('Cliente não encontrado');

        return $this->respond([
            'status' => 'success',
            'messages' => 'Cliente cadastrado com sucesso!',
            'data'   => ['client_id' => $insertId]
        ], 200);
    }

}
