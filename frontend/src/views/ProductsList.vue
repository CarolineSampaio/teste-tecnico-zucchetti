<template>
  <main>
    <h1>Products List</h1>

    <div class="align-end">
      <router-link to="/product/new">
        <button>New Product</button>
      </router-link>
    </div>

    <table class="productsList">
      <thead>
        <tr>
          <th>Id</th>
          <th>Name</th>
          <th>Quantity</th>
          <th>Price</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="corpoTabela">
        <tr v-for="product in products" :key="product.id">
          <td>{{ product.id }}</td>
          <td>{{ product.name }}</td>
          <td>{{ product.quantity }}</td>
          <td>{{ product.price }}</td>
          <td>
            <div class="buttons">
              <router-link :to="`/product/${product.id}/edit`">
                <button>Edit</button>
              </router-link>

              <button @click="deleteProduct(product.id)">Delete</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </main>
</template>

<script>
import ProductService from '@/services/ProductService'

export default {
  data() {
    return {
      products: []
    }
  },

  mounted() {
    this.getProducts()
  },

  methods: {
    getProducts() {
      ProductService.getAllProducts()
        .then((response) => {
          for (let i = 0; i < response.length; i++) {
            response[i].price = this.formatPrice(response[i].price)
          }

          this.products = response
        })
        .catch((error) => {
          console.log(error)
        })
    },
    formatPrice(price) {
      return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL'
      }).format(price)
    },

    deleteProduct(id) {
      ProductService.deleteOne(id)
        .then(() => {
          this.getProducts()
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

.productsList {
  width: 100%;
  max-width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
  overflow: scroll;
  margin-bottom: 20px;
}

.productsList tr {
  border: 1px solid #dddddd;
  border-left: none;
  border-right: none;
}

.productsList th,
.productsList td {
  padding: 14px;
  text-align: center;
  color: #1f5d82;
}

.productsList td {
  color: #353535;
}

.productsList thead tr {
  border: none;
}

.productsList tbody tr:nth-child(even) {
  background-color: #f1f1f1;
}

.align-end {
  display: flex;
  justify-content: flex-end;
  margin-right: 24px;
}
</style>
