import { db } from '.'
import { users } from './schema'
import { Scrypt, generateId } from 'lucia'

async function runSeed() {
  console.log('⏳ Running seed...')

  const start = Date.now()

  const userExisting = await db.query.users.findFirst({
    where: (table, { eq }) => eq(users.email, 'admin@drtsistemas.com.br'),
  })

  if (!userExisting) {
    const userId = generateId(21)
    const hashedPassword = await new Scrypt().hash('Drt2022@')
    await db.insert(users).values({
      id: userId,
      email: 'admin@drtsistemas.com.br',
      name: 'DRT Admin',
      hashedPassword,
      emailVerified: true,
      role: 'ADMIN',
    })
  }

  const end = Date.now()

  console.log(`✅ Seed completed in ${end - start}ms`)

  process.exit(0)
}

runSeed().catch((err) => {
  console.error('❌ Seed failed')
  console.error(err)
  process.exit(1)
})
