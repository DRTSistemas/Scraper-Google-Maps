'use client'

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
import { deleteUser, updateRole } from '@/actions/user'
import { TrashIcon } from '@radix-ui/react-icons'
import { Button } from '../ui/button'
import { toast } from 'sonner'

// This type is used to define the shape of our data.
// You can use a Zod schema here if you want.

export const columns: ColumnDef<User>[] = [
  {
    accessorKey: 'id',
    header: () => <div className="hidden" />,
    cell: () => <div className="hidden" />,
  },
  {
    accessorKey: 'name',
    header: 'Nome',
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
    id: 'delete',
    cell: ({ row }) => {
      const userId = row.getValue('id') as string

      return (
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
          <TrashIcon className="size-5" />
        </Button>
      )
    },
  },
]
