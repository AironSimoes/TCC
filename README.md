# IronInvest

Projeto web em HTML, CSS, JavaScript, PHP e MySQL com cadastro, login e áreas protegidas por sessão.

## Rodar Localmente

1. Abra o XAMPP.
2. Ligue `Apache` e `MySQL`.
3. No PowerShell, dentro da pasta do projeto, rode:

```powershell
C:\xampp\php\php.exe -S 127.0.0.1:8000 -t C:\Users\USER\Documents\TCC
```

4. Abra no navegador:

```text
http://127.0.0.1:8000/index.html
```

## Banco De Dados Local

Importe `database/banco.sql` no phpMyAdmin local:

```text
http://localhost/phpmyadmin
```

O arquivo cria o banco `ironinvest` e a tabela `clientes`.

## InfinityFree

No InfinityFree, primeiro crie o banco pelo painel. Depois importe `database/banco-infinityfree.sql` no phpMyAdmin do próprio InfinityFree.

Para configurar a conexão, copie os dados do painel para `app/config.php`:

```php
return [
    'db_dsn' => 'mysql:host=sqlXXX.infinityfree.com;dbname=if0_00000000_ironinvest;charset=utf8mb4',
    'db_user' => 'if0_00000000',
    'db_pass' => 'SUA_SENHA_DO_INFINITYFREE',
];
```

## Arquivos Principais

- `index.html`: página inicial.
- `cadastro.html` e `cadastro.php`: criação de conta.
- `login.php`, `logout.php` e `sessao.php`: autenticação.
- `acesso.php`: roteador das áreas protegidas.
- `sobre.php`, `suporte.php` e `area-restrita.php`: páginas acessíveis apenas com login.
- `app/auth.php`: sessão, conexão PDO e funções compartilhadas.
- `app/config.php`: configuração do banco.
- `assets/css/style.css` e `assets/js/site.js`: visual e interações.
- `assets/img/`: imagens do site.
- `database/`: scripts SQL para banco local e InfinityFree.

## Checklist Rápido

- Use o site sempre por `http://127.0.0.1:8000/index.html`, não abrindo o HTML direto pelo explorador.
- Ao testar cadastro/login, confirme que o MySQL está ligado.
- Para recriar o banco local, importe `database/banco.sql`.
- Para subir no InfinityFree, importe `database/banco-infinityfree.sql` e ajuste `app/config.php`.
