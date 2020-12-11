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
