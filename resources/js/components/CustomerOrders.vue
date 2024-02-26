<template>
  <div>
    <div class="overflow-hidden overflow-x-auto p-6 bg-white border-gray-200">
        <div class="min-w-full align-middle">
          <h1>Customer Orders</h1>
            <table class="min-w-full divide-y divide-gray-200 border">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left">
                            <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">ID</span>
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left">
                            <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Bot Name</span>
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left">
                            <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Orders</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                    <tr v-for="order in orders"> 
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                            {{ order.id || 1 }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                            {{ order.bot_name || "Not Yet Generated" }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                            <a :href="'/order/' + order.id">View Order</a>
                        </td>
                    </tr> 
                </tbody>
            </table>
        </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['customer_id'],
  data() {
    return {
      orders: null,
    };
  },
  mounted() { 
    this.fetchOrders()
  },
  methods: {
    fetchOrders() {
      axios.get('/api/customerorders/' + this.customer_id)
        .then(response => {
          console.log(response.data);
          this.orders = response.data;
        })
        .catch(error => console.log(error))
    }
  } 
}
</script>
