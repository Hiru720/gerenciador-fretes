# Gerenciador de Fretes

Projeto da disciplina **Fundamentos de Programação para Internet** (UNIPAR EAD).

Sistema web para cadastrar produtos, endereços e transportadores, e gerar fretes ligando esses dados. Um transportador pode levar vários produtos no mesmo frete (relação 1 para muitos).

## Funcionalidades

- Cadastro, edição e exclusão de **produtos**, **endereços** (origem e destino) e **transportadores**
- Geração de **frete** com um transportador, origem, destino e vários produtos
- Campos de produto adicionados dinamicamente com JavaScript
- **Relatório** dos fretes de um dia, com download em CSV (abre no Excel)
- Menu de navegação em todas as telas

## Tecnologias

- PHP 8 (backend, com PDO)
- MySQL / MariaDB
- HTML, CSS e JavaScript
- Bootstrap 5 (visual)
- XAMPP (ambiente de testes)
- Git e GitHub (versionamento)

## Como rodar

1. Instale o [XAMPP](https://www.apachefriends.org) e inicie o **Apache** e o **MySQL**
2. Copie esta pasta para `C:\xampp\htdocs\Fretes`
3. Abra o phpMyAdmin (`http://localhost/phpmyadmin`), vá na aba **SQL** e execute o arquivo `banco.sql`
4. Acesse `http://localhost/Fretes`

## Estrutura de pastas

```
Fretes/
├── config/            conexão com o banco
├── includes/          cabeçalho, rodapé e funções comuns
├── css/               estilos
├── js/                máscaras e campos dinâmicos
├── produtos/          telas e ações dos produtos
├── enderecos/         telas e ações dos endereços
├── transportadores/   telas e ações dos transportadores
├── fretes/            geração e consulta de fretes
├── relatorios/        relatório por dia e download em CSV
├── banco.sql          script do banco de dados
└── index.php          painel inicial
```

## Autor

Gabriel Vitor
