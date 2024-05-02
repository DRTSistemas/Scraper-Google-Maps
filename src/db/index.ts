import { env } from '@/env.js'
import { drizzle } from 'drizzle-orm/postgres-js'
import postgres from 'postgres'

import * as schema from './schema'

export const sql = postgres(env.DATABASE_URL)
export const db = drizzle(sql, { schema })
