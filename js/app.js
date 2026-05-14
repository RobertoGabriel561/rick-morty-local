// js/app.js
const content = document.getElementById('content');

// Inicialização automática do sistema ao carregar a página
window.onload = () => {
    applySpaceBackground();
    loadHome();
};

// --- DICIONÁRIO DE TRADUÇÃO DA API (INCLUINDO LOCALIZAÇÕES) ---
const translate = {
    // Espécies
    "Human": "Humano",
    "Alien": "Alienígena",
    "Humanoid": "Humanoide",
    "Poopybutthole": "Poopybutthole",
    "Mythological Creature": "Criatura Mitológica",
    "Animal": "Animal",
    "Robot": "Robô",
    "Cronenberg": "Cronenberg",
    "Disease": "Doença",
    "Unknown": "Desconhecido",
    
    // Gêneros
    "Male": "Masculino",
    "Female": "Feminino",
    "Genderless": "Sem Gênero",
    "unknown": "Desconhecido",
    
    // Status de Vida
    "Alive": "Vivo",
    "Dead": "Morto",

    // Localizações Comuns (Planetas, Dimensões e Estações)
    "Earth (C-137)": "Terra (C-137)",
    "Earth (Replacement Dimension)": "Terra (Dimensão de Substituição)",
    "Abadango": "Abadango",
    "Citadel of Ricks": "Cidadela dos Ricks",
    "Worldender's lair": "Guarida do Destruidor de Mundos",
    "Anatomy Park": "Parque de Anatomia",
    "Interdimensional Cable": "Cabo Interdimensional",
    "Imortan Joe's Citadel": "Cidadela do Imortan Joe",
    "Post-Apocalyptic Earth": "Terra Pós-Apocalíptica",
    "Purge Planet": "Planeta do Expurgo",
    "Venzenulon 7": "Venzenulon 7",
    "Balthromaw": "Balthromaw",
    "Nu訂ia": "Nu訂ia",
    "Gromflom Prime": "Gromflom Prime",
    "Earth (Evil Rick's Target Dimension)": "Terra (Dimensão Alvo do Rick Malvado)"
};

// Função auxiliar para converter termos técnicos da API para português
function t(term) {
    if (!term) return "Desconhecida";
    return translate[term] || term;
}

// --- VISUAL ESPACIAL (DEGRADÊ + ESTRELAS + VERDE RICK NEON) ---
function applySpaceBackground() {
    // Aplica o degradê linear que vai do preto profundo ao cinza escuro azulado cósmico
    document.body.style.background = "linear-gradient(180deg, #05050a 0%, #141624 100%)";
    document.body.style.backgroundAttachment = "fixed"; // Trava o fundo no scroll da tela
    document.body.style.color = "#e0e0e0";
    
    // Projeta camadas paralelas de estrelas circulares por cima do degradê
    document.body.style.backgroundImage = `
        radial-gradient(white, rgba(255,255,255,.3) 2px, transparent 40px),
        radial-gradient(white, rgba(255,255,255,.15) 1px, transparent 30px),
        linear-gradient(180deg, #05050a 0%, #141624 100%)
    `;
    document.body.style.backgroundSize = "550px 550px, 350px 350px, 100% 100%";

    // Estilização injetada para os Cards de Vidro Fosco (Glassmorphism) e efeitos Neon
    const style = document.createElement('style');
    style.innerHTML = `
        .card { 
            background-color: rgba(26, 28, 44, 0.75) !important; 
            border: 1px solid #3d3f5e !important; 
            color: #fff !important;
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
        }
        .card:hover { 
            border-color: #97ce4c !important; 
            box-shadow: 0 0 20px rgba(151, 206, 76, 0.5); 
            transform: translateY(-5px);
        }
        .text-muted { color: #b0b0b0 !important; }
        .text-success-neon { color: #97ce4c !important; }
        .btn-success-neon { background-color: #97ce4c !important; color: #05050a !important; font-weight: bold; border: none; }
        .btn-success-neon:hover { background-color: #b2e061 !important; box-shadow: 0 0 15px #97ce4c; }
        .form-control { background-color: #05050a !important; color: #fff !important; border-color: #3d3f5e !important; }
        .form-control:disabled { background-color: #25273c !important; }
        .spinner-border { color: #97ce4c !important; }
    `;
    document.head.appendChild(style);
}

// --- TELA HOME (API) ---
async function loadHome() {
    content.innerHTML = '<div class="text-center mt-5"><div class="spinner-border"></div><p class="mt-2">Buscando fendas temporais na API...</p></div>';
    try {
        const response = await fetch('https://rickandmortyapi.com/api/character');
        const data = await response.json();
        
        let html = '<h2 class="mb-4 text-success-neon">Personagens do Multiverso (API)</h2><div class="row">';
        data.results.forEach(char => {
            html += `
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow-sm" onclick='showDetails(${JSON.stringify(char)}, true)'>
                        <img src="${char.image}" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title text-success-neon">${char.name}</h5>
                            <p class="card-text text-muted">Espécie: ${t(char.species)}</p>
                        </div>
                    </div>
                </div>`;
        });
        content.innerHTML = html + '</div>';
    } catch (error) {
        content.innerHTML = '<div class="alert alert-danger">Erro ao abrir portal com a API externa.</div>';
    }
}

