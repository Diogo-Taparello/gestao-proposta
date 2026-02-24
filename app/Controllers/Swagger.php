<?php 
namespace App\Controllers;


class Swagger extends BaseController
{
    /**
     * Generate OpenAPI documentation for the API ...
     * @return string
     */
    public function generate(): string
    {
        $openapi = (new \OpenApi\Generator)->generate([APPPATH . 'Controllers']);
        $swaggerContent = $openapi->toJson();
        $filePath = FCPATH . 'swagger_ui/swagger.json';
        file_put_contents($filePath, $swaggerContent);

        return $swaggerContent;
    }

    /**
     * Render the SwaggerUI ...
     * @return string
     */
    public function index()
    {
        return view('swagger/index');
    }
}