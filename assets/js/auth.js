async function login(event) {
    event.preventDefault();
    const nombreUsuario = document.getElementById('username').value;
    const claveUsuario = document.getElementById('password').value;

    try {
        const respuesta = await fetch('auth/login', {  // Corrected 'fatch' to 'fetch'
            method: 'POST',
            headers: {  // Corrected 'Headers' to 'headers'
                'Content-Type': 'application/json',  // Corrected 'Content-type' to 'Content-Type'
            },
            body:JSON.stringify({
                nombreUsuario, 
                claveUsuario
            })
        });

        const respuestaJson = await respuesta.json();  // Corrected 'respuetaJson' to 'respuestaJson'
        if (respuestaJson.status === 'error') {
            showAlertAuth('loginAlert', 'error', respuestaJson.message);
            return false;
        }
        // Redirect to the web page
        //window.location.href = 'web';

        window.location.href = 'tarea';

    } catch (error) {
        showAlertAuth('loginAlert', 'error', 'Error al iniciar sesión: ' + error.message);  // Fixed string concatenation
        return false;
    }
}
async function register(e) {
    e.preventDefault();
    //CAPTURAR
    const nombreCompleto = document.getElementById('full_name').value;
    const usuario = document.getElementById('username').value;
    const gmail = document.getElementById('email').value;
    const clave = document.getElementById('password').value;
    const confimarClave = document.getElementById('confirm_password').value;

    
     console.log(
     nombreCompleto,
        usuario,
        gmail,
        clave,
        confimarClave,
     );

    try {
        const respuesta = await fetch("auth/register", {  
            method: "POST",
            headers: { 
                "Content-Type": "application/json",  
            },
            body:JSON.stringify({
                nombreCompleto, 
                usuario,
                gmail,
                clave,
                confimarClave,
                
            })
        });

        const respuestaJson = await respuesta.json();  // Corrected 'respuetaJson' to 'respuestaJson'
        if (respuestaJson.status === 'error') {
            showAlertAuth('registerAlert', 'error', respuestaJson.message);
            return false;
        }
        showAlertAuth('registerAlert', 'success', respuestaJson.message);  // Fixed string concatenation
        
        setTimeout(() => {
            window.location.href='login';
        }, 1000);
    } catch (error) {
        showAlertAuth('registerAlert', 'error', 'Error al registrarse: '+ error );  // + error.message Fixed string concatenation
        return false;
    }


}


function showAlertAuth(containerId, type, message) {
    const container = document.getElementById(containerId);
    container.innerHTML = `
        <div class="alert alert-${type === 'error' ? 'danger' : 'success'} alert-dismissible fade show">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;

    // Auto-close after 5 seconds
    setTimeout(() => {
        const alert = container.querySelector('.alert');
        if (alert) {
            alert.remove();
        }
    }, 5000);
}