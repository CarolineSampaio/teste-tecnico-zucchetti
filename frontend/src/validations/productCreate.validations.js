import * as yup from 'yup'

export const schemaCreateProduct = yup.object().shape({
  name: yup
    .string()
    .required('Name is required')
    .min(3, 'Name must be at least 6 characters')
    .max(100, 'Name must be at most 100 characters'),
  quantity: yup
    .number('Quantity must be a number')
    .required('Quantity is required')
    .min(1, 'Quantity must be at least 1'),
  price: yup
    .number('Quantity must be a number')
    .min(0.01, 'Price must be at least 0.01')
    .required('Price is required')
})
