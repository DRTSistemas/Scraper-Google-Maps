'use client'

import { useEffect } from 'react'
import { useFormState } from 'react-dom'
import Link from 'next/link'
import { useRouter } from 'next/navigation'
import { toast } from 'sonner'
import { Input } from '@/components/ui/input'

import { Label } from '@/components/ui/label'
import { SubmitButton } from '@/components/submit-button'
import { sendPasswordResetLink } from '@/lib/auth/actions'
import { ExclamationTriangleIcon } from '@radix-ui/react-icons'
import { Button } from '@/components/ui/button'

export function SendResetEmail() {
  const [state, formAction] = useFormState(sendPasswordResetLink, null)
  const router = useRouter()

  useEffect(() => {
    if (state?.success) {
      toast('A password reset link has been sent to your email.')
      router.push('/')
    }
    if (state?.error) {
      toast(state.error, {
        icon: <ExclamationTriangleIcon className="h-5 w-5 text-destructive" />,
      })
    }
  }, [state?.error, state?.success])

  return (
    <form className="space-y-4" action={formAction}>
      <div className="space-y-2">
        <Label>Seu email</Label>
        <Input
          required
          placeholder="email@example.com"
          autoComplete="email"
          name="email"
          type="email"
        />
      </div>

      <SubmitButton className="w-full">Redefinir senha</SubmitButton>
      <Button className="w-full" variant={'outline'}>
        <Link href="/">Cancelar</Link>
      </Button>
    </form>
  )
}
