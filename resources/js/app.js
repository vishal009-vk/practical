import './bootstrap';

import { createApp } from 'vue'
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

import Task from './Components/Task/Task.vue'

const app = createApp({})

import store from './store'; 
import axios from 'axios';

// Set Axios Base URL
axios.defaults.baseURL = 'http://127.0.0.1:8000/api';

app.component('Task', Task);
app.use(store);  
app.use(VueSweetalert2);
app.mount('#app')
