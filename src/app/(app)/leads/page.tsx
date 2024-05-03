import { validateRequest } from '@/lib/auth/validate-request'
import { redirect } from 'next/navigation'

export default async function Page() {
  const { user } = await validateRequest()
  if (!user) redirect('/')

  return <div>{user.email}</div>
}
