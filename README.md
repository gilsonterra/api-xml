# Import XMl API

## Apresentação

Esse projeto foi desenvolvido utilizando Laravel 8 e Docker. Foi desenvolvido os seguintes recursos:

- Docker para rodar ambiente;
- MySql para banco de dados;
- Frontend para upload de arquivos XML;
- Backend utilizando padrões de projeto como Facade e Adpater;
- Job e Queue para que o upload do arquivos seja assíncrono;
- API para mostrar os resultados importados;
- Autentição nos endpoints People e Shiporders
- Documentação da API utilizando Swagger 3;
- Autenticação da API usando Laravel Sanctum. Dados de authenticação abaixo:

```txt
email: test@test.com
password: 123
```

## Comandos para iniciar o projeto

1 - Instalar o composer

```shell
composer install
```

2 - Inicializar a docker

*Nota: antes de inicializar a docker, você pode configurar as variáveis de ambiente no arquivo **.env***

```shell
./vendor/bin/sail up
```

3 - Executar comando com as configurações iniciais (migrations, test e queue)

```shell
docker exec -it gilson_test_app sh -c 'php artisan app:configuration'
```

4 - Agora você poderá acessar a aplicaão pelo endereço

[http://localhost:8083](http://localhost:8083) *ou em outra porta configurada no .env*

## Comando para rodar os testes

```shell
docker exec -it gilson_test_app sh -c 'php artisan test'
```

## Comando para atualizar a documentação do swagger

```shell
docker exec -it gilson_test_app sh -c 'php artisan l5-swagger:generate'
```

## Algumas imagens do sistema em funcionamento

![Import Person](docs/import_person.gif)

![Import ShipOrder](docs/import_shiporder.gif)

![Swagger](docs/swagger.gif)

![Import Person with error](docs/import_person_with_error.gif)
