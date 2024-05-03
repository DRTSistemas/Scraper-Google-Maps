import axios, { type AxiosInstance } from 'axios'

const myHeaders = new Headers()
myHeaders.append('X-API-KEY', 'd4e4f4a84f697cc3f93fdc116fb210befc88e099')
myHeaders.append('Content-Type', 'application/json')

const api: AxiosInstance = axios.create({
  baseURL: 'https://google.serper.dev',
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'X-API-KEY': 'd4e4f4a84f697cc3f93fdc116fb210befc88e099',
  },
})

export default api