// --- TELA PERSONAGENS SALVOS (BANCO LOCAL) ---
async function loadSavedCharacters() {
    content.innerHTML = '<div class="text-center mt-5"><div class="spinner-border"></div><p class="mt-2">Acessando banco de dados local...</p></div>';
    try {
        const response = await fetch('api/list_favorites.php');
        const data = await response.json();

        if (data.status === 'error' || !data || data.length === 0) {
            content.innerHTML = `
                <h2 class="mb-4 text-success-neon">Coleção de Personagens</h2>
                <div class="alert alert-warning bg-dark text-warning border-warning">Nenhum viajante interdimensional salvo no seu banco local. Faça login e salve alguns personagens!</div>`;
            return;
        }

        let html = '<h2 class="mb-4 text-success-neon">Sua Coleção Salva (Banco Local)</h2><div class="row">';
        data.forEach(char => {
            html += `
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow-sm" onclick='showDetails(${JSON.stringify(char)}, false)'>
                        <img src="${char.image}" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title text-success-neon">${char.name}</h5>
                            <p class="card-text text-muted">Espécie: ${t(char.species)}</p>
                            <button class="btn btn-danger btn-sm w-100 mt-2" onclick="deleteChar(event, ${char.id})">Deletar Registro</button>
                        </div>
                    </div>
                </div>`;
        });
        content.innerHTML = html + '</div>';
    } catch (e) {
        content.innerHTML = '<div class="alert alert-danger">Erro ao carregar os dados locais.</div>';
    }
}

// --- TELA DETALHES ---
function showDetails(char, isFromApi) {
    // Trata se a localização veio estruturada como Objeto (API) ou Texto Puro (Banco Local)
    const locName = (char.location && typeof char.location === 'object') ? char.location.name : char.location;

    content.innerHTML = `
        <div class="card p-4 shadow max-width mx-auto" style="max-width: 800px;">
            <div class="row g-0">
                <div class="col-md-4 d-flex align-items-center">
                    <img src="${char.image}" class="img-fluid rounded border border-secondary shadow w-100">
                </div>
                <div class="col-md-8 px-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-success-neon">Nome do Personagem</label>
                        <input type="text" id="edit-name" class="form-control" value="${char.name}" ${isFromApi ? 'disabled' : ''}>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-success-neon">Espécie</label>
                        <input type="text" id="edit-species" class="form-control" value="${t(char.species)}" ${isFromApi ? 'disabled' : ''}>
                    </div>
                    <p><strong>Gênero Cósmico:</strong> ${t(char.gender || 'unknown')}</p>
                    <p><strong>Status de Vida:</strong> ${t(char.status || 'unknown')}</p>
                    <p><strong>Localização Atual:</strong> ${t(locName)}</p>
                    <hr style="border-color: #3d3f5e;">
                    <div class="d-flex justify-content-between">
                        <button onclick="${isFromApi ? 'loadHome()' : 'loadSavedCharacters()'}" class="btn btn-outline-light">Voltar</button>
                        ${isFromApi ? 
                            `<button class="btn btn-success-neon" onclick="saveToDb('${char.name}', '${t(char.species)}', '${char.image}', '${t(locName)}')">Salvar no Banco</button>` : 
                            `<button class="btn btn-primary" onclick="updateChar(${char.id})">Confirmar Alterações</button>`
                        }
                    </div>
                </div>
            </div>
        </div>`;
}

// --- OPERAÇÕES CRUD VIA AJAX (PHP API) ---
async function saveToDb(name, species, image, location) {
    const fd = new FormData();
    fd.append('name', name);
    fd.append('species', species);
    fd.append('image', image);
    fd.append('url', location); // Salva a localização traduzida no campo de string do banco

    const res = await fetch('api/save_character.php', { method: 'POST', body: fd });
    const result = await res.json();
    
    alert(result.message);
    if (result.status === 'error' && result.message.includes('logado')) {
        loadLogin();
    }
}

async function updateChar(id) {
    const fd = new FormData();
    fd.append('id', id);
    fd.append('name', document.getElementById('edit-name').value);
    fd.append('species', document.getElementById('edit-species').value);

    const res = await fetch('api/update_character.php', { method: 'POST', body: fd });
    const result = await res.json();
    if(result.status === 'success') {
        alert('Modificações salvas na realidade local!');
        loadSavedCharacters();
    } else {
        alert('Falha ao reescrever dados.');
    }
}

