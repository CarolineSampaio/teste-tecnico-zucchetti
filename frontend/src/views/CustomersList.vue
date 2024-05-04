<template>
  <main>
    <h1>Customers List</h1>

    <div class="align-end">
      <button>Cadastrar Cliente</button>
    </div>

    <table class="customersList">
      <thead>
        <tr>
          <th>Id</th>
          <th>Name</th>
          <th>Email</th>
          <th>CPF</th>
          <th>Address</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="corpoTabela">
        <tr v-for="customer in customers" :key="customer.id">
          <td>{{ customer.id }}</td>
          <td>{{ customer.name }}</td>
          <td>{{ customer.email }}</td>
          <td>{{ customer.cpf }}</td>
          <td>
            <div>
              <p>{{ customer.neighborhood }}</p>
              <div v-if="customer.showMore">
                <p>{{ customer.street }}, {{ customer.number }}</p>
                <p>{{ customer.complement }}</p>
                <p>{{ customer.city }} - {{ customer.state }}</p>
              </div>
              <p class="showMore" @click="toggleShowMore(customer)">
                {{ customer.showMore ? 'Ver menos' : 'Ver mais' }}
              </p>
            </div>
          </td>
          <td>
            <div class="buttons">
              <button>Edit</button>
              <button>Delete</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </main>
</template>

<script>
import CustomerService from '../services/Customers/CustomerService'

export default {
  data() {
    return {
      customers: []
    }
  },

  mounted() {
    this.getAllCustomers()
  },

  methods: {
    getAllCustomers() {
      CustomerService.getAllCustomers()
        .then((response) => {
          this.customers = response.map((customer) => ({ ...customer, showMore: false }))
        })
        .catch((e) => {
          console.log(e)
        })
    },
    toggleShowMore(customer) {
      customer.showMore = !customer.showMore
    }
  }
}
</script>

<style>
h1 {
  color: #1f5d82;
  margin: 40px 0px 20px;
  margin-left: 24px;
}

.buttons {
  display: flex;
  justify-content: center;
  gap: 20px;
  align-items: center;
  margin: 24px;
}

.customersList {
  width: 100%;
  max-width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
  overflow: scroll;
  margin-bottom: 20px;
}

.customersList tr {
  border: 1px solid #dddddd;
  border-left: none;
  border-right: none;
}

.customersList th,
.customersList td {
  padding: 14px;
  text-align: center;
  color: #1f5d82;
}

.customersList td {
  color: #353535;
}

.customersList thead tr {
  border: none;
}

.customersList tbody tr:nth-child(even) {
  background-color: #f1f1f1;
}

button {
  height: 35px;
  padding: 0px 20px;
  background-color: #fdfdfd;

  color: #353535;
  font-weight: 600;
  font-size: 0.9rem;
  border: 1px solid #c0c0c0;
  border-radius: 4px;
}

button:hover {
  background-color: #1f5d82;
  padding: 0px 21px;
  color: white;
  border: none;
}

.showMore {
  color: #1f5d82;
  cursor: pointer;
  margin-top: 10px;
  font-size: 0.9rem;
  font-weight: 600;
}

.align-end {
  display: flex;
  justify-content: flex-end;
  margin-right: 24px;
}
</style>
