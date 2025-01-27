import { createApp } from 'vue';
import App from './App.vue';
import router from './router'; // Importamos el router

// Importamos jQuery correctamente
import $ from 'jquery';
import 'https://code.jquery.com/jquery-3.4.1.slim.min.js';

// Hacemos jQuery disponible globalmente (si lo necesitas en todos los componentes)
window.$ = $;

// Crear la instancia de Vue y usar Vue Router
createApp(App)
  .use(router) // Usamos Vue Router
  .mount('#app'); // Montamos la app en el div con id="app"
