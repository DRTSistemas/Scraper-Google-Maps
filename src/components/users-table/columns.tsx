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
import { updateRole } from '@/actions/user'

// This type is used to define the shape of our data.
// You can use a Zod schema here if you want.

export const columns: ColumnDef<User>[] = [
  {
    accessorKey: 'id',
    header: 'Id',
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
                console.log('aqui')
              } catch (err) {
                console.log(err)
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
]
