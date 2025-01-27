<template>
    <div class="register-container">
        <div class="register-card">
            <img src="../../img/LogoSample_ByTailorBrandsGRANDE.jpg" alt="">
            <h3>Iniciar Sesión</h3>
            <form @submit.prevent="register" class="register-form">
                <div class="form-group">
                    <label for="user">Nom d'usuari</label>
                    <input type="user" id="user" v-model="user" class="form-control"
                        placeholder="username" required />
                </div>
                <div class="form-group">
                    <label for="email">Correu Electrònic</label>
                    <input type="email" id="email" v-model="email" class="form-control"
                        placeholder="mail@exemple.com" required />
                </div>
                <div class="form-group">
                    <label for="password">Contrasenya</label>
                    <input type="password" id="password" v-model="password" class="form-control" placeholder="********"
                        required />
                </div>
                <button type="submit" class="btn-submit">Registrar-me</button>
                <p class="forgot-password">
                    <a href="/login">¿Ja tens un compte?</a>
                </p>
            </form>
        </div>
    </div>
</template>

<script>

export default {
    name: "Login",
    data() {
        return {
            user: "",
            email: "",
            password: "",
            hashedPassword: "",
        };
    },
    methods: {
        handleLogin() {
            console.log("Correo:", this.email);
            console.log("Contraseña:", this.password);
            const bcrypt = require('bcryptjs');
            this.hashedPassword = bcrypt.hashSync(this.password, 10);
            const user = {
                email: this.email,
                password: this.hashedPassword,
            };

            fetch("http://localhost:8000/register", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(user),
            })
                .then((response) => response.json())
                .then((data) => {
                    console.log("Respuesta del servidor:", data);
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        },
    },

};

</script>



<style scoped>
body {
    margin: 0;
    padding: 0;
    height: 100vh;
    width: 100vw;
    font-family: 'Roboto', sans-serif;
}

/* Estilos generales */
.register-container {
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


.register-card {
    background: #ffffff;
    padding: 2rem 1.5rem;
    border-radius: 8px;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 250px;
    text-align: center;
    height: 550px;
}

.register-title {
    margin-bottom: 2rem;
    font-size: 1.6rem;
    font-weight: 600;
    color: #343330;
}

/* Asegurando que los inputs estén centrados */
.register-form {
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
    .register-card {
        padding: 2.5rem 2rem;
    }

    .register-title {
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
    .register-card {
        max-width: 450px;
    }
}
</style>
