<template>
    <!-- Botones adicionales -->
    <div class="filter-buttons">
        <button @click="obtenerCategorias">Categoría</button>
        <ul v-if="datos.length">
            <button v-for="dato in datos" :key="dato.id">
                {{ dato.name }}
            </button>
        </ul>   

        <button @click="obtenerCuisines">Cuisine</button>
        <ul v-if="countries.length">
            <li v-for="country in countries" :key="country.id">
                <button @click="seleccionarCountry(country)">
                    {{ country.country }}
                </button>
            </li>
        </ul>

        <button>Tiempo</button>
        <button>Usuario</button>
    </div>
</template>

<script>
import axios from 'axios';
import { ref } from 'vue';

export default {
    name: 'Botones',
    setup() {
        const datos = ref([]);
        const countries = ref([]); // Almacenar los países
        const showCountries = ref(false);  // Para manejar la visibilidad de la lista de países

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

        // Función para obtener los países
        const obtenerCuisines = async () => {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/cuisines');  // Cambia la URL si es necesario
                countries.value = response.data;
                showCountries.value = true;  // Mostrar la lista de países cuando los datos son obtenidos
                console.log(response.data);
            } catch (error) {
                console.error('Error fetching countries:', error);
            }
        };

      

        return {
            datos,
            obtenerCategorias,
            countries,
            obtenerCuisines,
            showCountries,
        };
    }
};
</script>

<style>
/* Agrega tus estilos aquí */
.filter-buttons {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

button {
    padding: 10px;
    background-color: #f1f1f1;
    border: 1px solid #ccc;
    cursor: pointer;
}

button:hover {
    background-color: #e0e0e0;
}

ul {
    list-style-type: none;
    padding: 0;
}

ul li {
    margin: 5px 0;
}
</style>
