import api from '../api'

class CustomerService {
  async createOne(body) {
    const response = await api.post('customers', body)
    return response.data
  }

  async getAllCustomers() {
    const response = await api.get('customers')
    return response.data
  }
}

export default new CustomerService()
