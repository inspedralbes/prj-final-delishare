<template>
    <!-- Botones adicionales -->
    <div class="filter-buttons">
        <button @click="obtenerCategorias">Categoría</button>
        <ul v-if="datos.length">
            <button v-for="dato in datos" :key="dato.id">
            {{ dato.name }}
            </button>

    
        </ul>   
        <button>Cuisine</button>
        
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

        const obtenerCategorias = async () => {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/categories');
                datos.value = response.data;
                console.log(response.data);
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        };

        return {
            datos,
            obtenerCategorias
        };
    }
};
</script>

<style>
/* Agrega tus estilos aquí */
</style>