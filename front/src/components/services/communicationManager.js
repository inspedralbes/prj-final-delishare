import axios from 'axios';

// Configuración base de Axios
const apiClient = axios.create({
  baseURL: 'http://127.0.0.1:8000/api', // Cambiar si la URL base es distinta
  headers: {
    'Content-Type': 'application/json',
    Authorization: `Bearer 1|5dkljePtMDYtdJjCZcX89iZxWnxWkSV8Xxmx88ot9aab677b`,

  },

  withCredentials: true, // Habilita el envío de cookies
});

const communicationManager = {
  // Obtener todas las recetas
  fetchRecipes() {
    return apiClient.get('/recipes')
      .then(response => response.data)
      .catch(error => {
        console.error('Error fetching recipes:', error);
        throw error;
      });
  },

  // Obtener todas las categorías
  fetchCategories() {
    return apiClient.get('/categories')
      .then(response => response.data)
      .catch(error => {
        console.error('Error fetching categories:', error);
        throw error;
      });
  },

  // Obtener todas las cocinas
  fetchCuisines() {
    return apiClient.get('/cuisines')
      .then(response => response.data)
      .catch(error => {
        console.error('Error fetching cuisines:', error);
        throw error;
      });
  },
};

export default communicationManager;
