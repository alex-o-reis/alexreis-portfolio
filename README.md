# Alex Reis — Portfolio (Kore Framework)

Portfólio pessoal e plataforma de currículo de **Alex de Oliveira Reis** ([alexreis.me](https://alexreis.me)), desenvolvido sobre o [Kore Framework (KKF)](https://github.com/alex-o-reis/kore-framework/) com arquitetura desacoplada **PHP REST API (SQLite)** + **Frontend SPA MVC (Bootstrap 5 + UI Relay)**.

## Arquitetura

- **`kore-api/`**: API REST PHP 8.3+ com banco de dados **SQLite** (`app/database/database.sqlite`), migrations, seeders, ORM com Traits regeneráveis (`kore make:models`), documentação OpenAPI (`/docs`) e middleware preparado para autenticação de escrita (`WriteAuthMiddleware` / `AuthMiddleware`).
- **`kore-front/`**: SPA com roteamento por hash (`#/` e `#/projeto/:slug`), internacionalização completa (**PT / EN / ES**), template dedicado (`templates/portfolio/`) e `PortfolioRenderer` modular construído com **Bootstrap 5** estendendo `BootstrapRenderer`.

> **Isolamento do Framework:** As pastas `kore-api/kore/` e `kore-front/kore/` permanecem intactas (imutáveis). Toda a lógica do portfólio reside em `app/` e `templates/`.

## Executando localmente

```bash
# 1. Instale as dependências PHP da API (Dompdf para geração dinâmica de PDF)
cd kore-api && composer install && cd ..

# 2. Copie os arquivos de ambiente (caso ainda não existam)
cp kore-api/.env.example kore-api/.env
cp kore-front/.env.example kore-front/.env

# 3. Execute migrations, geração de models e seed do banco SQLite
./kore.bat migrate
./kore.bat make:models
./kore.bat seed

# 4. Suba API (porta 8000) e Frontend (porta 3000)
./kore.bat dev
```

Acesse `http://localhost:3000` (Frontend) e `http://localhost:8000/docs` (Documentação OpenAPI).

## Gerador Dinâmico de Currículo em PDF (Fase 3)

O currículo em PDF é gerado dinamicamente em **PT, EN ou ES** via Dompdf a partir dos dados atualizados no SQLite, preservando o layout executivo A4:

- **Download direto:** `GET http://localhost:8000/resume/pdf?lang=pt|en|es&include_catalog=1&include_featured=1`
- **Pré-visualização A4 / Impressão:** `GET http://localhost:8000/resume/preview?lang=pt|en|es`
- **Painel Admin:** aba **Currículo PDF** (`http://localhost:3000/#/admin/resume`) com prévia ao vivo em iframe e opções de inclusão de catálogo e páginas de produtos em destaque.

## Painel Administrativo (Fase 2)

Acesse `http://localhost:3000/#/admin` (ou `#/login`) para gerenciar todo o conteúdo do portfólio via interface Bootstrap 5:

- **Credenciais iniciais locais (geradas pelo seeder):** `admin` / `admin123` (altere em **Perfil & Senha** antes de publicar).
- **Módulos disponíveis:**
  - **Projetos & Sistemas:** cadastro/edição PT/EN/ES, página explicativa dinâmica (`#/projeto/:slug`) com diferenciais e pilares, link do sistema (`system_url`) e vídeo explicativo (`video_url` — YouTube, Vimeo ou MP4 com pré-visualização).
  - **Experiências Profissionais:** ordem cronológica, cargos, períodos, descrições e tags.
  - **Skills:** competências agrupadas por categoria.
  - **Formação & Cursos:** graduações e cursos complementares.
  - **Perfil & Senha:** contatos, LinkedIn, disponibilidade, idiomas e alteração de senha.

## Roadmap

- **Fase 1 (concluída):** Portabilidade completa para Kore Framework + SQLite, correção de bugs/traduções PT/EN/ES, componentes Bootstrap modulares e página explicativa dinâmica de projetos (`#/projeto/:slug`).
- **Fase 2 (concluída):** Painel administrativo autenticado (`#/admin`) com `WriteAuthMiddleware` / `AuthMiddleware` e CRUD completo para experiências, skills, formação/cursos, perfil e sistemas (com página explicativa, link e vídeo).
- **Fase 3 (concluída):** Gerador dinâmico de currículo em PDF (Dompdf + pré-visualização A4) em PT/EN/ES consumindo os dados vivos do SQLite e integrado ao portfólio público e ao painel `#/admin/resume`.

## Licença

Este projeto é distribuído sob a licença **MIT**. Veja o arquivo [LICENSE](LICENSE).
