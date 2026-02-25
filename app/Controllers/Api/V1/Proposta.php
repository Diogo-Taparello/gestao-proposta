<?php
namespace App\Controllers\Api\V1;

use App\Controllers\BaseController;
use OpenApi\Attributes as OAT;
use CodeIgniter\API\ResponseTrait;

class Proposta extends BaseController
{
    use ResponseTrait;

    #[OAT\Get(path: '/api/v1/proposta/{id}', summary:"Lista a proposta de acordo com o ID informado", tags:["Proposta"])]
    #[OAT\Parameter(name:"id", in:"path", required:true, description:"ID da Proposta")]
    #[OAT\Response(response: '200', description: 'Exemplo consulta proposta por ID')]
    public function index($id)
    {
        $query = $this->db->table('proposta')->select('*')->where('id', $id)->get();
        $proposta = $query->getRowArray();
        
        if( !isset($proposta) )
            return $this->failNotFound('Proposta não encontrada');

        return $this->respond([
            'status' => 'success',
            'messages' => 'Proposta encontrada com sucesso!',
            'data'   => $proposta
        ], 200);
    }

    #[OAT\Get(path: '/api/v1/proposta/', summary:"Lista de propostas com paginação", tags:["Proposta"])]
    #[OAT\Parameter(
        name:"page", 
        in:"query", 
        schema: new OAT\Schema(
            type: "integer",
            minimum: "1", 
            default: "1", 
        ), 
        description:"Número da página")
    ]
    #[OAT\Parameter(
        name:"limit", 
        in:"query", 
        schema: new OAT\Schema(
            type: "integer",
            minimum: "1", 
            maximum: "50", 
            default: "20"
        ), 
        description:"Número de registros por página")
    ]
    #[OAT\Parameter(name:"titulo", in:"query", schema: new OAT\Schema(type: "string"), description:"Título do produto", example: 'Teste')]
    #[OAT\Parameter(name:"status", in:"query", schema: new OAT\Schema(type: "string", enum: ['DRAFT','SUBMITTED','APPROVED','REJECTED','CANCELED'] ), description:"Status do produto", example:'APPROVED')]
    #[OAT\Parameter(name:"origem", in:"query", schema: new OAT\Schema(type: "string", enum: ['APP', 'SITE', 'API'] ), description:"Origem do produto", example:'API')]
    #[OAT\Response(response: '200', description: 'Exemplo consulta cliente por ID')]
    public function all()
    {
        $data = $this->request->getGet();
        $query = $this->db->table('proposta')->select('*');
        
        if( isset($data['titulo']) && $data['titulo'] != '')
            $query->like('produto', $data['titulo'], 'both');

        if( isset($data['status']) && $data['status'] != '')
            $query->where('status', $data['status']);

        if( isset($data['origem']) && $data['origem'] != '')
            $query->where('origem', $data['origem']);

        $limit = 20;
        if( isset($data['limit']) && $data['limit'] != '')
            $limit = $data['limit'];

        $page = 0 * $limit;
        if( isset($data['page']) && $data['page'] != '')
            $page = $limit * ($data['page'] - 1);

        $query->limit($limit, $page);

        $query = $query->get();
        $proposta = $query->getresultArray();
        
        if( !isset($proposta) || empty($proposta) )
            return $this->failNotFound('Nenhuma proposta encontrada!');

        return $this->respond([
            'status' => 'success',
            'messages' => 'Propostas encontradas com sucesso!',
            'data'   => $proposta
        ], 200);
    }

    #[OAT\Post(path: '/api/v1/proposta', summary:"Insere uma proposta nova", tags:["Proposta"])]
    #[OAT\RequestBody(
        description:"Objeto do cadastro", 
        required: true,
        content: new OAT\MediaType(
            mediaType: 'multipart/form-data',
            schema: new OAT\Schema(
                type: 'object',
                required: ['cliente_id', 'produto', 'valor_mensal', 'origem'],
                properties: [
                    new OAT\Property(property: 'cliente_id', type: 'integer', example: 1),
                    new OAT\Property(property: 'produto', type: 'string', example:"Produto de Teste 2"),
                    new OAT\Property(property: 'valor_mensal', type: 'decimal', example:"16.90"),
                    new OAT\Property(property: 'origem', type: 'string', enum: ['APP', 'SITE', 'API'], example:"SITE"),
                    new OAT\Property(property: 'versao', type: 'integer', example:"1"),
                ],
            )
        )
    )]
    #[OAT\Response(response: '200', description: 'Exemplo inserir proposta')]
    public function add()
    {
        $data = $this->request->getPost();
        $data['status'] = 'DRAFT';

        $this->db->table('proposta')->insert($data);
        $insertId = $this->db->insertID();

        if( !isset($insertId) || !$insertId )
            return $this->failNotFound('Erro ao cadastrar nova proposta');

        $this->db->table('auditoria')->insert(array('proposta_id' => $insertId, 'actor' => 'user:1', 'evento' => 'CREATED', 'payload' => json_encode($data)));

        return $this->respond([
            'status' => 'success',
            'messages' => 'Proposta cadastrada com sucesso!',
            'data'   => ['id_proposta' => $insertId]
        ], 200);
    }

    #[OAT\Post(path: '/api/v1/proposta/{id}/submit', summary:"Altera status da proposta para submited", tags:["Proposta"])]
    #[OAT\Post(path: '/api/v1/proposta/{id}/approve', summary:"Altera status da proposta para approved", tags:["Proposta"])]
    #[OAT\Post(path: '/api/v1/proposta/{id}/reject', summary:"Altera status da proposta para rejected", tags:["Proposta"])]
    #[OAT\Post(path: '/api/v1/proposta/{id}/cancel', summary:"Altera status da proposta para canceled", tags:["Proposta"])]
    #[OAT\Parameter(name:"id", in:"path", required:true, description:"ID da Proposta")]
    #[OAT\Response(response: '200', description: 'Exemplo inserir proposta')]
    public function change_status($id, $new_status)
    {
        $query = $this->db->table('proposta')->select('status')->where('id', $id)->get();
        $proposta = $query->getRowArray();

        if($proposta['status'] == 'DRAFT' && $new_status != 'SUBMITTED'){
            return $this->failNotFound('Proposta com status '.$proposta['status'].' não pode ser alterada para '.$new_status);
        } 
        if($proposta['status'] == 'SUBMITTED' && !in_array($new_status, array('REJECTED', 'APPROVED'))){
            return $this->failNotFound('Proposta com status '.$proposta['status'].' não pode ser alterada para '.$new_status);
        }
        if($proposta['status'] == 'APPROVED' && $new_status != 'CANCELED'){
            return $this->failNotFound('Proposta com status '.$proposta['status'].' não pode ser alterada para '.$new_status);
        } 
        if($proposta['status'] == 'REJECTED' || $proposta['status'] == 'CANCELED'){
            return $this->failNotFound('O status da proposta não pode mais ser alterado');
        }

        $this->db->table('proposta')->where('id', $id)->update(array('status' => $new_status));
        
        $this->db->table('auditoria')->insert(array('proposta_id' => $id, 'actor' => 'user:1', 'evento' => 'STATUS_CHANGED', 'payload' => json_encode(array('status' => $proposta['status'], 'new_status' => $new_status))));

        return $this->respond([
            'status' => 'success',
            'messages' => 'Status da Proposta alterado com sucesso!',
            'data'   => ['id_proposta' => $id, 'status' => $new_status]
        ], 200);
    }

    #[OAT\Get(path: '/api/v1/proposta/{id}/auditoria', summary:"Lista de auditorias de acordo com o ID da proposta", tags:["Auditoria"])]
    #[OAT\Parameter(name:"id", in:"path", required:true, description:"ID da Proposta")]
    #[OAT\Response(response: '200', description: 'Exemplo consulta auditorias por ID da Proposta')]
    public function auditoria($id)
    {
        $query = $this->db->table('auditoria')->select('*')->where('proposta_id', $id)->get();
        $auditorias = $query->getResultArray();
        
        if( !isset($auditorias) )
            return $this->failNotFound('Erro ao consultar auditorias');

        if( empty($auditorias) )
            return $this->failNotFound('Proposta não possui auditoria');

        return $this->respond([
            'status' => 'success',
            'messages' => 'Auditorias da proposta encontradas com sucesso!',
            'data'   => $auditorias
        ], 200);
    }
}
