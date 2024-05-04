import api from '../api'

class CustomerService {
  async getAllCustomers() {
    const response = await api.get('customers')
    return response.data
  }
}

export default new CustomerService()
