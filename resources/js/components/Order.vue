<template>
  <div>
    <div class="overflow-hidden overflow-x-auto p-6 bg-white border-gray-200">
        <div class="min-w-full align-middle">
            <table class="min-w-full divide-y divide-gray-200 border">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left">
                            <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Order Information</span>
                        </th>
                    </tr>
                </thead>
                <tbody v-if="order" class="bg-white divide-y divide-gray-200 divide-solid">
                    <tr>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                            ID
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                            {{ order.id }}
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                            Bot Name
                        </td>
                        <td v-if="!editing" class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                            {{ order.bot_name }} <a @click="edit()">EDIT</a>
                        </td>
                        <td v-if="editing" class="px-6 py-4 whitespace-no-wrap text-sm leading-5">
                            <input type="text" v-model="order.bot_name" /> <a @click="save()">SAVE</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                            Total Weight
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                            {{ order.totalWeight }}g
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Products:
                        </td>
                    </tr>
                    <div v-if="order.items" v-for="item in order.items">
                      <tr>
                          <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                            {{ item.sku }} - {{ item.product.product_name }} - x{{ item.quantity }}
                          </td>
                      </tr>
                    </div>
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
      editing: false,
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
    },
    edit() {
      this.editing = true;
    },
    save() {
      axios.post('/api/updateBotname/', {
        'order_id': this.order_id,
        'bot_name': this.order.bot_name
      }).then(response => {
        console.log(response.data);
        this.editing = false;
      })
      .catch(error => console.log(error))
    }
  } 
}
</script>
