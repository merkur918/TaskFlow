<div class="login_body">
    <h1>TaskFlow</h1>
    <p>Organiza tus ideas, proyectos y tareas de forma visual y rápida.</p>
    <div class="login_form">
        <p>Regístrate para crear tu tablero personalizado.</p>

       <?php if (!empty($errores)): ?>
    <div class="error">
        <?php foreach ($errores as $error): ?>
            <p><?= $error ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

        <form action="/register_post" method="POST">
            <input type="text" name="username" placeholder="Nombre de usuario" required>
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Registrarse</button>
        </form>
        <p>¿Ya tienes una cuenta? <a href="/login">Inicia sesión</a></p>
    </div>
</div>
    