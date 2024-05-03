'use client'
import { Ban, CircleCheck } from 'lucide-react'
import { ColumnDef } from '@tanstack/react-table'
import { User } from 'lucia'
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '../ui/select'
import { roleEnum } from '@/db/schema'
import { startTransition } from 'react'
import { blockUser, deleteUser, updateRole } from '@/actions/user'
import { TrashIcon } from '@radix-ui/react-icons'
import { Button } from '../ui/button'
import { toast } from 'sonner'
import { Badge } from '../ui/badge'

export const columns: ColumnDef<User>[] = [
  {
    accessorKey: 'id',
    header: () => <div className="hidden" />,
    cell: () => <div className="hidden" />,
  },
  {
    accessorKey: 'blocked',
    header: () => <div className="hidden" />,
    cell: () => <div className="hidden" />,
  },
  {
    accessorKey: 'name',
    header: 'Nome',
    cell: ({ row }) => {
      const nome = row.getValue('name') as string
      const blocked = row.getValue('blocked') as boolean
      console.log(blocked)
      return (
        <div>
          {nome}{' '}
          {blocked ? <Badge variant={'destructive'}>Bloqueado</Badge> : null}
        </div>
      )
    },
  },
  {
    accessorKey: 'email',
    header: 'Email',
  },
  {
    accessorKey: 'role',
    header: 'Role',
    cell: ({ row }) => {
      const currentRole = row.getValue('role') as 'ADMIN' | 'SOCIO' | 'MEMBER'
      const userId = row.getValue('id') as string

      return (
        <Select
          defaultValue={currentRole}
          onValueChange={(value) => {
            startTransition(async () => {
              try {
                console.log('aqui')
                await updateRole({
                  userId,
                  role: value as 'ADMIN' | 'SOCIO' | 'MEMBER',
                })
                toast.success('Atualizado com succeso.')
              } catch (err) {
                toast.error('Ocorreu um erro inesperado.')
              }
            })
          }}
        >
          <SelectTrigger className="w-[180px]">
            <SelectValue />
          </SelectTrigger>
          <SelectContent>
            {roleEnum.enumValues.map((item) => (
              <SelectItem className="capitalize" key={item} value={item}>
                {item}
              </SelectItem>
            ))}
          </SelectContent>
        </Select>
      )
    },
  },
  {
    id: 'actions',
    cell: ({ row }) => {
      const userId = row.getValue('id') as string
      const blocked = row.getValue('blocked') as boolean
      return (
        <div className="flex flex-row gap-2">
          <Button
            onClick={() => {
              startTransition(async () => {
                try {
                  await blockUser({ userId })
                  toast.success('Usuário atualizado com succeso.')
                } catch (err) {
                  toast.error('Ocorreu um erro inesperado.')
                }
              })
            }}
            variant={blocked ? 'success' : 'destructive'}
            size={'icon'}
          >
            {blocked ? (
              <CircleCheck className="size-4" />
            ) : (
              <Ban className="size-4" />
            )}
          </Button>
          <Button
            onClick={() => {
              startTransition(async () => {
                try {
                  await deleteUser({ userId })
                } catch (er) {}
              })
            }}
            variant={'destructive'}
            size={'icon'}
          >
            <TrashIcon className="size-4" />
          </Button>
        </div>
      )
    },
  },
]
