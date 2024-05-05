<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <h1>{{ productId ? 'Edit Product' : 'New Product' }}</h1>
  <main class="content">
    <form @submit.prevent="handleSubmit" class="formNew">
      <div class="formElement">
        <div>
          <label for="name">Name</label>
          <input
            id="name"
            v-model="product.name"
            class="formInput"
            :class="{ inputError: this.errors.name }"
          />
          <span class="textError">{{ errors.name }}</span>
        </div>
      </div>

      <div class="formElement">
        <div>
          <label for="quantity">Quantity</label>
          <input
            id="quantity"
            v-model="product.quantity"
            class="formInput"
            :class="{ inputError: this.errors.quantity }"
          />
          <span class="textError">{{ errors.quantity }}</span>
        </div>
        <div>
          <label for="price">Price</label>
          <input
            id="price"
            v-model="product.price"
            class="formInput"
            :class="{ inputError: this.errors.price }"
          />
          <span class="textError">{{ errors.price }}</span>
        </div>
      </div>

      <div class="buttons">
        <router-link to="/products"><button>Back</button></router-link>
        <button type="submit">{{ productId ? 'Edit' : 'Register' }}</button>
      </div>
    </form>
  </main>
</template>

<script>
import * as yup from 'yup'
import { captureErrorYup } from '@/utils/captureErrorYup'
import { schemaCreateProduct } from '@/validations/productCreate.validations.js'

import ProductService from '@/services/ProductService'

export default {
  data() {
    return {
      product: {
        name: '',
        quantity: null,
        price: null
      },
      errors: {},

      productId: this.$route?.params?.id
    }
  },
  mounted() {
    if (this.productId) {
      this.getProduct()
    }
  },

  methods: {
    getProduct() {
      ProductService.getOne(this.productId)
        .then((response) => {
          this.product = response
        })
        .catch((error) => {
          console.log(error)
        })
    },

    validateSync() {
      this.errors = {}
      try {
        schemaCreateProduct.validateSync(this.product, { abortEarly: false })

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

        if (this.productId) {
          ProductService.updateOne(this.productId, this.product)
            .then(() => {
              this.errors = {}
              alert('Product updated successfully!')
            })
            .catch((error) => {
              alert('Error updating product!')
              console.log(error)
            })
          return
        }

        ProductService.createOne(this.product)
          .then(() => {
            this.errors = {}
            alert('Product registered successfully!')
            this.product = {
              name: '',
              quantity: '',
              price: ''
            }
          })
          .catch((error) => {
            alert('Error registering product!')
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

.formInput {
  height: 38px;
  width: 100%;
  border-radius: 4px;
  border: 1px solid #dddddd;
  outline: none;
  background-color: rgb(250, 250, 250);
  font-size: 14px;
  padding-left: 8px;
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
  color: red;
  font-size: 12px;
}
</style>
