'use client'

import { useSearch } from '@/hooks/use-search'
import { PlacesTable } from './places-table'
import { SearchForm } from './search-form'

import { Button, buttonVariants } from '@/components/ui/button'
import { Role } from '@/lib/types'
import { LogOut } from 'lucide-react'
import { SubmitButton } from '@/components/submit-button'
import { logout } from '@/lib/auth/actions'
import Link from 'next/link'
import { cn } from '@/lib/utils'

interface PlacesProps {
  userId: string
  requestsToday: number
  role: Role
}

export function Places({ userId, requestsToday, role }: PlacesProps) {
  const { places, setPayload, isFetching } = useSearch()

  return (
    <>
      {role === 'ADMIN' && (
        <div className="h-12 bg-primary flex items-center">
          <Link
            className={cn(
              buttonVariants({ variant: 'link' }),
              'text-white ml-auto',
            )}
            href={'/painel'}
          >
            Painel
          </Link>
        </div>
      )}
      <div className="grid items-center pb-8 pt-6 md:py-8 mx-auto px-4 max-w-6xl gap-0">
        <div className="flex md:flex-row items-start gap-4 justify-between flex-col-reverse">
          <h1 className="text-2xl font-bold leading-[1.1] md:text-3xl">
            Parâmetros de pesquisa
          </h1>
          <div className="flex gap-2 flex-col items-start">
            <div className="flex gap-2">
              <Button>Como usar o InfoLead?</Button>
              <form action={logout}>
                <SubmitButton variant={'outline'}>
                  Sair <LogOut className="size-4 ml-2" />
                </SubmitButton>
              </form>
            </div>
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
    </>
  )
}
