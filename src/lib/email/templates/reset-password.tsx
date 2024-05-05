import {
  Body,
  Button,
  Container,
  Head,
  Html,
  Preview,
  Section,
  Text,
} from '@react-email/components'
import { APP_TITLE } from '@/lib/constants'

export interface ResetPasswordTemplateProps {
  link: string
}

export const ResetPasswordTemplate = ({ link }: ResetPasswordTemplateProps) => {
  return (
    <Html>
      <Head />
      <Preview>Redefinir sua senha</Preview>
      <Body style={main}>
        <Container style={container}>
          <Section>
            <Text style={title}>{APP_TITLE}</Text>
            <Text style={text}>Olá,</Text>
            <Text style={text}>
              Alguém solicitou recentemente uma alteração de senha do seu{' '}
              {APP_TITLE} conta. Se foi você, você pode definir uma nova senha
              aqui:
            </Text>
            <Button style={button} href={link}>
              Redefinir senha
            </Button>
            <Text style={text}>
              Se você não quiser alterar sua senha ou não solicitar isso, apenas
              ignore e exclua esta mensagem.
            </Text>
            <Text style={text}>
              Para manter sua conta segura, não encaminhe este e-mail para
              ninguém.
            </Text>
            <Text style={text}>Tenha um bom dia!</Text>
          </Section>
        </Container>
      </Body>
    </Html>
  )
}

const main = {
  backgroundColor: '#f6f9fc',
  padding: '10px 0',
}

const container = {
  backgroundColor: '#ffffff',
  border: '1px solid #f0f0f0',
  padding: '45px',
}

const text = {
  fontSize: '16px',
  fontFamily:
    "'Open Sans', 'HelveticaNeue-Light', 'Helvetica Neue Light', 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif",
  fontWeight: '300',
  color: '#404040',
  lineHeight: '26px',
}

const title = {
  ...text,
  fontSize: '22px',
  fontWeight: '700',
  lineHeight: '32px',
}

const button = {
  backgroundColor: '#09090b',
  borderRadius: '4px',
  color: '#fafafa',
  fontFamily: "'Open Sans', 'Helvetica Neue', Arial",
  fontSize: '15px',
  textDecoration: 'none',
  textAlign: 'center' as const,
  display: 'block',
  width: '210px',
  padding: '14px 7px',
}

// const anchor = {
//   textDecoration: "underline",
// };
