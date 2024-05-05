<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <main>
    <h1>{{ paymentId ? 'Edit Payment Method' : 'New Payment Method' }}</h1>

    <form @submit.prevent="handleSubmit" class="formNew">
      <div class="formElement">
        <div>
          <label for="name">Name</label>
          <input
            id="name"
            v-model="payment.name"
            class="formInput"
            :class="{ inputError: this.errors.name }"
          />
          <span class="textError">{{ errors.name }}</span>
        </div>
      </div>

      <div class="formElement">
        <div>
          <label for="max_installments">Max Installments</label>
          <input
            id="max_installments"
            v-model="payment.max_installments"
            class="formInput"
            :class="{ inputError: this.errors.max_installments }"
          />
          <span class="textError">{{ errors.max_installments }}</span>
        </div>
      </div>

      <div class="buttons">
        <router-link to="/payments"><button>Back</button></router-link>
        <button type="submit">{{ paymentId ? 'Edit' : 'Register' }}</button>
      </div>
    </form>
  </main>
</template>

<script>
import * as yup from 'yup'
import { captureErrorYup } from '@/utils/captureErrorYup'
import { schemaCreatePayment } from '@/validations/paymentCreate.validations.js'

import PaymentService from '@/services/PaymentService'

export default {
  data() {
    return {
      payment: {
        name: '',
        max_installments: null
      },
      errors: {},

      paymentId: this.$route?.params?.id
    }
  },
  mounted() {
    if (this.paymentId) {
      this.getPayment()
    }
  },

  methods: {
    getPayment() {
      PaymentService.getOne(this.paymentId)
        .then((response) => {
          this.payment = response
        })
        .catch((error) => {
          console.log(error)
        })
    },

    validateSync() {
      this.errors = {}
      try {
        schemaCreatePayment.validateSync(this.payment, { abortEarly: false })

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

        if (this.paymentId) {
          PaymentService.updateOne(this.paymentId, this.payment)
            .then(() => {
              this.errors = {}
              alert('Payment method updated successfully!')
            })
            .catch((error) => {
              alert('Error updating payment method!')
              console.log(error)
            })
          return
        }

        PaymentService.createOne(this.payment)
          .then(() => {
            this.errors = {}
            alert('Payment method registered successfully!')
            this.payment = {
              name: '',
              max_installments: ''
            }
          })
          .catch((error) => {
            alert('Error registering payment method!')
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
