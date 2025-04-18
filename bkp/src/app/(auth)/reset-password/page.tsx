import { redirect } from 'next/navigation'
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
import { SendResetEmail } from './send-reset-email'
import { validateRequest } from '@/lib/auth/validate-request'

export const metadata = {
  title: 'Forgot Password',
  description: 'Forgot Password Page',
}

export default async function ForgotPasswordPage() {
  const { user } = await validateRequest()

  if (user) redirect('/leads')

  return (
    <Card className="w-full max-w-md">
      <CardHeader>
        <CardTitle className="text-3xl">Esqueceu sua senha?</CardTitle>
        <CardDescription>
          O link de redefinição de senha será enviado para seu e-mail.
        </CardDescription>
      </CardHeader>
      <CardContent>
        <SendResetEmail />
      </CardContent>
    </Card>
  )
}
