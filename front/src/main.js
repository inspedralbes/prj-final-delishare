import { createApp } from 'vue';
import App from './App.vue';
import router from './router'; // Importamos el router
import { createPinia } from 'pinia';

// Crear la instancia de Vue y usar Vue Router y Pinia
const app = createApp(App);

app.use(router);  // Usamos Vue Router
app.use(createPinia());  // Usamos Pinia

const app = createApp(App);  // 🟢 Crear la instancia de Vue
const pinia = createPinia();

app.use(pinia);   // 🟢 Ahora sí podemos usar Pinia en la app
app.use(router);  // 🟢 Agregamos Vue Router
app.mount('#app');  // 🟢 Montamos la aplicación
