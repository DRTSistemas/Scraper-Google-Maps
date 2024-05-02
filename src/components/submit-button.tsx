'use client'

import { forwardRef } from 'react'
import { useFormStatus } from 'react-dom'

import { Button, type ButtonProps } from '@/components/ui/button'

const SubmitButton = forwardRef<HTMLButtonElement, ButtonProps>(
  ({ className, children, ...props }, ref) => {
    const { pending } = useFormStatus()
    return (
      <Button ref={ref} {...props} loading={pending} className={className}>
        {children}
      </Button>
    )
  },
)
SubmitButton.displayName = 'SubmitButton'

export { SubmitButton }
