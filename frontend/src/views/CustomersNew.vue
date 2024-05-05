<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <main>
    <h1>{{ customerId ? 'Edit Customer' : 'New Customer' }}</h1>

    <form @submit.prevent="handleSubmit" class="formNew">
      <div class="formElement">
        <div>
          <label for="name">Full Name</label>
          <input
            id="name"
            v-model="customer.name"
            class="formInput"
            :class="{ inputError: this.errors.name }"
          />
          <span class="textError">{{ errors.name }}</span>
        </div>
        <div>
          <label for="cpf">CPF</label>
          <input
            id="cpf"
            v-model="customer.cpf"
            class="formInput"
            :class="{ inputError: this.errors.cpf }"
          />
          <span class="textError">{{ errors.cpf }}</span>
        </div>
      </div>
      <div class="formElement">
        <div>
          <label for="email">Email</label>
          <input
            id="email"
            v-model="customer.email"
            class="formInput"
            :class="{ inputError: this.errors.email }"
          />
          <span class="textError">{{ errors.email }}</span>
        </div>
      </div>

      <div class="formElement">
        <div>
          <label for="cep">CEP</label>
          <input
            id="cep"
            v-model="customer.cep"
            class="formInput"
            @keyup="getAddressInfo"
            :class="{ inputError: this.errors.cep }"
          />
          <span class="textError">{{ errors.cep }}</span>
        </div>
      </div>

      <div class="formElement">
        <div>
          <label for="street">Street</label>
          <input
            id="street"
            v-model="customer.street"
            class="formInput"
            :readonly="addressRequested"
            :class="{ inputError: this.errors.street }"
          />
          <span class="textError">{{ errors.street }}</span>
        </div>
        <div>
          <label for="number">Number</label>
          <input
            id="number"
            v-model="customer.number"
            class="formInput"
            :class="{ inputError: this.errors.number }"
          />
          <span class="textError">{{ errors.number }}</span>
        </div>
        <div>
          <label for="complement">Complement</label>
          <input
            id="complement"
            v-model="customer.complement"
            class="formInput"
            :class="{ inputError: this.errors.complement }"
          />
          <span class="textError">{{ errors.complement }}</span>
        </div>
      </div>

      <div class="formElement">
        <div>
          <label for="neighborhood">Neighborhood</label>
          <input
            id="neighborhood"
            v-model="customer.neighborhood"
            class="formInput"
            :readonly="addressRequested"
            :class="{ inputError: this.errors.neighborhood }"
          />
          <span class="textError">{{ errors.neighborhood }}</span>
        </div>
        <div>
          <label for="city">City</label>
          <input
            id="city"
            v-model="customer.city"
            class="formInput"
            :readonly="addressRequested"
            :class="{ inputError: this.errors.city }"
          />
          <span class="textError">{{ errors.city }}</span>
        </div>
        <div>
          <label for="state">State</label>
          <input
            id="state"
            v-model="customer.state"
            class="formInput"
            :readonly="addressRequested"
            :class="{ inputError: this.errors.state }"
          />
          <span class="textError">{{ errors.state }}</span>
        </div>
      </div>

      <div class="buttons">
        <router-link to="/"><button>Back</button></router-link>
        <button type="submit">{{ customerId ? 'Edit' : 'Register' }}</button>
      </div>
    </form>
  </main>
</template>

<script>
import * as yup from 'yup'
import { captureErrorYup } from '@/utils/captureErrorYup'
import { schemaCreateCustomer } from '@/validations/customerCreate.validations.js'

import CustomerService from '@/services/Customers/CustomerService'
import axios from 'axios'

export default {
  data() {
    return {
      customer: {
        name: '',
        email: '',
        cpf: '',
        cep: '',
        street: '',
        number: '',
        complement: '',
        neighborhood: '',
        city: '',
        state: ''
      },
      addressRequested: false,
      errors: {},

      customerId: this.$route?.params?.id
    }
  },
  mounted() {
    if (this.customerId) {
      this.getCustomer()
    }
  },
  methods: {
    getCustomer() {
      CustomerService.getOne(this.customerId)
        .then((response) => {
          this.customer = response
          console.log(response)
        })
        .catch((error) => {
          console.log(error)
        })
    },

    validateSync() {
      this.errors = {}
      try {
        schemaCreateCustomer.validateSync(this.customer, { abortEarly: false })

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

        if (this.customerId) {
          CustomerService.updateOne(this.customerId, this.customer)
            .then(() => {
              this.errors = {}
              alert('Customer updated successfully!')
            })
            .catch((error) => {
              alert('Error updating customer!')
              console.log(error)
            })
          return
        }

        CustomerService.createOne(this.customer)
          .then(() => {
            this.errors = {}
            alert('Customer registered successfully!')
            this.customer = {
              name: '',
              email: '',
              cpf: '',
              cep: '',
              street: '',
              number: '',
              complement: '',
              neighborhood: '',
              city: '',
              state: ''
            }
          })
          .catch((error) => {
            alert('Error registering customer!')
            console.log(error)
          })
      } catch (error) {
        if (error instanceof yup.ValidationError) {
          this.errors = captureErrorYup(error)
        }
      }
    },

    getAddressInfo() {
      const cep = this.customer.cep

      if (cep.length === 8) {
        axios
          .get(`https://viacep.com.br/ws/${cep}/json/`)
          .then(({ data }) => {
            console.log(data)
            if (data.erro) return
            this.customer.street = data.logradouro
            this.customer.neighborhood = data.bairro
            this.customer.city = data.localidade
            this.customer.state = data.uf
            this.addressRequested = true
            this.validateSync()
          })
          .catch((error) => {
            alert(`Error when querying the CEP: ${cep}`)
            console.log(error)
          })
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
