'use server'

import { db } from '@/db'
import { leads } from '@/db/schema'
import { Places } from '@/lib/types'

export async function saveLeads(input: { leads: Places[] }) {
  const data = input.leads.map((lead) => ({
    name: lead.title,
    phone: lead.phoneNumber,
    category: lead.category,
  }))

  await db.insert(leads).values(data)
}
