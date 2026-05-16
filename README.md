# 🛸 Rick & Morty API

Aplicação web que consome a [Rick and Morty API](https://rickandmortyapi.com/) pública, permitindo visualizar personagens do multiverso, criar uma conta, fazer login e salvar seus favoritos em um banco de dados local.

🔗 **[Acesse o projeto ao vivo](https://rick-morty-local.onrender.com)**

---

---

## ✨ Funcionalidades

- 🌐 Listagem de personagens consumidos diretamente da API pública
- 🔍 Visualização detalhada de cada personagem (espécie, gênero, status, localização)
- 👤 Cadastro e login de usuários com senha criptografada
- 💾 Salvar personagens favoritos no banco de dados local
- ✏️ Editar nome e espécie dos personagens salvos
- 🗑️ Deletar personagens da coleção pessoal
- 📱 Layout responsivo adaptado para mobile e desktop

---

## 🛠️ Tecnologias utilizadas

| Tecnologia | Uso |
|---|---|
| PHP 8+ | Backend e API REST interna |
| SQLite | Banco de dados local |
| JavaScript (Vanilla) | SPA dinâmica com fetch assíncrono |
| Bootstrap 5 | Layout responsivo |
| Rick and Morty API | Fonte dos personagens |
| Render | Hospedagem em produção |

---

## ⚙️ Como rodar localmente

### Pré-requisitos

- [XAMPP](https://www.apachefriends.org/) instalado com PHP 8+

### Passo a passo

**1. Clone o repositório**
```bash
git clone https://github.com/RobertoGabriel561/rick-morty-local.git
```

**2. Mova a pasta para o XAMPP**

Coloque a pasta do projeto dentro de:
```
C:\xampp\htdocs\rick-morty-local\
```

**3. Crie a pasta do banco de dados**

Dentro da pasta do projeto, crie manualmente a pasta:
```
db/
```
O arquivo `database.sqlite` será criado automaticamente na primeira execução.

**4. Inicie o XAMPP**

Abra o XAMPP Control Panel e inicie o **Apache**.

**5. Acesse no navegador**
```
http://localhost/rick-morty-local/
```

Pronto! Não é necessário configurar nenhum banco de dados manualmente.

---

## 📁 Estrutura do projeto

```
rick-morty-local/
│
├── index.php              # Página principal (SPA)
├── db/                    # Banco de dados SQLite (gerado automaticamente)
├── sessions/              # Sessões PHP locais (gerado automaticamente)
│
├── api/
│   ├── config.php         # Configuração de sessão
│   ├── db.php             # Conexão com SQLite e criação das tabelas
│   ├── auth.php           # Login, cadastro e logout
│   ├── save_character.php # Salvar personagem favorito
│   ├── list_favorites.php # Listar favoritos do usuário
│   ├── update_character.php # Editar personagem salvo
│   └── delete_character.php # Deletar personagem salvo
│
└── js/
    └── app.js             # Toda a lógica frontend (SPA)
```

---

## 🔐 Segurança

- Senhas armazenadas com `password_hash()` (bcrypt)
- Queries com `PDO` e prepared statements (prevenção de SQL Injection)
- Sessões vinculadas ao `user_id` para isolamento de dados entre usuários

---

## 👨‍💻 Autor

**Roberto Gabriel**

[![GitHub](https://img.shields.io/badge/GitHub-RobertoGabriel561-181717?style=flat&logo=github)](https://github.com/RobertoGabriel561)
[![LinkedIn](https://img.shields.io/badge/LinkedIn-roberto--gabriel-0077B5?style=flat&logo=linkedin)](https://www.linkedin.com/in/roberto-gabriel-377156274)
