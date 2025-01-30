import axios from 'axios';

// Configuración base de Axios
const apiClient = axios.create({
  baseURL: 'http://127.0.0.1:8000/api',
  headers: {
    'Content-Type': 'application/json',
  },
  withCredentials: true, // Habilita el envío de cookies
});

// Interceptor para agregar el token a cada solicitud
apiClient.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token'); // Obtiene el token
    if (token) {
      config.headers.Authorization = `Bearer ${token}`; // Agrega el token en los headers
    }
    return config;
  },
  (error) => Promise.reject(error)
);

const communicationManager = {
  fetchRecipes() {
    return apiClient.get('/recipes')
      .then(response => response.data)
      .catch(error => {
        console.error('Error fetching recipes:', error);
        throw error;
      });
  },

  fetchCategories() {
    return apiClient.get('/categories')
      .then(response => response.data)
      .catch(error => {
        console.error('Error fetching categories:', error);
        throw error;
      });
  },

  fetchCuisines() {
    return apiClient.get('/cuisines')
      .then(response => response.data)
      .catch(error => {
        console.error('Error fetching cuisines:', error);
        throw error;
      });
  },

  fetchRecipeDetails(recipeId) {
    return apiClient.get(`/recipes/${recipeId}`)
      .then(response => response.data)
      .catch(error => {
        console.error('Error fetching recipe details:', error);
        throw error;
      });
  },

  createRecipe(recipeData) {
    return apiClient.post('/recipes', recipeData)
      .then(response => response.data)
      .catch(error => {
        console.error('Error creating recipe:', error);
        throw error;
      });
  },

  register(userData) {
    return apiClient.post('/register', userData)
      .then(response => response.data)
      .catch(error => {
        console.error('Error registering user:', error);
        throw error;
      });
  },

  login(userData) {
    return apiClient.post('/login', userData)
      .then(response => response.data)
      .catch(error => {
        console.error('Error logging in:', error);
        throw error;
      });
  }
};

export default communicationManager;
