# Brasil Terra Mística UCP

UCP PHP/MySQL do Brasil Terra Mística RPG.

## Instalação no InfinityFree

1. Envie os arquivos do repositório para a pasta pública do domínio.
2. Importe `schema.sql` no phpMyAdmin para criar as tabelas do UCP.
3. No servidor, abra `config.php` e coloque a senha real do banco. **Não publique essa senha no GitHub.**
4. Confira se `contas` possui pelo menos `Nick` e `Senha`.
5. Se sua GM usar nomes diferentes para Level/Admin/Vip/Socio, ajuste as constantes no `config.php`.
6. Faça login no UCP com o mesmo Nick e senha usados no jogo.
7. A pasta `uploads` precisa permitir gravação pelo PHP.
8. Denúncias aceitam JPG/PNG/WEBP e MP4/WEBM/MOV até 25 MB.
9. BTM Insta aceita JPG/PNG/WEBP até 8 MB.
10. O painel de denúncias exige Admin/Admin > 0.

## Recursos concluídos

- Login integrado à tabela `contas`
- Dashboard da conta com leitura flexível dos campos existentes
- Notificações de decisões de denúncias no próximo login
- BTM Insta com upload de foto
- Curtidas e comentários
- Perfil com publicações
- Denúncias com prova em foto/vídeo
- Estados Pendente, Em avaliação, Aprovado e Recusado
- Painel administrativo para assumir, aprovar e recusar
- Histórico das decisões
- Música com link MP3
- Curtidas, favoritos e cópia do link
- Proteção CSRF
- Proteção básica do diretório de uploads

## Segurança

A compatibilidade com senha em texto simples existe para acompanhar GMs SA-MP que ainda armazenam senha dessa forma. O ideal, posteriormente, é migrar as contas para hash seguro sem quebrar o login do jogo.

Nunca coloque a senha real do banco em commits públicos.
