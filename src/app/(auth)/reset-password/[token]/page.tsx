import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
import { ResetPassword } from './reset-password'

export const metadata = {
  title: 'Trocar sua senha',
  description: 'Trocar sua senha',
}

export default function ResetPasswordPage({
  params,
}: {
  params: { token: string }
}) {
  return (
    <Card className="w-full max-w-md">
      <CardHeader className="space-y-1">
        <CardTitle className="text-3xl">Trocar sua senha</CardTitle>
        <CardDescription>
          Digite seu e-mail para obter o link de redefinição.
        </CardDescription>
      </CardHeader>
      <CardContent>
        <ResetPassword token={params.token} />
      </CardContent>
    </Card>
  )
}
