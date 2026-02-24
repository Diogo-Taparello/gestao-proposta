# PROJETO GESTÃO DE PROPOSTAS

## Requirements

    APACHE 2.4+
    PHP version 8.2+
    PHPMYADMIN 5.2+
    COMPOSER INSTALLED

# Configure
    1. Composer i
    
## Database

    1.Criar banco de dados com o nome: "gestao_propostas" 
        1.1 php spark migrate  
        1.2 php spark db:seed MainSeeder

## Start Project

    2. php spark serve
        2.1 Link para atualizar o Swagger: http://localhost:8080/api/v1/docs/generate
        2.2 Link para acessar o Swagger http://localhost:8080/api/v1/docs/ui/
