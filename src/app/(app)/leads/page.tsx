import { validateRequest } from '@/lib/auth/validate-request'
import { redirect } from 'next/navigation'

export default async function Page() {
  const { user } = await validateRequest()
  if (!user) redirect('/')

  if (user.blocked) redirect('/block')

  return <div>{user.email}</div>
}
