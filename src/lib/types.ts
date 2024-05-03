export type Places = {
  position: number
  title: string
  address: string
  latitude: number
  longitude: number
  rating: number
  ratingCount: number
  category: string
  phoneNumber: string
  cid: string
}

export type Res = {
  places: Places[]
  searchParameters: undefined
}

export type Api = {
  q: string
  gl: string
  location?: string
}

export type Role = 'ADMIN' | 'SOCIO' | 'MEMBER'
