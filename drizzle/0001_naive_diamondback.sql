ALTER TABLE "contatos_maps_user_requests" ADD COLUMN "date" date NOT NULL;--> statement-breakpoint
ALTER TABLE "contatos_maps_user_requests" DROP COLUMN IF EXISTS "created_at";