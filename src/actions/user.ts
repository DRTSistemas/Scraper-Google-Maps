'use server'

import { db } from '@/db'
import { users } from '@/db/schema'
import { userSchema } from '@/lib/validators/user'
import { eq } from 'drizzle-orm'
import { Scrypt, generateId } from 'lucia'
import { revalidatePath } from 'next/cache'
import { redirect } from 'next/navigation'
import { z } from 'zod'

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

export async function deleteUser({ userId }: { userId: string }) {
  const userExisting = await db.query.users.findFirst({
    where: (table, { eq }) => eq(table.id, userId),
  })

  if (!userExisting) {
    throw new Error('Usuário não existe')
  }

  await db.delete(users).where(eq(users.id, userId))

  revalidatePath('/painel')
}

export async function addUser(input: z.infer<typeof userSchema>) {
  const userWithSameEmail = await db.query.users.findFirst({
    where: (table, { eq }) => eq(table.email, input.email),
  })

  if (userWithSameEmail) {
    throw new Error('Usuário já existe')
  }

  const userId = generateId(21)
  const hashedPassword = await new Scrypt().hash('123456789')
  await db.insert(users).values({
    id: userId,
    name: input.name,
    email: input.email,
    role: input.role,
    hashedPassword,
  })

  redirect('/painel')
}
