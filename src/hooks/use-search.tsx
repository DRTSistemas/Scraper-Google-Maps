import { saveLeads } from '@/actions/drt'
import api from '@/lib/api'
import { Api, Places } from '@/lib/types'
import { useQuery } from '@tanstack/react-query'
import React from 'react'

export function useSearch() {
  const [payload, setPayload] = React.useState<Api | null>(null)

  const {
    data: places,
    isFetching,
    isPending,
  } = useQuery({
    queryKey: ['places', payload],
    enabled: !!payload?.q,
    queryFn: async () => {
      if (!payload) {
        throw new Error('Payload não definido')
      }

      const { q, gl, location } = payload
      const requests = []

      for (let i = 1; i <= 20; i++) {
        const query = `/places`
        const p = {
          q: `${q} ${location}`,
          gl,
          hl: 'pt-br',
          page: i,
        }

        requests.push(api.post(query, p))
      }

      const responses = await Promise.all(requests)
      const allPlaces: Places[] = responses.flatMap(
        (response) => response.data.places,
      )

      const filteredPlaces = allPlaces.filter((place) => place.phoneNumber)

      await saveLeads({ leads: filteredPlaces })

      return filteredPlaces as Places[]
    },
  })

  return { places, isFetching, isPending, setPayload }
}
