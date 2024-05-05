<template>
  <main>
    <h1>Payment Methods List</h1>

    <div class="align-end">
      <router-link to="/payment/new">
        <button>New Payment Method</button>
      </router-link>
    </div>

    <table class="paymentsList">
      <thead>
        <tr>
          <th>Id</th>
          <th>Name</th>
          <th>max installments</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="corpoTabela">
        <tr v-for="payment in payments" :key="payment.id">
          <td>{{ payment.id }}</td>
          <td>{{ payment.name }}</td>
          <td>{{ payment.max_installments }}</td>
          <td>
            <div class="buttons">
              <router-link :to="`/payment/${payment.id}/edit`">
                <button>Edit</button>
              </router-link>

              <button @click="deletePayment(payment.id)">Delete</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </main>
</template>

<script>
import PaymentService from '@/services/PaymentService'

export default {
  data() {
    return {
      payments: []
    }
  },

  mounted() {
    this.getPayments()
  },

  methods: {
    getPayments() {
      PaymentService.getAllPayments()
        .then((response) => {
          console.log(response)
          this.payments = response
        })
        .catch((error) => {
          console.log(error)
        })
    },

    deletePayment(id) {
      PaymentService.deleteOne(id)
        .then(() => {
          this.getpayments()
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

.paymentsList {
  width: 100%;
  max-width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
  overflow: scroll;
  margin-bottom: 20px;
}

.paymentsList tr {
  border: 1px solid #dddddd;
  border-left: none;
  border-right: none;
}

.paymentsList th,
.paymentsList td {
  padding: 14px;
  text-align: center;
  color: #1f5d82;
}

.paymentsList td {
  color: #353535;
}

.paymentsList thead tr {
  border: none;
}

.paymentsList tbody tr:nth-child(even) {
  background-color: #f1f1f1;
}

.align-end {
  display: flex;
  justify-content: flex-end;
  margin-right: 24px;
}
</style>
