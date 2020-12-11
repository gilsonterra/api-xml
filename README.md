# Import XMl API

## Comandos para iniciar o projeto

1 - Instalar o composer

```shell
composer install
```

2 - Inicializar a docker

```shell
./vendor/bin/sail up
```

3 - Executar as migrations

```shell
docker exec -it gilson_test_app sh -c 'php artisan migrate'
```

4 - Ligar a fila de jobs (para importação assincrona)

```shell
docker exec -it gilson_test_app sh -c 'php artisan queue:work --queue=high,default'
```

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
