<template>
  <main>
    <h1>Orders List</h1>

    <div class="align-end">
      <router-link to="/order/new">
        <button>New Order</button>
      </router-link>
    </div>

    <table class="ordersList">
      <thead>
        <tr>
          <th>Id</th>
          <th>Customer Name</th>
          <th>Payment Method</th>
          <th>installments</th>
          <th>Total</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="corpoTabela">
        <tr v-for="order in orders" :key="order.order_id">
          <td>{{ order.order_id }}</td>
          <td>{{ order.customer_name }}</td>
          <td>{{ order.payment_method }}</td>
          <td>{{ order.installments }}</td>
          <td>{{ order.total }}</td>
          <td>
            <div class="buttons">
              <router-link :to="`/order/${order.order_id}/edit`">
                <button>Edit</button>
              </router-link>

              <button @click="deleteOrder(order.order_id)">Delete</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </main>
</template>

<script>
import OrderService from '@/services/OrderService'

export default {
  data() {
    return {
      orders: []
    }
  },

  mounted() {
    this.getOrders()
  },

  methods: {
    getOrders() {
      OrderService.getAllOrders()
        .then((response) => {
          for (let i = 0; i < response.length; i++) {
            response[i].total = this.formatTotal(response[i].total)
          }

          this.orders = response
        })
        .catch((error) => {
          console.log(error)
        })
    },
    formatTotal(total) {
      return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL'
      }).format(total)
    },

    deleteOrder(id) {
      OrderService.deleteOne(id)
        .then(() => {
          this.getOrders()
        })
        .catch((error) => {
          console.log(error)
        })
    }
  }
}
</script>

<style>
.buttons {
  display: flex;
  justify-content: center;
  gap: 20px;
  align-items: center;
  margin: 24px;
}

.ordersList {
  width: 100%;
  max-width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
  overflow: scroll;
  margin-bottom: 20px;
}

.ordersList tr {
  border: 1px solid #dddddd;
  border-left: none;
  border-right: none;
}

.ordersList th,
.ordersList td {
  padding: 14px;
  text-align: center;
  color: #1f5d82;
}

.ordersList td {
  color: #353535;
}

.ordersList thead tr {
  border: none;
}

.ordersList tbody tr:nth-child(even) {
  background-color: #f1f1f1;
}

.align-end {
  display: flex;
  justify-content: flex-end;
  margin-right: 24px;
}
</style>
