import './bootstrap';
import {createApp} from 'vue/dist/vue.esm-bundler';
import Example from './components/Example.vue';
import Customers from './components/Customers.vue';
import CustomerOrders from './components/CustomerOrders.vue';
import Order from './components/Order.vue';

const app = createApp({
    components: {
        Example,
        Customers,
        CustomerOrders,
        Order,
    }
})

app.mount("#app");