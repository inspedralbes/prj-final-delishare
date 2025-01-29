import { createApp } from 'vue';
import App from './App.vue';
import router from './router'; // Importamos el router
import { createPinia } from 'pinia';

// Importamos jQuery correctamente
import $ from 'jquery';
import 'https://code.jquery.com/jquery-3.4.1.slim.min.js';

// Hacemos jQuery disponible globalmente (si lo necesitas en todos los componentes)
window.$ = $;

const app = createApp(App);  // 🟢 Crear la instancia de Vue
const pinia = createPinia();

app.use(pinia);   // 🟢 Ahora sí podemos usar Pinia en la app
app.use(router);  // 🟢 Agregamos Vue Router
app.mount('#app');  // 🟢 Montamos la aplicación
