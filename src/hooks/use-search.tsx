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
          q,
          gl,
          location,
          hl: 'pt-br',
          page: i,
          autocorrect: false,
        }

        requests.push(api.post(query, p))
      }

      const responses = await Promise.all(requests)
      const allPlaces: Places[] = responses.flatMap(
        (response) => response.data.places,
      )

      await saveLeads({ leads: allPlaces })

      return allPlaces as Places[]
    },
  })

  return { places, isFetching, isPending, setPayload }
}
