<?php
if (isset($_POST['submit'])) {
    require_once('conexao.php'); // Inclui a conexão

    $nome = $_POST['name'];
    $email = $_POST['email'];
    $mensagem = $_POST['message'];

    // Prepare a SQL statement
    $stmt = $conn->prepare("INSERT INTO cliente (nome, email, mensagem) VALUES (?, ?, ?)");

    // Verifica se a preparação da consulta foi bem-sucedida
    if ($stmt === false) {
        die("Falha na preparação da consulta: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("sss", $nome, $email, $mensagem);
    
    // Execute the statement
    if ($stmt->execute()) {
        header('Location: success.php'); 
        exit();
    } else {
        echo "Erro ao inserir os dados: " . $stmt->error;
    }

    // Fecha a consulta
    $stmt->close();
    // Não fecha a conexão aqui; ela será fechada no final do script ou em outro lugar apropriado.
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S4K PROJETOS</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="regua-e-lapis.png">
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css">
    
</head>
<body>
   <header>
        <a href="#" class="logo"><span>S4K</span></a>
        <span class="material-symbols-outlined">menu</span>
        <nav class="navbar-menu">
            <a href="#">Home</a>
            <a href="#Quem-somos">Quem somos</a>
            <a href="#servicos">Serviços</a>
            <a href="#contact-form">Contato</a>
            <a href="login.php">Administrador</a>
        </nav>
   </header>
    <main id="home">
        <section class="content1">
            <div class="content">
                <h1>EMPRESA S4K PROJETOS </h1>
                <p>Bem-vindo à S4K Projetos! Somos especialistas em projetos arquitetônicos, laudos técnicos, PPCI e topografias precisas. Nosso objetivo é entender suas necessidades únicas e entregar soluções que superem suas expectativas. Confie em nós para guiá-lo em cada etapa, do planejamento à execução bem-sucedida.</p>
            </div>
        </section>
        <section class="content2">
        
        </section>
    </main>
    <section class="Quem-somos" id="Quem-somos">
        <h2 class="with-line">Quem somos</h2>
        <p>Empresa S4K Projetos se compromete com a excelência em serviços especializados em projetos arquitetônicos, laudos técnicos, PPCI e topografias precisas. Nosso foco é compreender suas necessidades específicas e oferecer soluções personalizadas que superem expectativas. Conte conosco para guiar em todas as etapas, desde o planejamento até a conclusão bem-sucedida.</p>
        <p>Com dedicação à excelência, inovação e integridade, não apenas construímos estruturas, mas também criamos espaços que inspiram, protegem e capacitam. Trabalhamos com paixão e compromisso para transformar sonhos em realidade tangível, contribuindo para um futuro mais seguro, sustentável e vibrante para todos.</p>
    
        <ol>
            <li>Compromisso: Com o cliente é priorizar e garantir satisfação em todas as etapas do processo.</li>
            <li>Integridade: Agir com honestidade, transparência e ética em todas as interações que fazemos.</li>
            <li>Responsabilidade Social e Ambiental: Contribuir positivamente para a comunidade e minimizar.</li>
            <li>Inovar: Buscar constantemente novas ideias e soluções para melhor atender às necessidades.</li>
            <li>Excelência: Comprometimento com os mais altos padrões de qualidade em tudo o que fazemos.</li>
        </ol>
      
    </section>
    <section class="services" id="servicos">
        <h2 class="with-line">Serviços</h2>
        <div class="slide-container">
            <div class="slide-content">
                <div class="card">
                    <div class="image-content">
                        <div class="overlay"></div>
                        <img src="imagem/eng.jpg" alt="Serviço 1" class="card-img">
                    </div>
                    <div class="card-content">
                        <h2>PPCI</h2>
                        <p>O PPCI (Plano de Prevenção e Proteção Contra Incêndio) reúne medidas de segurança contra incêndios, como saídas de emergência e sistemas de combate a fogo. Essencial para a segurança de edificações, deve ser aprovado pelo Corpo de Bombeiros.</p>
                    </div>
                </div>
                <div class="card">
                    <div class="image-content">
                        <div class="overlay"></div>
                        <img src="imagem/ext3.jpg" alt="Serviço 2" class="card-img">
                    </div>
                    <div class="card-content">
                        <h2>Laudos técnicos</h2>
                        <p>Laudos técnicos atestam a condição de imóveis, estruturas ou equipamentos, assegurando que estejam em conformidade com normas e regulamentações. Essenciais para garantir segurança e funcionalidade.</p>
                    </div>
                </div>
                <div class="card">
                    <div class="image-content">
                        <div class="overlay"></div>
                        <img src="imagem/ext1.jpg" alt="Serviço 3" class="card-img">
                    </div>
                    <div class="card-content">
                        <h2>Topografias </h2>
                        <p>A topografia mapeia o terreno, detalhando sua forma e relevo. Fundamental para construções, obras de infraestrutura e urbanismo, permite um planejamento preciso e eficiente das obras.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="contact-form" id="contact-form">
        <h2 class="with-line">Entre em Contato</h2>
        <form action="" method="post">
            <label for="name">Nome:</label>
            <input type="text" id="name" name="name" placeholder="Seu nome completo" required>
        
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Seu email" required>
        
            <label for="message">Mensagem:</label>
            <textarea id="message" name="message" rows="4" placeholder="Sua mensagem..." required></textarea>
        
            <button type="submit" name="submit">Enviar</button>
        </form>
    </section>
    <footer>
        <h4>© 2024 S4KPROJETOS | Todos os direitos reservados.</h4>
        <div class="icons">
            <a href="https://www.instagram.com/ketllynmt/" target="_blank">
                <img src="imagem/instagram.png" title="Clique para entrar no Instagram" class="icon-social">
            </a>
            <a href="https://wa.me/5551985208891" target="_blank">
                <img src="imagem/whatsapp.png" title="Clique para entrar no whatsapp" class="icon-social">
            </a>
            <a href="mailto:s4kprojetos@hotmail.com">
                <img src="imagem/gmail.png" title="Clique para enviar um email" class="icon-social">
            </a>
        </div>
    </footer>
</body> 
</html>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(".material-symbols-outlined").click(function() {
        $(".navbar-menu").toggle(800);
    });

    $(window).resize(function() {
        if ($(window).width() > 900) {
            $(".navbar-menu").show();
        } else {
            $(".navbar-menu").hide();
        }
    });
</script>

