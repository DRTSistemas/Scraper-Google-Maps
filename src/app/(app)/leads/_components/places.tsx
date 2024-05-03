'use client'

import { useSearch } from '@/hooks/use-search'
import { PlacesTable } from './places-table'
import { SearchForm } from './search-form'

import { Button } from '@/components/ui/button'
import { Role } from '@/lib/types'

interface PlacesProps {
  userId: string
  requestsToday: number
  role: Role
}

export function Places({ userId, requestsToday, role }: PlacesProps) {
  const { places, setPayload, isFetching } = useSearch()

  return (
    <div className="grid items-center pb-8 pt-6 md:py-8 mx-auto px-4 max-w-6xl gap-0">
      <div className="flex md:flex-row items-start gap-4 justify-between flex-col-reverse">
        <h1 className="text-2xl font-bold leading-[1.1] md:text-3xl">
          Parâmetros de pesquisa
        </h1>
        <div className="flex gap-2 items-center">
          <Button>Como usar o InfoLead?</Button>
        </div>
      </div>
      <SearchForm
        role={role}
        requestsToday={requestsToday}
        userId={userId}
        laoding={isFetching}
        setPayload={setPayload}
        places={places}
      />
      <PlacesTable loading={isFetching} places={places} />
    </div>
  )
}
