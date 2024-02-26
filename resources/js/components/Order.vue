<template>
  <div>
    <div class="overflow-hidden overflow-x-auto p-6 bg-white border-gray-200">
        <div class="min-w-full align-middle">
          <h1>Order</h1>
            <table class="min-w-full divide-y divide-gray-200 border">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left">
                            <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">ID</span>
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left">
                            <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Bot Name</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                    <tr v-if="order"> 
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                            {{ order.id }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                            {{ order.bot_name }}
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
  props: ['order_id'],
  data() {
    return {
      order: null,
    };
  },
  mounted() { 
    this.fetchOrder()
  },
  methods: {
    fetchOrder() {
      axios.get('/api/order/' + this.order_id)
        .then(response => {
          console.log(response.data);
          this.order = response.data;
        })
        .catch(error => console.log(error))
    }
  } 
}
</script>
