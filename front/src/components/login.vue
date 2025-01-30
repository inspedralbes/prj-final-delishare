<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import communicationManager from '@/services/communicationManager'; // Importamos communicationManager

const router = useRouter();

const form = ref({
  name: '',    // Cambié email a name porque usas 'name' como identificador para login
  password: ''
});

const errorMessage = ref('');

const handleLogin = async () => {
  try {
    // Usamos el método login de communicationManager
    const response = await communicationManager.login(form.value);

    // Guardar token en localStorage
    const token = response.token;
    localStorage.setItem('token', token);

    // Mostrar el token en consola
    console.log("Token de usuario:", token);

    // Redirigir a la landing page
    router.push('/'); 
  } catch (error) {
    console.error("Error en login:", error.response?.data);
    // Mensaje de error en caso de fallo
    errorMessage.value = error.response?.data?.message || "Credenciales incorrectas o token inválido.";
  }
};
</script>

<template>
  <div>
    <h2>Iniciar Sesión</h2>
    <form @submit.prevent="handleLogin">
      <!-- Se usa 'name' como campo de entrada -->
      <input type="text" v-model="form.name" placeholder="Nombre de usuario" required />
      <input type="password" v-model="form.password" placeholder="Contraseña" required />
      <button type="submit">Iniciar sesión</button>
    </form>
    <p v-if="errorMessage" style="color: red;">{{ errorMessage }}</p>
  </div>
</template>

<style scoped>
body {
    margin: 0;
    padding: 0;
    height: 100vh;
    width: 100vw;
    font-family: 'Roboto', sans-serif;
}

/* Estilos generales */
.login-container {
    background-image: url('/img/image.png');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    font-family: 'Roboto', sans-serif;
    overflow: hidden;
}

.login-card {
    background: #ffffff;
    padding: 2rem 1.5rem;
    border-radius: 8px;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 250px;
    text-align: center;
    height: 475px;
}

.login-title {
    margin-bottom: 2rem;
    font-size: 1.6rem;
    font-weight: 600;
    color: #343330;
}

/* Asegurando que los inputs estén centrados */
.login-form {
    display: flex;
    flex-direction: column;
    align-items: center;
    /* Centra los inputs horizontalmente */
    gap: 1.5rem;
    /* Espaciado uniforme entre los elementos */
    width: 100%;
}

.form-group {
    width: 100%;
    text-align: center;
}

label {
    display: block;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
    color: #343330;
}

input.form-control {
    width: 100%;
    /* Asegura que los inputs ocupen todo el ancho disponible */
    max-width: 200px;
    /* Limita el ancho máximo de los inputs */
    padding: 0.8rem;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 1rem;
    transition: border-color 0.3s, box-shadow 0.3s;
    text-align: left;
    /* Asegura que el texto dentro del input esté alineado a la izquierda */
}

input.form-control:focus {
    border-color: #343330;
    box-shadow: 0 0 4px rgba(0, 123, 255, 0.3);
    outline: none;
}

/* Botón */
.btn-submit {
    width: 100%;
    max-width: 300px;
    padding: 0.8rem;
    background: #358600;
    color: #ffffff;
    font-size: 1rem;
    font-weight: 600;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s, box-shadow 0.3s;
}

.btn-submit:hover {
    background: #235800;
    box-shadow: 0 2px 10px rgba(0, 91, 179, 0.2);
}

/* Enlace de contraseña olvidada */
.forgot-password {
    margin-top: 1rem;
    font-size: 0.9rem;
}

.forgot-password a {
    color: #358600;
    text-decoration: none;
    transition: color 0.3s;
}

.forgot-password a:hover {
    color: #235800;
}

/* Media queries */
@media (min-width: 768px) {
    .login-card {
        padding: 2.5rem 2rem;
    }

    .login-title {
        font-size: 1.8rem;
    }

    input.form-control {
        padding: 1rem;
    }

    .btn-submit {
        font-size: 1.1rem;
        padding: 1rem;
    }
}

@media (min-width: 992px) {
    .login-card {
        max-width: 450px;
    }
}
</style>