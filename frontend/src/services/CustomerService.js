import api from './api'

class CustomerService {
  async createOne(body) {
    const response = await api.post('customers', body)
    return response.data
  }

  async getAllCustomers() {
    const response = await api.get('customers')
    return response.data
  }

  async getOne(id) {
    const response = await api.get(`customers?id=${id}`)
    return response.data
  }

  async updateOne(id, body) {
    const response = await api.put(`customers?id=${id}`, body)
    return response.data
  }

  async deleteOne(id) {
    const response = await api.delete(`customers?id=${id}`)
    return response.data
  }
}

export default new CustomerService()
