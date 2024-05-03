import { cn } from '@/lib/utils'
import { Skeleton } from '@/components/ui/skeleton'
import { Table, TableBody, TableCell, TableRow } from '@/components/ui/table'

interface DataTableSkeletonProps extends React.HTMLAttributes<HTMLDivElement> {
  columnCount: number
  rowCount?: number
  searchableColumnCount?: number
  filterableColumnCount?: number
  showViewOptions?: boolean
  cellWidths?: string[]
  withPagination?: boolean
  shrinkZero?: boolean
}

export function DataTableSkeleton(props: DataTableSkeletonProps) {
  const {
    columnCount,
    rowCount = 10,
    cellWidths = ['auto'],
    shrinkZero = false,
    className,
    ...skeletonProps
  } = props

  return (
    <div
      className={cn('w-full space-y-2.5 overflow-auto', className)}
      {...skeletonProps}
    >
      <Skeleton className="h-5 w-[120px] mb-10" />
      <div className="rounded-md border">
        <Table>
          <TableBody>
            {Array.from({ length: rowCount }).map((_, i) => (
              <TableRow key={i} className="hover:bg-transparent">
                {Array.from({ length: columnCount }).map((_, j) => (
                  <TableCell
                    key={j}
                    style={{
                      width: cellWidths[j],
                      minWidth: shrinkZero ? cellWidths[j] : 'auto',
                    }}
                  >
                    <Skeleton className="h-6 w-full" />
                  </TableCell>
                ))}
              </TableRow>
            ))}
          </TableBody>
        </Table>
      </div>
    </div>
  )
}
