# Agência Pantanal

Site institucional e catálogo de passeios para uma agência de turismo focada no Pantanal.

## Stack

- PHP 8+
- MySQL 8+
- HTML, CSS e JavaScript
- Sem Docker

## Recursos

- Home premium com linguagem visual cinematográfica
- Hero com vídeo configurável e poster/fallback em imagem
- Busca própria de passeios por texto e categoria
- Página de detalhes de cada passeio
- Formulário de orçamento com adultos, crianças, período e nome do cliente
- Redirecionamento para WhatsApp com mensagem pronta
- Painel administrativo com login
- Cadastro, edição e exclusão de passeios
- Upload e gerenciamento de fotos de passeios
- Gerenciamento de vídeo, poster e imagens editoriais do site
- Seção dedicada à onça-pintada
- Conteúdo sobre Transpantaneira e Porto Jofre
- Galeria editorial
- Depoimentos e FAQ
- Páginas institucionais de Sobre, Destinos e Planejamento/Contato
- Animações de entrada e navegação responsiva

## Instalação

1. Crie um banco MySQL e importe `database/schema.sql`.
2. Para aplicar os novos padrões visuais em uma instalação já criada, importe também `database/premium_defaults.sql`.
3. Copie `.env.example` para `.env` e configure banco, URL do site e WhatsApp.
4. Garanta permissão de escrita em `public/uploads/`.
5. Aponte o DocumentRoot do servidor para a pasta `public/`.
6. Acesse `/admin/login.php` e use o usuário criado pelo script SQL. Troque a senha no primeiro acesso.

## Hero e mídia

O hero aceita MP4/WebM enviado pelo painel ou uma URL externa de vídeo. Quando nenhum vídeo estiver configurado, o site usa uma imagem cinematográfica como fallback para não deixar o hero quebrado.

O painel também permite alterar as imagens editoriais usadas nas seções de onça-pintada, Transpantaneira, Porto Jofre e jacaré. Os padrões adicionados em `premium_defaults.sql` utilizam imagens públicas do Unsplash que podem ser substituídas a qualquer momento.

Para o hero final, a recomendação é usar um único MP4 otimizado, sem áudio, com uma pequena montagem de onça-pintada bebendo água e jacaré nadando. Isso evita dependência de players externos e mantém autoplay, loop e desempenho previsíveis.

## WhatsApp

Na página de cada passeio, o formulário gera uma mensagem com nome do cliente, passeio escolhido, quantidade de adultos, quantidade de crianças, data de entrada e data de saída.

A página `contato.php` também possui um planejador geral, com experiência de interesse e observações adicionais, e envia tudo organizado para o WhatsApp.
