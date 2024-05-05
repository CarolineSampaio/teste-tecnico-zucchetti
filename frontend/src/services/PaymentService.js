import api from './api'

class PaymentService {
  async createOne(body) {
    const response = await api.post('payments', body)
    return response.data
  }

  async getAllPayments() {
    const response = await api.get('payments')
    return response.data
  }

  async getOne(id) {
    const response = await api.get(`payments?id=${id}`)
    return response.data
  }

  async updateOne(id, body) {
    const response = await api.put(`payments?id=${id}`, body)
    return response.data
  }

  async deleteOne(id) {
    const response = await api.delete(`payments?id=${id}`)
    return response.data
  }
}

export default new PaymentService()
