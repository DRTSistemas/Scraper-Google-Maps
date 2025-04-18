import {
  boolean,
  date,
  index,
  pgEnum,
  serial,
  text,
  timestamp,
  varchar,
} from 'drizzle-orm/pg-core'

import { pgTable } from './utils'

export const roleEnum = pgEnum('role', ['ADMIN', 'SOCIO', 'MEMBER'])

export const users = pgTable(
  'users',
  {
    id: varchar('id', { length: 21 }).primaryKey(),
    email: varchar('email', { length: 255 }).unique().notNull(),
    name: varchar('name', { length: 255 }).notNull(),
    emailVerified: boolean('email_verified').default(false).notNull(),
    hashedPassword: varchar('hashed_password', { length: 255 }),
    avatar: varchar('avatar', { length: 255 }),
    blocked: boolean('blocked').default(false).notNull(),
    role: roleEnum('role').notNull(),
    createdAt: timestamp('created_at').defaultNow().notNull(),
    updatedAt: timestamp('updated_at', { mode: 'date' }).$onUpdate(
      () => new Date(),
    ),
  },
  (t) => ({
    emailIdx: index('user_email_idx').on(t.email),
  }),
)

export type User = typeof users.$inferSelect
export type NewUser = typeof users.$inferInsert

export const sessions = pgTable(
  'sessions',
  {
    id: varchar('id', { length: 255 }).primaryKey(),
    userId: varchar('user_id', { length: 21 }).notNull(),
    expiresAt: timestamp('expires_at', {
      withTimezone: true,
      mode: 'date',
    }).notNull(),
  },
  (t) => ({
    userIdx: index('session_user_idx').on(t.userId),
  }),
)

export const passwordResetTokens = pgTable(
  'password_reset_tokens',
  {
    id: varchar('id', { length: 40 }).primaryKey(),
    userId: varchar('user_id', { length: 21 }).notNull(),
    expiresAt: timestamp('expires_at', {
      withTimezone: true,
      mode: 'date',
    }).notNull(),
  },
  (t) => ({
    userIdx: index('password_token_user_idx').on(t.userId),
  }),
)

export const userRequests = pgTable('user_requests', {
  id: serial('id').primaryKey(),
  userId: varchar('user_id', { length: 21 }).notNull(),
  createdAt: date('createdAt', { mode: 'date' }).notNull(),
})

export const leads = pgTable('leads', {
  id: serial('id').primaryKey(),
  name: text('name'),
  phone: text('phone'),
  category: text('category'),
})
