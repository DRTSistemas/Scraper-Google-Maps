import { AddUserForm } from '@/components/forms/add-user-form'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
export default async function Page() {
  return (
    <Card className="max-w-3xl">
      <CardHeader>
        <CardTitle>Adicionar usuário</CardTitle>
      </CardHeader>
      <CardContent>
        <AddUserForm />
      </CardContent>
    </Card>
  )
}
