# Agência Pantanal

Site institucional e catálogo de passeios para uma agência de turismo focada no Pantanal.

## Stack

- PHP 8+
- MySQL 8+
- HTML, CSS e JavaScript
- Sem Docker

## Recursos

- Home com hero em vídeo
- Busca própria de passeios
- Página de detalhes de cada passeio
- Formulário de orçamento com adultos, crianças, período e nome do cliente
- Redirecionamento para WhatsApp com mensagem pronta
- Painel administrativo com login
- Cadastro, edição e exclusão de passeios
- Upload e gerenciamento de fotos de passeios
- Gerenciamento de imagens e vídeo do site

## Instalação

1. Crie um banco MySQL e importe `database/schema.sql`.
2. Copie `.env.example` para `.env` e configure banco, URL do site e WhatsApp.
3. Garanta permissão de escrita em `public/uploads/`.
4. Aponte o DocumentRoot do servidor para a pasta `public/`.
5. Acesse `/admin/login.php` e use o usuário criado pelo script SQL. Troque a senha no primeiro acesso.

## Hero em vídeo

O hero aceita um vídeo configurável no painel. O projeto inclui o caminho padrão `assets/video/pantanal-hero.mp4`. Substitua esse arquivo por um vídeo licenciado de uma onça-pintada bebendo água e um jacaré nadando, ou altere a URL pelo painel administrativo.

## WhatsApp

O formulário do passeio gera uma mensagem com nome do cliente, passeio escolhido, quantidade de adultos, quantidade de crianças, data de entrada e data de saída, e abre o WhatsApp com tudo preenchido.
