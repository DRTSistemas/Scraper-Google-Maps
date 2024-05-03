'use server'

import { db } from '@/db'
import { users } from '@/db/schema'
import { eq } from 'drizzle-orm'
import { revalidatePath } from 'next/cache'

export async function updateRole({
  userId,
  role,
}: {
  userId: string
  role: 'ADMIN' | 'SOCIO' | 'MEMBER'
}) {
  const userExisting = await db.query.users.findFirst({
    where: (table, { eq }) => eq(table.id, userId),
  })

  if (!userExisting) {
    throw new Error('Usuário não existe')
  }

  console.log(userId, role)
  await db
    .update(users)
    .set({
      role,
    })
    .where(eq(users.id, userId))

  revalidatePath('/painel')
}
