# metodos-php

Instalação:

composer require andersonhsilva/metodos-php

configuração para chamada dos metodos de forma global no projeto laravel:

1 - edita o arquivo \config\app.conf
2 - adiciona no final do array  'aliases' => [] o seguinte: 'Metodos' => Andersonhsilva\MetodosPhp\Metodos::class,

feito isso basta chamar os metodos de qualquer lugar do projeto.

