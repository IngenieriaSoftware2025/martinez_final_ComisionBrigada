import Swal from "sweetalert2";

const FormLogin = document.getElementById('FormLogin');

if (FormLogin) {
    FormLogin.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const correo = document.getElementById('us_correo').value.trim();
        const contrasenia = document.getElementById('us_contrasenia').value.trim();
        
        // Validaciones
        if (!correo) {
            Swal.fire({
                icon: 'warning',
                title: 'Campo requerido',
                text: 'Por favor ingresa tu correo electrónico',
                confirmButtonColor: '#3085d6'
            });
            return;
        }
        
        // Validar formato de email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(correo)) {
            Swal.fire({
                icon: 'warning',
                title: 'Email inválido',
                text: 'Por favor ingresa un correo electrónico válido',
                confirmButtonColor: '#3085d6'
            });
            return;
        }
        
        if (!contrasenia) {
            Swal.fire({
                icon: 'warning',
                title: 'Campo requerido',
                text: 'Por favor ingresa tu contraseña',
                confirmButtonColor: '#3085d6'
            });
            return;
        }
        
        // Mostrar loading
        Swal.fire({
            title: 'Verificando credenciales...',
            text: 'Por favor espera',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });
        
        try {
            const formData = new FormData();
            formData.append('us_correo', correo);
            formData.append('us_contrasenia', contrasenia);
            
            const response = await fetch('/martinez_final_ComisionBrigada/login', {
                method: 'POST',
                body: formData
            });
            
            
            const result = await response.json();
            
            if (result.codigo === 1) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Bienvenido!',
                    text: result.mensaje,
                    timer: 2000,
                    timerProgressBar: false,
                }).then(() => {
                    window.location.href = '/martinez_final_ComisionBrigada/inicio';
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de acceso',
                    text: result.mensaje,
                    confirmButtonColor: '#dc3545'
                });
            }
            
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error de conexión',
                text: 'No se pudo conectar con el servidor. Intenta nuevamente.',
                confirmButtonColor: '#dc3545'
            });
        }
    });
}