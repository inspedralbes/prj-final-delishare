<template>
    <!-- Botones adicionales -->
    <div class="filter-buttons">
        <button @click="obtenerCategorias">Categoría</button>
        <div v-if="datos.length">
            <button v-for="dato in datos" :key="dato.id" class="button-secondary">
                {{ dato.name }}
            </button>
        </div>

        <button @click="obtenerCuisines">Cuisine</button>
        <div v-if="countries.length">
            <button v-for="country in countries" :key="country.id" class="button-secondary">
                {{ country.country }}
            </button>
        </div>

        <!-- Botón para obtener los tiempos -->
        <button @click="obtenerTiempos">Tiempo</button>
        <div v-if="tiempos.length">
            <button v-for="tiempo in tiempos" :key="tiempo.id" class="button-secondary">
                {{ tiempo.name }}
            </button>
        </div>

        <button @click="obtenerUsuarios">Usuario</button>

        <!-- Mostrar los nombres de los usuarios como botones -->
        <div v-if="usuarios.length">
            <button v-for="usuario in usuarios" :key="usuario.id" class="button-secondary">
                {{ usuario.name }}  <!-- Mostrar solo el 'name' de los usuarios -->
            </button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { ref } from 'vue';

export default {
    name: 'Botones',
    setup() {
        const datos = ref([]);
        const countries = ref([]);
        const usuarios = ref([]);
        const tiempos = ref([]);  // Nuevo ref para almacenar los tiempos

        // Función para obtener las categorías
        const obtenerCategorias = async () => {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/categories');
                datos.value = response.data;
                console.log(response.data);
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        };

        // Función para obtener las cocinas
        const obtenerCuisines = async () => {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/cuisines');
                countries.value = response.data;
                console.log(response.data);
            } catch (error) {
                console.error('Error fetching cuisines:', error);
            }
        };

        // Función para obtener los usuarios
        const obtenerUsuarios = async () => {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/getAllUsers');
                usuarios.value = response.data.users;
                console.log(response.data.users);
            } catch (error) {
                console.error('Error fetching users:', error);
            }
        };

        // Función para obtener los tiempos
        const obtenerTiempos = async () => {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/times'); // Cambia esta URL si es necesario
                tiempos.value = response.data;  // Asumimos que la respuesta es un array de tiempos
                console.log(response.data);  // Ver en consola los tiempos obtenidos
            } catch (error) {
                console.error('Error fetching times:', error);
            }
        };

        return {
            datos,
            obtenerCategorias,
            countries,
            obtenerCuisines,
            usuarios,
            obtenerUsuarios,
            tiempos,  // Exponer el ref tiempos para que se pueda usar en el template
            obtenerTiempos,  // Exponer la función de obtener tiempos
        };
    }
};
</script>

<style>
/* Estilos para los botones principales */
.filter-buttons {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

button {
    padding: 12px;
    background-color: #f1f1f1;
    border: 1px solid #ccc;
    cursor: pointer;
    font-size: 1rem;
}

button:hover {
    background-color: #e0e0e0;
}

/* Estilos para los botones secundarios */
.button-secondary {
    font-size: 0.75rem;  /* Tamaño de fuente mucho más pequeño */
    padding: 6px 10px;   /* Menos padding, más pequeño */
    background-color: #dcdcdc;  /* Fondo más gris claro */
    border: 1px solid #bbb;  /* Borde más suave y gris */
    color: #333;  /* Color de texto más oscuro */
    cursor: pointer;
}

.button-secondary:hover {
    background-color: #c4c4c4;  /* Fondo más oscuro cuando pasa el mouse */
}

div {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

div button {
    margin: 5px 0;
    display: inline-block;
}

/* Cambio de cursor a mano cuando pasa por los botones secundarios */
.button-secondary {
    cursor: pointer;
    border-radius: 100px;
}
</style>
