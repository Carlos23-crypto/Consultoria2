<?php
$pageTitle = "Acerca de Nosotros - GQ Services";
include('includes/head.php');
include('includes/header.php');

// Datos de la empresa (equivalente a companyInfo en Angular)
$companyInfo = [
    'name' => "GQ-Services",
    'description' => "Somos un equipo conformado por dos jóvenes egresados de la carrera de Ingeniería en Sistemas Computacionales, apasionados por la tecnología y el desarrollo de soluciones prácticas para todo tipo de necesidades. Nuestra meta es apoyar a personas, emprendedores y empresas con servicios accesibles y eficientes que les permitan crecer en el ámbito digital.",
    'services' => "Ofrecemos desarrollo web, aplicaciones móviles, consultoría IT y marketing digital con enfoque en resultados medibles.",
    'mission' => "Nuestra misión es convertir nuestros conocimientos y habilidades en una herramienta útil para quienes buscan soluciones tecnológicas confiables y asequibles.",
    'vision' => "Aspiramos a consolidarnos como una empresa emergente de referencia en servicios tecnológicos dentro de nuestra comunidad y más allá.",
    'values' => ["Innovación", "Integridad", "Excelencia", "Trabajo en equipo"]
];

// Datos del equipo (equivalente a teamMembers en Angular)
$teamMembers = [
    [
        'name' => 'Isaac Quiroz',
        'position' => 'Desarrollador Frontend',
        'age' => 21,
        'image' => 'assets/img/Quiroz.jpg',
        'skills' => ['Angular', 'TypeScript', 'UI/UX'],
        'social' => [
            'facebook' => "https://www.facebook.com/share/16XUku8gsZ/",
            'instagram' => "https://www.instagram.com/isaedraqui",
            'whatsapp' => "https://wa.me/5215531218490",
            'email' => "mailto:isaaceduardorq@gmail.com"
        ]
    ],
    [
        'name' => 'Carlos Gómez',
        'position' => 'Desarrollador Backend',
        'age' => 22,
        'image' => 'assets/img/Carlos.jpg',
        'skills' => ['Node.js', 'Python', 'Bases de datos'],
        'social' => [
            'facebook' => "https://www.facebook.com/share/1ZS3rnyfVT/",
            'instagram' => "https://instagram.com/carlos_gomez7386",
            'whatsapp' => "https://wa.me/5215616881689",
            'email' => "mailto:juancarlosgomezpacheco283@gmail.com"
        ]
    ]
];
?>

<section class="about-container">
    <!-- Quiénes somos -->
    <div class="section">
        <h2 class="section-title">¿Quiénes somos?</h2>
        <p class="section-content"><?php echo $companyInfo['description']; ?></p>
    </div>

    <!-- Imagen destacada -->
    <div class="full-width-image">
        <img src="assets/img/Logo.jpg" alt="Equipo de trabajo">
    </div>

    <!-- Servicios -->
    <div class="section">
        <h2 class="section-title">Nuestros servicios</h2>
        <p class="section-content"><?php echo $companyInfo['services']; ?></p>
    </div>

    <!-- Misión, Visión y Valores -->
    <div class="grid-section">
        <div class="grid-item">
            <h3>Misión</h3>
            <p><?php echo $companyInfo['mission']; ?></p>
        </div>
        <div class="grid-item">
            <h3>Visión</h3>
            <p><?php echo $companyInfo['vision']; ?></p>
        </div>
        <div class="grid-item">
            <h3>Valores</h3>
            <ul>
                <?php foreach ($companyInfo['values'] as $value): ?>
                    <li><?php echo $value; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!-- Equipo -->
    <div class="team-section">
        <h2 class="section-title">Nuestro Equipo</h2>
        <div class="team-grid">
            <?php foreach ($teamMembers as $member): ?>
                <div class="team-card">
                    <div class="card-content">
                        <img src="<?php echo $member['image']; ?>" alt="<?php echo $member['name']; ?>" class="member-image">
                        <h3><?php echo $member['name']; ?></h3>
                        <p><strong>Edad:</strong> <?php echo $member['age']; ?> años</p>
                        <p><strong>Cargo:</strong> <?php echo $member['position']; ?></p>
                        
                        <div class="skills">
                            <h4>Conocimientos:</h4>
                            <ul>
                                <?php foreach ($member['skills'] as $skill): ?>
                                    <li><?php echo $skill; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
            
                        <!-- Contacto individual -->
                        <div class="contact-section">
                            <h4>Contactar:</h4>
                            <div class="social-icons">
                                <a href="<?php echo $member['social']['facebook']; ?>" target="_blank">
                                    <i class="fab fa-facebook"></i>
                                </a>
                                <a href="<?php echo $member['social']['instagram']; ?>" target="_blank">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="<?php echo $member['social']['whatsapp']; ?>" target="_blank">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <a href="<?php echo $member['social']['email']; ?>">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Redes Sociales adicionales -->
    <div class="social-footer-section">
        <h3 class="social-title">Síguenos en nuestras redes</h3>
        <div class="social-footer-icons">
            <a href="https://www.facebook.com/tupagina" target="_blank" class="social-icon">
                <i class="fab fa-facebook-f"></i>
                <span>Facebook</span>
            </a>
            <!--<a href="https://www.instagram.com/tucuenta" target="_blank" class="social-icon">
                <i class="fab fa-instagram"></i>
                <span>Instagram</span>
            </a>-->
            <a href="https://chat.whatsapp.com/Fit9Ce0aJMi074ZCe9Gjif" target="_blank" class="social-icon">
                <i class="fab fa-whatsapp"></i>
                <span>WhatsApp</span>
            </a>
        </div>
    </div>
</section>

<?php include('includes/footer.php'); ?>