import api from './api'

class OrderService {
  async createOne(body) {
    const response = await api.post('orders', body)
    return response.data
  }

  async getAllOrders() {
    const response = await api.get('orders')
    return response.data
  }

  async getOne(id) {
    const response = await api.get(`orders?id=${id}`)
    return response.data
  }

  async updateOne(id, body) {
    const response = await api.put(`orders?id=${id}`, body)
    return response.data
  }

  async deleteOne(id) {
    const response = await api.delete(`orders?id=${id}`)
    return response.data
  }
}

export default new OrderService()
