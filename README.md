# spacex_rdstation
Stay tunned with the launchs made by spacex (RD Station challenge)

# TECNOLOGIAS UTILIZADAS:

- PHP
- MySQL
- NginX
- Codeigniter
- API (SpaceX)
- cURL

# CONFIGURANDO O AMBIENTE:

1 - Para rodar o projeto faça o download das aplicações dentro da pasta do servidor no Nginx 
No linux (/var/www/htlm/)

2 - Configure três hosts virtuais em:

Linux:<br /> 
caminho: /etc/hosts

Adicione:

127.0.0.1       local.api.com     (API)<br />
127.0.0.1       local.spacex.com      (AppA)<br />
127.0.0.1       local.space.com     (APPB)<br />

3 - Configure os servidores dentro do NginX, crie esses arquivos dentro dos seguintes diretórios:

(Aplicação A)<br />
/etc/nginx/sites-available/local.spacex.com<br />
/etc/nginx/sites-enabled/local.spacex.com<br />

Conteúdo:
```
server {
        listen           80;
        server_name      local.spacex.com;

        root             [CAMINHO DA APLICAÇÃO A];
        index           index.php;

        location / {
                # Check if a file or directory index file exists, else route it to index.php.
                try_files $uri $uri/ /index.php?/$request_uri;
        }

        location ~ \.php$ {
            fastcgi_pass   unix:/var/run/php/php-fpm.sock;
            fastcgi_index  index.php;
            fastcgi_read_timeout 500;
            client_max_body_size 10M;
            #root          /var/www/html;
            include        fastcgi.conf;
         }
}
```

(Aplicação B)<br />
/etc/nginx/sites-enabled/local.space.com<br />
/etc/nginx/sites-enabled/local.space.com<br />

Conteúdo:
```
server {
        listen           80;
        server_name      local.space.com;

        root             [CAMINHO DA APLICAÇÃO B];
        index           index.php;

        location / {
                # Check if a file or directory index file exists, else route it to index.php.
                try_files $uri $uri/ /index.php?/$request_uri;
        }

        location ~ \.php$ {
            fastcgi_pass   unix:/var/run/php/php-fpm.sock;
            fastcgi_index  index.php;
            fastcgi_read_timeout 500;
            client_max_body_size 10M;
            #root          /var/www/html;
            include        fastcgi.conf;
         }
}
```

4 - BANCO DE DADOS

Utilize o banco de dados MySQL para rodar a aplicação:

Dentro do projeto A existe uma pasta chamada "DB"

Crie um banco de dados chamado "coin" e importe as tabelas para o banco.

```
CREATE DATABASE coin;
USE coin;
```

5 - Depois desses passos as aplicações estaram rodando normalmente.

