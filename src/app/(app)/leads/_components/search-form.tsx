import { zodResolver } from '@hookform/resolvers/zod'
import { useForm } from 'react-hook-form'
import { z } from 'zod'
import { Loader2 } from 'lucide-react'
import XLSX from 'xlsx'

import { Button } from '@/components/ui/button'
import {
  Form,
  FormControl,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from '@/components/ui/form'
import { Input } from '@/components/ui/input'
import { DownloadIcon } from '@radix-ui/react-icons'

import React from 'react'
import { Api, Places, Role } from '@/lib/types'
import { clearString } from '@/lib/utils'
import { toast } from 'sonner'
import { addNewResquest } from '@/actions/places'
/*
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import { COUNTRIES, NEIGHBORHOOD, STATES, CITIES } from '@/lib/constants'
*/
const schema = z.object({
  subject: z.string().min(1, { message: 'Digite uma categoria.' }),
  state: z.string().optional(),
  country: z.string().min(1, { message: 'Digite um país.' }),
  city: z.string().optional(),
  neighborhood: z.string().optional(),
})

interface SearchFormProps {
  setPayload: React.Dispatch<React.SetStateAction<Api | null>>
  laoding: boolean
  places: Places[] | undefined
  userId: string
  requestsToday: number
  role: Role
}

export function SearchForm({
  setPayload,
  laoding,
  places,
  userId,
  role,
  requestsToday,
}: SearchFormProps) {
  const [isLoading, setIsloading] = React.useState<boolean>(false)

  const isAdmin = role === 'ADMIN'
  const isMember = role === 'MEMBER'

  let limitExceeded = false

  if (isAdmin) {
    limitExceeded = false
  } else {
    limitExceeded = isMember ? requestsToday > 0 : requestsToday > 2
  }

  function xlsxExport(places: Places[]) {
    const rows = places.map((item, i) => ({
      id: i,
      nome: item.title,
      telefone: item.phoneNumber,
      categoria: item.category,
      endereco: item.address,
    }))

    const worksheet = XLSX.utils.json_to_sheet(rows)
    const workbook = XLSX.utils.book_new()
    XLSX.utils.book_append_sheet(workbook, worksheet, 'Dates')

    /* fix headers */
    XLSX.utils.sheet_add_aoa(
      worksheet,
      [['Id', 'Nome', 'Telefone', 'Categoria', 'Endereço']],
      {
        origin: 'A1',
      },
    )

    /* calculate column width */
    const maxWidth = rows.reduce((w, r) => Math.max(w, r.nome.length), 10)
    worksheet['!cols'] = [{ wch: maxWidth }]

    /* create an XLSX file and try to save to Presidents.xlsx */
    XLSX.writeFile(
      workbook,
      `lista-${clearString(form.watch('subject'))}.xlsx`,
      { compression: true },
    )
  }

  const form = useForm<z.infer<typeof schema>>({
    resolver: zodResolver(schema),
    defaultValues: {
      subject: '',
      city: '',
      country: '',
      state: '',
      neighborhood: '',
    },
  })

  async function onSubmit(data: z.infer<typeof schema>) {
    setIsloading(true)
    try {
      await addNewResquest({ userId })
      setPayload({
        q: data.subject,
        gl: data.country,
        location: `${data.city}, ${data.state}, ${data.neighborhood}`,
      })
    } catch (err) {
      toast.error('Erro inesperado')
    } finally {
      setIsloading(false)
    }
  }

  return (
    <Form {...form}>
      <form
        onSubmit={form.handleSubmit(onSubmit)}
        className="flex flex-col w-full mt-8"
      >
        <div className="flex flex-col md:flex-row items-start justify-between gap-2 w-full">
          <FormField
            control={form.control}
            name="subject"
            render={({ field }) => (
              <FormItem className="w-full">
                <FormLabel className="font-semibold">Busca</FormLabel>
                <FormControl>
                  <Input placeholder="O que deseja buscar" {...field} />
                </FormControl>
                <FormMessage />
              </FormItem>
            )}
          />
          <FormField
            control={form.control}
            name="country"
            render={({ field }) => (
              <FormItem className="w-full">
                <FormLabel>País</FormLabel>
                <FormControl>
                  <Input placeholder="Digite um país" {...field} />
                </FormControl>
              </FormItem>
            )}
          />
          <FormField
            control={form.control}
            name="state"
            render={({ field }) => (
              <FormItem className="w-full">
                <FormLabel>Estado</FormLabel>
                <FormControl>
                  <Input placeholder="Digite um estado" {...field} />
                </FormControl>
              </FormItem>
            )}
          />
          <FormField
            control={form.control}
            name="city"
            render={({ field }) => (
              <FormItem className="w-full">
                <FormLabel>Cidade</FormLabel>
                <FormControl>
                  <Input placeholder="Digite uma cidade" {...field} />
                </FormControl>
              </FormItem>
            )}
          />

          <FormField
            control={form.control}
            name="neighborhood"
            render={({ field }) => (
              <FormItem className="w-full">
                <FormLabel>Bairro</FormLabel>
                <FormControl>
                  <Input placeholder="Digite um bairro" {...field} />
                </FormControl>
              </FormItem>
            )}
          />
        </div>
        <div className="flex flex-row gap-2 items-center mt-4">
          <Button disabled={limitExceeded} className="w-36" type="submit">
            {laoding || isLoading ? (
              <Loader2
                className="mr-2 size-4 animate-spin"
                aria-hidden="true"
              />
            ) : (
              'Buscar Leads'
            )}
          </Button>
          <Button
            disabled={!places}
            onClick={() => xlsxExport(places!)}
            type="button"
            size="icon"
          >
            <DownloadIcon className="size-4" />
          </Button>
          {isAdmin ? null : <p>Pesquisas restantes: {3 - requestsToday}</p>}
        </div>
      </form>
    </Form>
  )
}
