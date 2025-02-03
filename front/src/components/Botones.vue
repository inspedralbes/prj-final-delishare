<template>
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

    <button @click="obtenerTiempos">Tiempo</button>
    <div v-if="tiempos.length">
      <button v-for="tiempo in tiempos" :key="tiempo.id" class="button-secondary">
        {{ tiempo.name }}
      </button>
    </div>

    <!-- Botón de Usuarios -->
    <button @click="obtenerUsuarios">Usuario</button>
    <div v-if="usuarios.length">
      <button v-for="user in usuarios" :key="user.id" class="button-secondary">
        {{ user.name }}
      </button>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue';
import communicationManager from '../services/communicationManager';

export default {
  name: 'Botones',
  setup() {
    const datos = ref([]);
    const countries = ref([]);
    const usuarios = ref([]);  // Asegúrate de usar "usuarios" aquí también
    const tiempos = ref([]);

    const obtenerCategorias = async () => {
      try {
        datos.value = await communicationManager.fetchCategories();
        console.log(datos.value);
      } catch (error) {
        console.error('Error fetching categories:', error);
      }
    };

    const obtenerCuisines = async () => {
      try {
        countries.value = await communicationManager.fetchCuisines();
        console.log(countries.value);
      } catch (error) {
        console.error('Error fetching cuisines:', error);
      }
    };

    const obtenerUsuarios = async () => {
      try {
        usuarios.value = await communicationManager.fetchUsers();
        console.log(usuarios.value); // Para verificar la respuesta
      } catch (error) {
        console.error('Error fetching users:', error);
      }
    };

    const obtenerTiempos = async () => {
      try {
        tiempos.value = await communicationManager.fetchTimes();
        console.log(tiempos.value);
      } catch (error) {
        console.error('Error fetching times:', error);
      }
    };

    return {
      datos,
      countries,
      usuarios,  // Asegúrate de devolver "usuarios"
      tiempos,
      obtenerCategorias,
      obtenerCuisines,
      obtenerUsuarios,
      obtenerTiempos,
    };
  },
};
</script>
