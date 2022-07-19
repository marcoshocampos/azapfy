# Sobre o Projeto

Neste projeto foi desenvolvido uma API que faz o controles de pagamento por entregas realizadas. O mesmo foi desenvolvido em PHP com auxílio do framework Laravel em sua versão 9.19.0.

# Execução do Projeto

Após clonar o repositório ou fazer o download da pasta com o código-fonte, acesse a pasta *azapfy* através da linha de comando (terminal do Windows) e execute o comando **php artisan serve** (sem as aspas) para iniciar o servidor de desenvolvimento de aplicação Laravel. Mantenha o terminal aberto para que o servidor continue online.

Com o servidor em execução, acesse em seu navegador o localhost pela porta 8000 para visualizar os retornos da API desenvolvida. 

- http://localhost:8000/

A rota principal contém apenas os links para acessar as 5 tarefas propostas no projeto. As tarefas serão listadas e aprofundadas abaixo, junto com o consumo da API. 

**OBS:** Todos criados dentro do mesmo Controller.

## Consumir API Azapfy

A API consumida para a obtenção dos dados foi tratada na função *apiremetente*. A variável $api recebe a URL da API e é codificada no formato JSON com a função "json_decode", que a converte para uma variável PHP (armazenada no $apiArray).

Nesta mesma função, também é usado a estrutura de repetição FOREACH para percorrer a API e separar as informações que contenham o mesmo CNPJ de remetente, atribuindo-os ao objeto $remetentes. É usado um array_push para termos um array de objetos, de forma que, ou é criado um novo objeto ao identificar um novo CNPJ do remetente, ou é "concatenado" 

- http://homologacao3.azapfy.com.br/api/ps/notas

## Agrupar as notas por remetente.


## Calcular o valor total das notas para cada remetente.


## Calcular o valor que o remetente irá receber pelo que já foi entregue.


## Calcular o valor que o remetente irá receber pelo que ainda não foi entregue.


## Calcular quanto o remetente deixou de receber devido ao atraso na entrega.
