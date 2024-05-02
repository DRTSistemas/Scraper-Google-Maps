'use server'
import { db } from '@/db'
/* eslint @typescript-eslint/no-explicit-any:0, @typescript-eslint/prefer-optional-chain:0 */

import { LoginInput, loginSchema } from '../validators/auth'
import { lucia } from '.'
import { Scrypt } from 'lucia'
import { cookies } from 'next/headers'
import { redirect } from 'next/navigation'

export interface ActionResponse<T> {
  fieldError?: Partial<Record<keyof T, string | undefined>>
  formError?: string
}

export async function login(
  _: any,
  formData: FormData,
): Promise<ActionResponse<LoginInput>> {
  const obj = Object.fromEntries(formData.entries())

  const parsed = loginSchema.safeParse(obj)
  if (!parsed.success) {
    const err = parsed.error.flatten()
    return {
      fieldError: {
        email: err.fieldErrors.email?.[0],
        password: err.fieldErrors.password?.[0],
      },
    }
  }

  const { email, password } = parsed.data

  const existingUser = await db.query.users.findFirst({
    where: (table, { eq }) => eq(table.email, email),
  })

  if (!existingUser) {
    return {
      formError: 'Incorrect email or password',
    }
  }

  if (!existingUser || !existingUser?.hashedPassword) {
    return {
      formError: 'Incorrect email or password',
    }
  }

  const validPassword = await new Scrypt().verify(
    existingUser.hashedPassword,
    password,
  )
  if (!validPassword) {
    return {
      formError: 'Incorrect email or password',
    }
  }

  const session = await lucia.createSession(existingUser.id, {})
  const sessionCookie = lucia.createSessionCookie(session.id)
  cookies().set(
    sessionCookie.name,
    sessionCookie.value,
    sessionCookie.attributes,
  )
  return redirect('/leads')
}
