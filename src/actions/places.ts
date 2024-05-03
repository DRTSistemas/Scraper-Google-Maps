'use server'

import { db } from '@/db'
import { userRequests } from '@/db/schema'
import { revalidatePath } from 'next/cache'

export async function addNewResquest({ userId }: { userId: string }) {
  await db.insert(userRequests).values({ userId, createdAt: new Date() })

  revalidatePath('/leads')
}
