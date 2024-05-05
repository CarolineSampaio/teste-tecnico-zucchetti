import * as yup from 'yup'

export const schemaCreatePayment = yup.object().shape({
  name: yup
    .string()
    .required('Name is required')
    .min(3, 'Name must be at least 3 characters')
    .max(100, 'Name must be at most 100 characters'),
  max_installments: yup
    .number('Max installments must be a number')
    .required('Max installments is required')
    .min(1, 'Max installments must be at least 1')
})
