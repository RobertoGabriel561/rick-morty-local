<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rick and Morty App - Portal Local</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilização para manter a Navbar combinando com o tema escuro cósmico */
        .navbar {
            background-color: rgba(11, 13, 23, 0.95) !important;
            border-bottom: 1px solid #3d3f5e;
            backdrop-filter: blur(10px);
        }
        .navbar-brand, .nav-link {
            transition: color 0.2s ease;
        }
        /* Efeito de brilho verde portal nos links do menu ao passar o mouse */
        .nav-link:hover {
            color: #97ce4c !important;
        }
        /* Cursor em formato de clique para os cards manipulados por JS */
        .card { 
            cursor: pointer; 
        }
        .card-img-top { 
            height: 260px; 
            object-fit: cover; 
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark mb-4 sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold text-success-neon" href="#" onclick="loadHome(); return false;">
            🛸 Rick & Morty Local
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="loadHome(); return false;">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="loadSavedCharacters(); return false;">Personagens Salvos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="loadAbout(); return false;">Sobre</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="loadLogin(); return false;">Login / Cadastro</a>
                </li>
                <li class="nav-item ms-lg-2">
                    <a class="btn btn-outline-danger btn-sm px-3 fw-bold" href="#" onclick="logout(); return false;">
                        Sair
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container my-4" id="content">
    <div class="text-center mt-5">
        <div class="spinner-border text-success"></div>
        <p class="mt-2 text-muted">Iniciando propulsores espaciais...</p>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/app.js"></script>
</body>
</html>