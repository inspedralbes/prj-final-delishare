import { createApp } from 'vue';
import App from './App.vue';
import router from './router';  // Importamos el router
import { createPinia } from 'pinia';  // Importamos Pinia

// Crear la instancia de Vue y usar Vue Router y Pinia
const app = createApp(App);
// Crear la instancia de Pinia
const pinia = createPinia();

// Usar los plugins
app.use(pinia);
app.use(router);

app.mount('#app');  // Montamos la app en el div con id="app"
