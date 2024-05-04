import { db } from '@/db'
import { users } from '@/db/schema'
import { Scrypt, generateId } from 'lucia'
import { headers } from 'next/headers'
import { NextResponse } from 'next/server'

export async function POST(request: Request) {
  try {
    const headersList = headers()
    const apiKey = headersList.get('api-key')

    if (!apiKey) {
      return new Response('Unauthorized')
    }

    if (apiKey !== 'KEYDRT') {
      return new Response('Unauthorized')
    }

    const { name, email, role } = await request.json()

    const userWithSameEmail = await db.query.users.findFirst({
      where: (table, { eq }) => eq(table.email, email),
    })

    if (userWithSameEmail) {
      return new Response('User already exist')
    }

    if (!name || !email || !role) {
      return new Response('Unauthorized')
    }

    const userId = generateId(21)
    const hashedPassword = await new Scrypt().hash('123456789')
    const [newUser] = await db
      .insert(users)
      .values({
        id: userId,
        name,
        email,
        role,
        hashedPassword,
      })
      .returning()

    return NextResponse.json({ name: newUser.name, email: newUser.email })
  } catch (error) {
    return new Response('Error')
  }
}
