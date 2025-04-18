import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'

import { Places } from '@/lib/types'
import { DataTableSkeleton } from './table-skeleton'

export function PlacesTable({
  places,
  loading,
}: {
  places?: Places[]
  loading: boolean
}) {
  if (loading) {
    return <DataTableSkeleton className="mt-10" rowCount={10} columnCount={5} />
  }

  if (!places || places.length < 1) {
    return (
      <div className="text-muted-foreground w-full text-center mt-10">
        Nenhum item encontrado.
      </div>
    )
  }

  return (
    <>
      <p className="py-10">Total de registros: {places.length}</p>
      <Table>
        <TableCaption>Total de registros: {places.length}</TableCaption>

        <TableHeader>
          <TableRow>
            <TableHead className="w-[100px]">Id</TableHead>
            <TableHead>Nome</TableHead>
            <TableHead>Telefone</TableHead>
            <TableHead>Categoria</TableHead>
            <TableHead>Endereço</TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          {places.map((place, i) => (
            <TableRow key={i}>
              <TableCell className="font-medium">{i}</TableCell>
              <TableCell className="font-medium">{place.title}</TableCell>
              <TableCell>{place.phoneNumber}</TableCell>
              <TableCell>{place.category}</TableCell>
              <TableCell>{place.address}</TableCell>
            </TableRow>
          ))}
        </TableBody>
      </Table>
    </>
  )
}