async function deleteChar(event, id) {
    event.stopPropagation();
    if(!confirm('Deseja mesmo banir este registro da sua dimensão local?')) return;
    
    const res = await fetch(`api/delete_character.php?id=${id}`);
    const result = await res.json();
    if (result.status === 'success') {
        loadSavedCharacters();
    }
}

// --- TELA SOBRE (MINI CURRÍCULO) ---
function loadAbout() {
    content.innerHTML = `
        <div class="card p-5 shadow">
            <h2 class="text-success-neon">🛸 Roberto Gabriel</h2>
            <hr style="border-color: #3d3f5e;">
            <p class="lead">Saudações! Bem-vindo ao meu centro de controle e portfólio.</p>
            <p>Sou desenvolvedor e estruturei este sistema integrando consumo dinâmico da API global de Rick and Morty através de requisições assíncronas (Fetch API), encapsulamento no Back-end com endpoints estruturados em PHP e persistência local em banco SQLite.</p>
            
            <h5 class="mt-4 text-success-neon">Acesse meus Canais Interdimensionais:</h5>
            <div class="mt-3">
                <a href="https://github.com/RobertoGabriel561" target="_blank" class="btn btn-outline-light me-2">
                    📦 Perfil Oficial no GitHub
                </a>
                <a href="https://www.linkedin.com/in/roberto-gabriel-377156274?utm_source=share_via&utm_content=profile&utm_medium=member_android" target="_blank" class="btn btn-outline-info">
                    💼 LinkedIn Profissional
                </a>
            </div>
        </div>`;
}

// --- TELA LOGIN / CADASTRO ---
function loadLogin() {
    content.innerHTML = `
        <div class="row justify-content-center mt-4">
            <div class="col-md-4 card p-4 shadow">
                <h3 id="auth-title" class="mb-4 text-center text-success-neon">Identificação</h3>
                <form id="auth-form" autocomplete="off">
                    <div class="mb-3" id="name-field" style="display:none">
                        <label class="form-label text-muted">Nome Completo</label>
                        <input type="text" id="auth-name" class="form-control" placeholder="Ex: Rick Sanchez" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Endereço de E-mail</label>
                        <input type="email" id="auth-email" class="form-control" placeholder="seuemail@universo.com" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Chave de Acesso (Senha)</label>
                        <input type="password" id="auth-pass" class="form-control" placeholder="Sua senha secreta" required autocomplete="new-password">
                    </div>
                    <button type="submit" class="btn btn-success-neon w-100" id="auth-btn">Entrar na Fenda</button>
                </form>
                <p class="mt-3 text-center mb-0">
                    <a href="#" id="toggle-auth" onclick="toggleAuth(event)" class="text-info">Novo nesta galáxia? Cadastre-se aqui</a>
                </p>
            </div>
        </div>`;

    document.getElementById('auth-form').onsubmit = handleAuth;
}

function toggleAuth(e) {
    e.preventDefault();
    const isLogin = document.getElementById('auth-title').innerText === 'Identificação';
    document.getElementById('auth-title').innerText = isLogin ? 'Novo Registro' : 'Identificação';
    document.getElementById('auth-btn').innerText = isLogin ? 'Registrar Cidadão' : 'Entrar na Fenda';
    document.getElementById('name-field').style.display = isLogin ? 'block' : 'none';
    e.target.innerText = isLogin ? 'Já possui credenciais? Conecte-se' : 'Novo nesta galáxia? Cadastre-se aqui';
}

async function handleAuth(e) {
    e.preventDefault();
    const isLogin = document.getElementById('auth-title').innerText === 'Identificação';
    const action = isLogin ? 'login' : 'register';
    
    const fd = new FormData();
    fd.append('email', document.getElementById('auth-email').value);
    fd.append('password', document.getElementById('auth-pass').value);
    if(!isLogin) fd.append('name', document.getElementById('auth-name').value);

    const res = await fetch(`api/auth.php?action=${action}`, { method: 'POST', body: fd });
    const result = await res.json();

    if(result.status === 'success') {
        alert(isLogin ? 'Autenticação bem-sucedida, portal liberado!' : 'Cidadão registrado no banco de dados! Prossiga com o login.');
        isLogin ? loadHome() : loadLogin();
    } else {
        alert(result.message);
    }
}

// --- FUNÇÃO PARA DESCONECTAR (LOGOUT) ---
async function logout() {
    if (!confirm("Deseja mesmo fechar este portal e sair da sessão?")) return;

    try {
        const res = await fetch('api/auth.php?action=logout');
        const result = await res.json();

        if (result.status === 'success') {
            alert("Sessão encerrada com sucesso, viajante!");
            loadLogin(); // Redireciona e renderiza a tela de login zerada
        } else {
            alert("Erro ao tentar fechar a sessão.");
        }
    } catch (e) {
        alert("Sessão encerrada!");
        loadLogin();
    }
}