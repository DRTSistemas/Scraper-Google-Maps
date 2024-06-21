import axios, { type AxiosInstance } from 'axios'

const myHeaders = new Headers()
myHeaders.append('X-API-KEY', '270abb142856aa8d6d180b9ed3e12f303d5be21e')
myHeaders.append('Content-Type', 'application/json')

const api: AxiosInstance = axios.create({
  baseURL: 'https://google.serper.dev',
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'X-API-KEY': '270abb142856aa8d6d180b9ed3e12f303d5be21e',
  },
})

export default api
