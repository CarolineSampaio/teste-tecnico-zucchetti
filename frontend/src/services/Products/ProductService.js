import api from '../api'

class ProductService {
  async createOne(body) {
    const response = await api.post('products', body)
    return response.data
  }

  async getAllproducts() {
    const response = await api.get('products')
    return response.data
  }

  async getOne(id) {
    const response = await api.get(`products?id=${id}`)
    return response.data
  }

  async updateOne(id, body) {
    const response = await api.put(`products?id=${id}`, body)
    return response.data
  }

  async deleteOne(id) {
    const response = await api.delete(`products?id=${id}`)
    return response.data
  }
}

export default new ProductService()
