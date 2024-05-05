'use server'
import { db } from '@/db'
/* eslint @typescript-eslint/no-explicit-any:0, @typescript-eslint/prefer-optional-chain:0 */

import { isWithinExpirationDate, TimeSpan, createDate } from 'oslo'

import {
  LoginInput,
  loginSchema,
  resetPasswordSchema,
} from '../validators/auth'
import { lucia } from '.'
import { Scrypt, generateId } from 'lucia'
import { cookies } from 'next/headers'
import { redirect } from 'next/navigation'
import { validateRequest } from './validate-request'
import { passwordResetTokens, sessions, users } from '@/db/schema'
import { eq } from 'drizzle-orm'
import { z } from 'zod'
import { env } from '@/env'
import { EmailTemplate, sendMail } from '../email'

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
      formError: 'Senha ou email incorretos',
    }
  }

  if (!existingUser || !existingUser?.hashedPassword) {
    return {
      formError: 'Senha ou email incorretos',
    }
  }

  const validPassword = await new Scrypt().verify(
    existingUser.hashedPassword,
    password,
  )
  if (!validPassword) {
    return {
      formError: 'Senha ou email incorretos',
    }
  }

  if (existingUser.blocked) redirect('/block')

  // delete other sessions this user
  await db.delete(sessions).where(eq(sessions.userId, existingUser.id))

  const session = await lucia.createSession(existingUser.id, {})
  const sessionCookie = lucia.createSessionCookie(session.id)
  cookies().set(
    sessionCookie.name,
    sessionCookie.value,
    sessionCookie.attributes,
  )
  return redirect('/leads')
}

export async function logout(): Promise<{ error: string } | void> {
  const { session } = await validateRequest()
  console.log(session)
  if (!session) {
    return {
      error: 'No session found',
    }
  }
  await lucia.invalidateSession(session.id)
  const sessionCookie = lucia.createBlankSessionCookie()
  cookies().set(
    sessionCookie.name,
    sessionCookie.value,
    sessionCookie.attributes,
  )
  return redirect('/')
}

export async function sendPasswordResetLink(
  _: any,
  formData: FormData,
): Promise<{ error?: string; success?: boolean }> {
  const email = formData.get('email')
  const parsed = z.string().trim().email().safeParse(email)
  if (!parsed.success) {
    return { error: 'O e-mail fornecido é inválido.' }
  }
  try {
    const user = await db.query.users.findFirst({
      where: (table, { eq }) => eq(table.email, parsed.data),
    })

    if (!user || !user.emailVerified)
      return { error: 'O e-mail fornecido é inválido.' }

    const verificationToken = await generatePasswordResetToken(user.id)

    const verificationLink = `${env.NEXT_PUBLIC_APP_URL}/reset-password/${verificationToken}`

    await sendMail(user.email, EmailTemplate.PasswordReset, {
      link: verificationLink,
    })

    return { success: true }
  } catch (error) {
    return { error: 'Falha ao enviar e-mail de verificação.' }
  }
}

export async function resetPassword(
  _: any,
  formData: FormData,
): Promise<{ error?: string; success?: boolean }> {
  const obj = Object.fromEntries(formData.entries())

  const parsed = resetPasswordSchema.safeParse(obj)

  if (!parsed.success) {
    const err = parsed.error.flatten()
    return {
      error: err.fieldErrors.password?.[0] ?? err.fieldErrors.token?.[0],
    }
  }
  const { token, password } = parsed.data

  const dbToken = await db.transaction(async (tx) => {
    const item = await tx.query.passwordResetTokens.findFirst({
      where: (table, { eq }) => eq(table.id, token),
    })
    if (item) {
      await tx
        .delete(passwordResetTokens)
        .where(eq(passwordResetTokens.id, item.id))
    }
    return item
  })

  if (!dbToken) return { error: 'Link de redefinição de senha inválido' }

  if (!isWithinExpirationDate(dbToken.expiresAt))
    return { error: 'O link de redefinição de senha expirou.' }

  await lucia.invalidateUserSessions(dbToken.userId)
  const hashedPassword = await new Scrypt().hash(password)
  await db
    .update(users)
    .set({ hashedPassword })
    .where(eq(users.id, dbToken.userId))
  const session = await lucia.createSession(dbToken.userId, {})
  const sessionCookie = lucia.createSessionCookie(session.id)
  cookies().set(
    sessionCookie.name,
    sessionCookie.value,
    sessionCookie.attributes,
  )
  redirect('/leads')
}

async function generatePasswordResetToken(userId: string): Promise<string> {
  await db
    .delete(passwordResetTokens)
    .where(eq(passwordResetTokens.userId, userId))
  const tokenId = generateId(40)
  await db.insert(passwordResetTokens).values({
    id: tokenId,
    userId,
    expiresAt: createDate(new TimeSpan(2, 'h')),
  })
  return tokenId
}
