import { validateRequest } from '@/lib/auth/validate-request'
import { redirect } from 'next/navigation'
import { Places } from './_components/places'
import { db } from '@/db'
import { userRequests } from '@/db/schema'
import { and, count, eq } from 'drizzle-orm'

export default async function Page() {
  const { user } = await validateRequest()
  if (!user) redirect('/')

  if (user.blocked) redirect('/blocked')

  const userRequestCount = await db
    .select({ count: count() })
    .from(userRequests)
    .where(
      and(
        eq(userRequests.userId, user.id),
        eq(userRequests.createdAt, new Date()),
      ),
    )

  return (
    <Places
      userId={user.id}
      role={user.role}
      requestsToday={userRequestCount[0].count}
    />
  )
}
