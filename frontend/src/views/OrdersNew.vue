<template>
  <h1>{{ orderId ? 'Edit Order' : 'New Order' }}</h1>
  <main class="content">
    <form @submit.prevent="handleSubmit" class="formNew">
      <div class="formElement">
        <div>
          <label for="name">Customer Name</label>
          <select
            v-model="order.customer_id"
            class="formInput"
            :class="{ inputError: this.errors.customer_id }"
          >
            <option v-for="customer in customers" :key="customer.id" :value="customer.id">
              {{ customer.name }}
            </option>
          </select>
          <span class="textError">{{ errors.customer_id }}</span>
        </div>
      </div>

      <div class="formElement">
        <div>
          <label for="payment">Payment Method</label>
          <select
            v-model="order.payment_id"
            class="formInput"
            :class="{ inputError: this.errors.payment_id }"
            @change="updateMaxInstallments"
          >
            <option v-for="payment in payments" :key="payment.id" :value="payment.id">
              {{ payment.name }}
            </option>
          </select>
          <span class="textError">{{ errors.payment_id }}</span>
        </div>
        <div>
          <label for="installments">Installments</label>
          <select
            v-model="order.installments"
            class="formInput"
            :class="{ inputError: this.errors.installments }"
          >
            <option v-for="installment in maxInstallments" :key="installment">
              {{ installment }}
            </option>
          </select>
          <span class="textError">{{ errors.installments }}</span>
        </div>
      </div>

      <div>
        <label>Products</label>
        <span class="textError">{{ errors.products }}</span>
        <table class="productsList" :class="{ 'disabled-table': orderId }">
          <thead>
            <tr>
              <th>Name</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="product in products" :key="product.id">
              <td>{{ product.name }}</td>
              <td>
                <select
                  v-model="product.selectedQuantity"
                  @change="updateQuantity(product), addProductToOrder(product)"
                  class="selectInput"
                  :class="{ inputError: this.errors.products }"
                >
                  <option value="0" selected>0</option>
                  <option
                    v-for="quantity in availableQuantities(product)"
                    :key="quantity"
                    :value="quantity"
                  >
                    {{ quantity }}
                  </option>
                </select>
              </td>
              <td>{{ product.price }}</td>
              <td>{{ product.selectedQuantity > 0 ? calculateSubtotal(product) : '' }}</td>
            </tr>
          </tbody>

          <tfoot>
            <tr>
              <td colspan="12">Total:{{ total }}</td>
            </tr>
          </tfoot>
        </table>
      </div>

      <div class="buttons">
        <router-link to="/orders"><button>Back</button></router-link>
        <button type="submit">{{ orderId ? 'Edit' : 'Register' }}</button>
      </div>
    </form>
  </main>
</template>

<script>
import * as yup from 'yup'
import { captureErrorYup } from '@/utils/captureErrorYup'
import { schemaCreateOrder } from '@/validations/orderCreate.validations.js'

import OrderService from '@/services/OrderService'
import CustomerService from '@/services/CustomerService'
import PaymentService from '@/services/PaymentService'
import ProductService from '@/services/ProductService'

