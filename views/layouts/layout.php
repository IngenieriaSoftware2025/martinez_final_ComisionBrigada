<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?= asset('build/js/app.js') ?>"></script>
    <link rel="shortcut icon" href="<?= asset('images/cit.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= asset('build/styles.css') ?>">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
    <title>DemoApp</title>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item me-4">
                    <a class="nav-link active" aria-current="page" href="/martinez_final_ComisionBrigada/inicio">
                        <i class="bi bi-house"> INICIO</i>
                    </a>
                </li>
                
                <?php 
                session_start();
                
                if (isset($_SESSION['usuarios']) || isset($_SESSION['permisos']) || 
                    isset($_SESSION['aplicaciones']) || isset($_SESSION['asignaciones'])): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        ADMINISTRADOR
                    </a>
                    <ul class="dropdown-menu">
                        <?php if (isset($_SESSION['usuarios'])): ?>
                        <li><a class="dropdown-item" href="/martinez_final_ComisionBrigada/usuarios">USUARIOS</a></li>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['permisos'])): ?>
                        <li><a class="dropdown-item" href="/martinez_final_ComisionBrigada/permiso">PERMISOS</a></li>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['aplicaciones'])): ?>
                        <li><a class="dropdown-item" href="/martinez_final_ComisionBrigada/aplicacion">APLICACIONES</a></li>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['asignaciones'])): ?>
                        <li><a class="dropdown-item" href="/martinez_final_ComisionBrigada/asignacion">ASIG. PERMISO</a></li>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['rutas'])): ?>
                        <li><a class="dropdown-item" href="/martinez_final_ComisionBrigada/rutas">RUTAS</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <?php 
                if (isset($_SESSION['personal']) || isset($_SESSION['comisiones']) || 
                    isset($_SESSION['estadisticas']) || isset($_SESSION['mapas'])): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        COMISIONES
                    </a>
                    <ul class="dropdown-menu">
                        <?php if (isset($_SESSION['personal'])): ?>
                        <li><a class="dropdown-item" href="/martinez_final_ComisionBrigada/personal">PERSONAL</a></li>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['comisiones'])): ?>
                        <li><a class="dropdown-item" href="/martinez_final_ComisionBrigada/comision">COMISIONES</a></li>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['estadisticas'])): ?>
                        <li><a class="dropdown-item" href="/martinez_final_ComisionBrigada/estadistica">ESTADISTICAS</a></li>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['mapas'])): ?>
                        <li><a class="dropdown-item" href="/martinez_final_ComisionBrigada/mapas">MAPA</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
    <div class="progress fixed-bottom" style="height: 6px;">
        <div class="progress-bar progress-bar-animated bg-danger" id="bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="container-fluid pt-5 mb-4" style="min-height: 85vh">
        
        <?php echo $contenido; ?>
    </div>
    <div class="container-fluid " >
        <div class="row justify-content-center text-center">
            <div class="col-12">
                <p style="font-size:xx-small; font-weight: bold;">
                        Comando de Informática y Tecnología, <?= date('Y') ?> &copy;
                </p>
            </div>
        </div>
    </div>


</body>
</html>