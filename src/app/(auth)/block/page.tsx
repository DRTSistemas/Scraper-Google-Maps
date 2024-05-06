import { buttonVariants } from '@/components/ui/button'
import { Card, CardFooter, CardHeader, CardTitle } from '@/components/ui/card'
import { cn } from '@/lib/utils'
import Link from 'next/link'

export default function BlockedPage() {
  return (
    <Card className="max-w-md w-full">
      <CardHeader>
        <CardTitle className="text-4xl text-center">
          Seu acesso foi bloqueado
        </CardTitle>
      </CardHeader>

      <CardFooter>
        <Link
          target="_blank"
          href={'https://lp.sistemazapplus.com.br/wpp-suporte'}
          className={cn(buttonVariants({ size: 'lg' }), 'w-full')}
        >
          Entrar em contato com o suporte
        </Link>
      </CardFooter>
    </Card>
  )
}
