import * as yup from 'yup'

export const schemaCreateOrder = yup.object().shape({
  customer_id: yup.number().required('Customer Name is required'),
  payment_id: yup.number().required('Payment method is required'),
  installments: yup.number().required('Installments is required'),
  products: yup.array().required('Products is required').min(1, 'Add at least 1 product')
})
