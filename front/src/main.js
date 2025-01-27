import { createApp } from 'vue';
import App from './App.vue';
import router from './router';  // Importamos el router


// Crear la instancia de Vue y usar Vue Router
createApp(App)
  .use(router, $)  // Usamos Vue Router
  .mount('#app');  // Montamos la app en el div con id="app"
