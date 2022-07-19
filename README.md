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

Ainda na função *apiremetente*, é usado a estrutura de repetição FOREACH para percorrer a API e separar as informações que contenham o mesmo CNPJ de remetente, atribuindo-os ao objeto $remetentes. É usado um *array_push* para termos um objeto de arrays de objetos, de forma que, ou é adicionado uma posição no array ao identificar um novo CNPJ do remetente, ou é "concatenado" o novo objeto a mesma posição do array já existente. Esta função retorna o $remetentes para que seja utilizando nas demais tarefas. 

Utilizando a função *index*, temos o retorno em JSON o objeto $remetentes.

## Calcular o valor total das notas para cada remetente.

Na função *readValorNota*, utiliza-se dois FOREACH: no primeiro é percorrido novamente o objeto $remetentes, e no segundo percorre-se o array de objetos que já estão separados por CNPJ do remetente, esta lógica é utilizda para todas as demais tarefas. Tendo esta separação, é necessário apenas somar os campos referentes a valor, estes são armazenados na variável $somar_notas_rementente.

A medida que tem-se o total para cada CNPJ remetente, é armazenado em um outro objeto criado. É retornado o objeto $soma_notas, que contém o valor total das notas ($somar_notas_rementente) para cada nome de remetente ($nome_remetente).

## Calcular o valor que o remetente irá receber pelo que já foi entregue.

Na função *readValorEntregue* segue-se a mesma lógica mencionada anteriormente, 2 FOREACH com objetivo de realizar o somatório das notas. A diferença aqui é a necessidade de se utilizar estruturas condicionais para fragmentar o código.

Aqui tem-se duas condições: a primeira para percorrer somente os objetos a qual o valor do status seja 'COMPROVADO', e para cada objeto que atingir esta condição, subtrair a data de entrega com a data de emissão (usando-se a classe *DateTime* e o método *format* para transformar do padrão brasileiro ao padrão americano e realizar os calculos). A segunda condição é para atender a regra de negócio referente aos remetentes receberem somente por produtos que tenham no máximo 2 dias de transporte, logo, somente os resultados menor ou igual a 2 da primeira condição tem seu valor somado aqui.

É retornado o objeto $soma_entregue, que contém o valor total das notas da segunda condição ($somar_entrega) para cada nome de remetente ($nome_remet).

## Calcular o valor que o remetente irá receber pelo que ainda não foi entregue.

Na função *readValorNaoEntregue* tem-se uma lógica bem semelhante a tarefa anterior, com a diferença de que a primeira estrutura condicional permite apenas objetos a qual o valor do status seja 'ABERTO'. Já a segunda condição, é somado apenas os resultados menores ou iguals a 2 para a subtração da data de hoje ($hoje = *date('d/m/Y h:i:s')*) com a data de emissão do produto.

Como os dados da API são antigos, todos os resultados retornados no objeto $soma_aberto são iguais a 0, ou seja, nenhuma subtração da data de hoje com a data de emissão é menor ou igual a 2.

## Calcular quanto o remetente deixou de receber devido ao atraso na entrega.

Por fim, a ultima tarefa é tratada na função *readValorAtraso*, que segue também uma lógica semelhante às duas últimas tarefas. Aqui é necessário tratar separadamente tanto objetos com valor de status 'ABERTO' e também os objetos com valor de status 'COMPROVADO', isso pelo fato de que objetos com status 'ABERTO' não possuem data de entrega, logo, não é possível tratar ambos na mesma condição.

Retorna-se no objeto $soma_atrasado o somatório de todos os valores ($somar_receber_atraso), por remetente ($nome_remet), a qual a data de transporte seja maior do que 2, logo, valores que foram "perdidos" por conta do atraso na entrega.

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
