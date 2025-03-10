import './bootstrap';
import { createApp } from 'vue';
import ViewAjax from './components/ViewAjax.vue';
const app = createApp({});
app.component('view-ajax',ViewAjax);
app.mount('#app');
