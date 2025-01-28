<template>
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Buscar Recetas</h1>
    
    <!-- Barra de búsqueda -->
    <div class="mb-4 flex items-center gap-4">
      <input
        type="text"
        v-model="searchQuery"
        @input="fetchRecipes"
        placeholder="Buscar recetas..."
        class="w-full p-2 border rounded shadow"
      />
    </div>

    <!-- Botones de filtro -->
    <div class="mb-4 flex gap-4">
      <button
        v-for="category in categories"
        :key="category.id"
        @click="filterBy('category_id', category.id)"
        class="px-4 py-2 bg-blue-500 text-white rounded shadow hover:bg-blue-600"
      >
        {{ category.name }}
      </button>
      <button
        v-for="cuisine in cuisines"
        :key="cuisine.id"
        @click="filterBy('cuisine_id', cuisine.id)"
        class="px-4 py-2 bg-green-500 text-white rounded shadow hover:bg-green-600"
      >
        {{ cuisine.name }}
      </button>
      <button
        v-for="user in users"
        :key="user.id"
        @click="filterBy('user_id', user.id)"
        class="px-4 py-2 bg-yellow-500 text-white rounded shadow hover:bg-yellow-600"
      >
        {{ user.name }}
      </button>
      <button
        @click="filterBy('time')"
        class="px-4 py-2 bg-red-500 text-white rounded shadow hover:bg-red-600"
      >
        Menor Tiempo
      </button>
    </div>

    <!-- Lista de recetas -->
    <div v-if="recipes.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      <div
        v-for="recipe in recipes"
        :key="recipe.id"
        class="border rounded shadow p-4 bg-white"
      >
        <h2 class="font-bold text-lg">{{ recipe.title }}</h2>
        <p class="text-gray-600">{{ recipe.description }}</p>
        <p class="text-sm text-gray-500">
          Tiempo: {{ recipe.prep_time + recipe.cook_time }} min
        </p>
      </div>
    </div>

    <p v-else class="text-center text-gray-500">No se encontraron recetas.</p>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      recipes: [],
      categories: [],
      cuisines: [],
      users: [],
      searchQuery: "",
      filters: {},
    };
  },
  methods: {
    async fetchRecipes() {
      try {
        const params = { ...this.filters, search: this.searchQuery };
        const response = await axios.get("/api/recipes/filter", { params });
        this.recipes = response.data;
      } catch (error) {
        console.error("Error fetching recipes:", error);
      }
    },
    async fetchCategories() {
      try {
        const response = await axios.get("/api/categories");
        this.categories = response.data;
      } catch (error) {
        console.error("Error fetching categories:", error);
      }
    },
    async fetchCuisines() {
      try {
        const response = await axios.get("/api/cuisines");
        this.cuisines = response.data;
      } catch (error) {
        console.error("Error fetching cuisines:", error);
      }
    },
    async fetchUsers() {
      try {
        const response = await axios.get("/api/users");
        this.users = response.data;
      } catch (error) {
        console.error("Error fetching users:", error);
      }
    },
    filterBy(key, value = null) {
      if (key === "time") {
        this.filters.sortBy = "time";
      } else {
        this.filters = { ...this.filters, [key]: value };
      }
      this.fetchRecipes();
    },
  },
  mounted() {
    this.fetchRecipes();
    this.fetchCategories();
    this.fetchCuisines();
    this.fetchUsers();
  },
};
</script>

<style>
/* Estilos opcionales */
.container {
  max-width: 1200px;
}
</style>
