import { Button } from '@/components/ui/button'
import {
  Card,
  CardContent,
  CardFooter,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'

export default function BlockedPage() {
  return (
    <Card className="max-w-md w-full">
      <CardHeader>
        <CardTitle className="text-4xl text-center">Bloqueado</CardTitle>
      </CardHeader>
      <CardContent>
        <p>Seu acesso foi bloqueado...</p>
      </CardContent>
      <CardFooter>
        <Button className="w-full">Entrar em contato com o suporte</Button>
      </CardFooter>
    </Card>
  )
}
