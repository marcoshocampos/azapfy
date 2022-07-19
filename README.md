# Sobre o Projeto

Neste projeto foi desenvolvido uma API que faz o controles de pagamento por entregas realizadas. O mesmo foi desenvolvido em PHP com auxílio do framework Laravel em sua versão 9.19.0.

# Execução do Projeto

Após clonar o repositório ou fazer o download da pasta com o código-fonte, acesse a pasta *azapfy* através da linha de comando (terminal do Windows) e execute o comando **php artisan serve** para iniciar o servidor de desenvolvimento de aplicação Laravel. Mantenha o terminal aberto para que o servidor continue online.

Com o servidor em execução, acesse em seu navegador o localhost pela porta 8000 para visualizar os retornos da API desenvolvida. 

- http://localhost:8000/

A rota principal contém apenas os links para acessar as 5 tarefas propostas no projeto. As tarefas serão listadas e aprofundadas abaixo, junto com o consumo da API. 

## Consumir API Azapfy

A API consumida para a obtenção dos dados foi tratada na função *apiremetente*. A variável $api recebe a URL da API e é codificada no formato JSON com a função *json_decode*, que a converte para uma variável PHP (armazenada no $apiArray).

- http://homologacao3.azapfy.com.br/api/ps/notas

## Agrupar as notas por remetente.

Ainda na função *apiremetente*, é usado a estrutura de repetição FOREACH para percorrer a API e separar as informações que contenham o mesmo CNPJ de remetente, atribuindo-os ao objeto $remetentes. É usado um *array_push* para termos um onjeto de arrays de objetos, de forma que, ou é adicionado uma posição no array ao identificar um novo CNPJ do remetente, ou é "concatenado" o novo objeto a mesma posição do array já existente. Esta função retorna o $remetentes para que seja utilizando nas demais tarefas. 

Utilizando a função *index*, temos o retorno em JSON o objeto $remetentes.

## Calcular o valor total das notas para cada remetente.

Utilizando dois FOREACH, no primeiro é percorrido novamente o objeto $remetentes, e no segundo percorre-se o array de objetos que já estão separados por CNPJ do remetente, esta lógica é utilizda para todas as demais tarefas. Tendo esta separação, é necessário apenas somar os campos referentes a valor, estes são armazenados na variável $somar_notas_rementente.

A medida que tem-se o total para cada CNPJ remetente, é armazenado em um outro objeto criado

## Calcular o valor que o remetente irá receber pelo que já foi entregue.


## Calcular o valor que o remetente irá receber pelo que ainda não foi entregue.


## Calcular quanto o remetente deixou de receber devido ao atraso na entrega.

# Controller

Todos os processos utilizaram o mesmo controller, sendo utilizado apenas funções diferentes.

- apiController       -> manipulamos a lógica de tratamento das requisições

# Rotas

- /                   -> view principal somente com os links para as respectivas tarefas
- /azapfy             -> envia para o apicontroller, em sua função 'index'
- /valor-nota         -> envia para o apicontroller, em sua função 'readValorNota'
- /valor-entregue     -> envia para o apicontroller, em sua função 'readValorEntregue'
- /valor-nao-entregue -> envia para o apicontroller, em sua função 'readValorNaoEntregue'
- /valor-atraso       -> envia para o apicontroller, em sua função 'readValorAtraso'