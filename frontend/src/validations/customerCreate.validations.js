import * as yup from 'yup'

export const schemaCreateCustomer = yup.object().shape({
  name: yup
    .string()
    .required('Name is required')
    .min(6, 'Name must be at least 6 characters')
    .max(100, 'Name must be at most 100 characters'),
  email: yup
    .string()
    .email('Email invalid')
    .required('Email is required')
    .max(100, 'Email must be at most 100 characters'),
  cpf: yup
    .string()
    .matches(/^\d{3}\.\d{3}\.\d{3}-\d{2}$/, 'CPF invalid (xxx.xxx.xxx-xx)')
    .max(14, 'CPF must be at most 14 characters')
    .required('CPF is required'),
  cep: yup
    .string()
    .matches(/^\d{5}\d{3}$/, 'CEP invalid (xxxxxxxx)')
    .max(8, 'CEP must be at most 8 characters')
    .required('CEP is required'),
  street: yup
    .string()
    .required('Street is required')
    .max(100, 'Street must be at most 100 characters'),
  number: yup
    .string()
    .required('Number is required')
    .max(10, 'Number must be at most 10 characters'),
  complement: yup
    .string()
    .required('Complement is required')
    .max(100, 'Complement must be at most 100 characters'),
  neighborhood: yup
    .string()
    .required('Neighborhood is required')
    .max(100, 'Neighborhood must be at most 100 characters'),
  city: yup.string().required('City is required').max(100, 'City must be at most 100 characters'),
  state: yup.string().required('State is required').max(2, 'State must be at most 2 characters')
})