export default {
  data() {
    return {
      order: {
        customer_id: null,
        payment_id: null,
        installments: null,
        products: []
      },
      customers: [],
      payments: [],
      maxInstallments: [],
      products: [],
      errors: {},

      orderId: this.$route?.params?.id
    }
  },
  mounted() {
    this.getAllCustomers()
    this.getAllPayments()
    this.getAllProducts()

    if (this.orderId) {
      this.getOrder()
    }
  },

  computed: {
    showSubtotalColumn() {
      return this.products.some((product) => product.selectedQuantity > 0)
    },

    total() {
      const rawTotal = this.products.reduce((acc, product) => {
        if (!isNaN(product.selectedQuantity) && parseFloat(product.selectedQuantity) > 0) {
          const priceNumeric = parseFloat(product.price.replace('R$', '').replace(',', '.'))

          const subtotal = product.selectedQuantity * priceNumeric

          acc += subtotal
        }
        return acc
      }, 0)

      return this.formatPrice(rawTotal)
    }
  },

  methods: {
    getAllCustomers() {
      CustomerService.getAllCustomers()
        .then((response) => {
          this.customers = response
        })
        .catch((e) => {
          console.log(e)
        })
    },

    getAllPayments() {
      PaymentService.getAllPayments()
        .then((response) => {
          this.payments = response
        })
        .catch((error) => {
          console.log(error)
        })
    },
    updateMaxInstallments() {
      const selectedPayment = this.payments.find((payment) => payment.id === this.order.payment_id)
      if (selectedPayment) {
        const maxInstallments = Array.from(
          { length: selectedPayment.max_installments },
          (_, index) => index + 1
        )
        this.maxInstallments = maxInstallments
      }
    },

    getAllProducts() {
      ProductService.getAllProducts()
        .then((response) => {
          for (let i = 0; i < response.length; i++) {
            response[i].price = this.formatPrice(response[i].price)
          }
          this.products = response.map((product) => ({
            ...product,
            selectedQuantity: 0
          }))
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

    availableQuantities(product) {
      return Array.from({ length: product.quantity }, (_, i) => i + 1)
    },
    updateQuantity(product) {
      product.selectedQuantity = parseInt(product.selectedQuantity)
    },
    calculateSubtotal(product) {
      const priceNumeric = parseFloat(product.price.replace('R$', '').replace(',', '.'))
      const subtotal = product.selectedQuantity * priceNumeric
      return this.formatPrice(subtotal)
    },

    addProductToOrder(product) {
      if (product.selectedQuantity > 0) {
        const existingProductIndex = this.order.products.findIndex(
          (p) => p.product_id === product.id
        )
        if (existingProductIndex !== -1) {
          this.order.products[existingProductIndex].quantity = product.selectedQuantity
        } else {
          this.order.products.push({
            product_id: product.id,
            quantity: product.selectedQuantity
          })
        }
      } else {
        const index = this.order.products.findIndex((p) => p.product_id === product.id)
        if (index !== -1) {
          this.order.products.splice(index, 1)
        }
      }
    },

    getOrder() {
      OrderService.getOne(this.orderId)
        .then((response) => {
          this.order.customer_id = response.customer_id
          this.order.payment_id = response.payment_id
          this.updateMaxInstallments()
          this.order.installments = response.installments

          this.order.products = response.products.map((product) => ({
            product_id: product.product_id,
            quantity: product.quantity
          }))

          this.products.forEach((product) => {
            const orderProduct = this.order.products.find(
              (orderProduct) => orderProduct.product_id === product.id
            )
            if (orderProduct) product.selectedQuantity = orderProduct.quantity
          })
        })
        .catch((error) => {
          console.log(error)
        })
    },

    validateSync() {
      this.errors = {}
      try {
        schemaCreateOrder.validateSync(this.order, { abortEarly: false })

        this.errors = {}
      } catch (error) {
        if (error instanceof yup.ValidationError) {
          console.log(error)
          this.errors = captureErrorYup(error)
          return false
        }
      }
      return true
    },

    handleSubmit() {
      try {
        if (this.validateSync() === false) return
        this.order.installments = parseInt(this.order.installments)

        if (this.orderId) {
          OrderService.updateOne(this.orderId, this.order)
            .then(() => {
              this.errors = {}
              alert('Order updated successfully!')
            })
            .catch((error) => {
              alert('Error updating order!')
              console.log(error)
            })
          return
        }

        OrderService.createOne(this.order)
          .then(() => {
            this.errors = {}
            alert('Order registered successfully!')
            this.products.forEach((product) => {
              product.selectedQuantity = 0
            })
            this.order = {
              customer_id: null,
              payment_id: null,
              installments: null,
              products: []
            }
          })
          .catch((error) => {
            alert('Error registering order!')
            console.log(error)
          })
      } catch (error) {
        if (error instanceof yup.ValidationError) {
          this.errors = captureErrorYup(error)
        }
      }
    }
  }
}
</script>

<style scoped>
.formNew {
  display: flex;
  flex-direction: column;
  width: 100%;
}

.formElement {
  display: flex;
  flex-direction: row;
  margin-bottom: 1rem;
  gap: 20px;
}

.formElement div {
  display: flex;
  flex-direction: column;
  width: 100%;
  gap: 5px;
}

.formInput,
.selectInput {
  height: 38px;
  width: 100%;
  border-radius: 4px;
  border: 1px solid #dddddd;
  outline: none;
  background-color: rgb(250, 250, 250);
  font-size: 14px;
  padding-left: 8px;
}

.selectInput {
  text-align: center;
}

a,
router-link {
  text-decoration: none;
  color: inherit;
}

a:hover,
router-link:hover {
  color: inherit;
}

a:visited,
router-link:visited {
  color: inherit;
}

.inputError {
  border-color: red;
}

.textError {
  display: block;
  color: red;
  font-size: 12px;
}

.productsList {
  width: 100%;
  max-width: 100%;
  border-collapse: collapse;
  overflow: scroll;
  margin: 0px;
}

.productsList tr {
  border: 1px solid #dddddd;
  border-left: none;
  border-right: none;
}

.productsList th,
.productsList td {
  padding: 10px;
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

.productsList tfoot tr td {
  background-color: #f1f1f1;
  color: #1f5d82;
  font-size: 1.2rem;
  font-weight: 700;
  padding: 20px 0px;
}

.disabled-table {
  pointer-events: none;
  opacity: 0.5;
}
</style>
