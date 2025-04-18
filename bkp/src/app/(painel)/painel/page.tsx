import { buttonVariants } from '@/components/ui/button'
import { columns } from '@/components/users-table/columns'

import { db } from '@/db'
import { users } from '@/db/schema'
import Link from 'next/link'

import { DataTable } from '@/components/users-table/data-table'

export default async function Dashboard() {
  const data = await db.select().from(users)

  return (
    <>
      <div className="flex items-center justify-between">
        <h1 className="text-lg font-semibold md:text-2xl">Usuários</h1>
        <Link className={buttonVariants()} href={'/painel/add'}>
          Novo usuário
        </Link>
      </div>
      <DataTable columns={columns} data={data} />
    </>
  )
}
