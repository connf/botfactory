import './bootstrap';

/** App Initialise */
import {createApp} from 'vue/dist/vue.esm-bundler';

/** Components */
import Customers from './components/Customers.vue';
import CustomerOrders from './components/CustomerOrders.vue';
import Order from './components/Order.vue';

const app = createApp({
    components: {
        Customers,
        CustomerOrders,
        Order,
    }
})

app.mount("#app");