import { validateRequest } from '@/lib/auth/validate-request'
import { redirect } from 'next/navigation'
import { Places } from './_components/places'
import { db } from '@/db'
import { userRequests } from '@/db/schema'
import { and, count, eq } from 'drizzle-orm'

import { Button } from "@/components/ui/button";
import { Card, CardContent } from "@/components/ui/card";
import { KeyRound } from "lucide-react";

export default async function Page() {
  const { user } = await validateRequest()
  if (!user) redirect('/')

  if (user.blocked) redirect('/blocked')

  const userRequestCount = await db
    .select({ count: count() })
    .from(userRequests)
    .where(
      and(
        eq(userRequests.userId, user.id),
        eq(userRequests.createdAt, new Date()),
      ),
    )

  return (
    <>
      <div className="grid items-center pb-8 pt-6 md:py-8 mx-auto px-4 max-w-6xl gap-0">
        {/* Título */}
        <div className="flex md:flex-row items-start gap-4 justify-between flex-col-reverse">
          <h1 className="text-2xl font-bold leading-[1.1] md:text-3xl">Dashboard</h1>
        </div>

        {/* Cards */}
        <div className="grid grid-cols-3 gap-4 mt-6 w-full max-w-4xl">
          {/* Card 1 */}
          <Card className="bg-gray-800 p-4 rounded-lg">
            <CardContent>
              <p className="text-gray-400 text-sm">Credits last 30 days</p>
              <p className="text-2xl font-bold">16,797</p>
            </CardContent>
          </Card>

          {/* Card 2 */}
          <Card className="bg-gray-800 p-4 rounded-lg">
            <CardContent>
              <p className="text-gray-400 text-sm">Credits last 24 hours</p>
              <p className="text-2xl font-bold">+0</p>
            </CardContent>
          </Card>

          {/* Card 3 */}
          <Card className="bg-gray-800 p-4 rounded-lg">
            <CardContent>
              <p className="text-gray-400 text-sm">Credits left</p>
              <p className="text-2xl font-bold text-red-500">-20</p>
            </CardContent>
          </Card>
        </div>
      </div>
    </>
  )
}
